<?php

namespace Tests\Feature\Api;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Crea un usuario admin activo con su rol 'admin' asociado.
     */
    protected function makeAdminUser(array $overrides = [])
    {
        $user = User::create(array_merge([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => Hash::make('hemo321'),
            'active'   => true,
        ], $overrides));

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->attach($role);

        return $user->fresh();
    }

    /**
     * Crea un usuario con rol no-admin (secretaria por defecto).
     */
    protected function makeNonAdminUser($roleName = 'secretaria', array $overrides = [])
    {
        $user = User::create(array_merge([
            'name'     => 'Secre Test',
            'email'    => 'secre@test.com',
            'password' => Hash::make('hemo321'),
            'active'   => true,
        ], $overrides));

        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->roles()->attach($role);

        return $user->fresh();
    }

    /** @test */
    public function login_with_valid_admin_credentials_returns_token()
    {
        $this->makeAdminUser();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email']]);

        $token = $response->json('token');
        $this->assertIsString($token);
        $this->assertSame(60, strlen($token));

        $this->assertDatabaseHas('users', [
            'email'     => 'admin@test.com',
            'api_token' => $token,
        ]);
    }

    /** @test */
    public function login_persists_token_on_user_model()
    {
        $user = $this->makeAdminUser();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);

        $token = $response->json('token');
        $user->refresh();

        $this->assertSame($token, $user->api_token);
        $this->assertNotNull($user->api_token);
    }

    /** @test */
    public function login_overwrites_previous_token()
    {
        $user = $this->makeAdminUser();
        $user->forceFill(['api_token' => 'old-token-123'])->save();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(200);
        $user->refresh();
        $this->assertNotSame('old-token-123', $user->api_token);
        $this->assertNotNull($user->api_token);
    }

    /** @test */
    public function login_with_wrong_password_returns_422()
    {
        $this->makeAdminUser();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function login_with_unknown_email_returns_422()
    {
        $this->makeAdminUser();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'ghost@test.com',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function login_request_validation_fails_when_payload_incomplete()
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function login_with_non_email_string_returns_422()
    {
        $this->makeAdminUser();

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'not-an-email',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function login_with_inactive_admin_returns_403()
    {
        $this->makeAdminUser(['active' => false]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Usuario inactivo.']);

        $this->assertDatabaseHas('users', [
            'email'     => 'admin@test.com',
            'api_token' => null,
        ]);
    }

    /** @test */
    public function login_with_non_admin_role_returns_403()
    {
        $this->makeNonAdminUser('secretaria');

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'secre@test.com',
            'password' => 'hemo321',
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'No autorizado para emitir tokens API.']);

        $this->assertDatabaseHas('users', [
            'email'     => 'secre@test.com',
            'api_token' => null,
        ]);
    }

    /** @test */
    public function api_user_endpoint_returns_user_data_with_valid_bearer_token()
    {
        $this->makeAdminUser();

        $loginResponse = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);
        $token = $loginResponse->json('token');

        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User data retrieved successfully',
            ])
            ->assertJsonPath('user.email', 'admin@test.com');
    }

    /** @test */
    public function api_user_endpoint_returns_401_without_bearer_token()
    {
        $response = $this->getJson('/api/user', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    /** @test */
    public function api_user_endpoint_returns_401_with_invalid_bearer_token()
    {
        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . str_repeat('x', 60),
            'Accept'        => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function logout_revokes_token_and_next_requests_get_401()
    {
        $this->makeAdminUser();

        $loginResponse = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);
        $token = $loginResponse->json('token');

        $firstCall = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]);
        $firstCall->assertStatus(200);

        $logoutResponse = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]);
        $logoutResponse->assertStatus(200)
            ->assertJson(['message' => 'Token revocado.']);

        $this->assertDatabaseHas('users', [
            'email'     => 'admin@test.com',
            'api_token' => null,
        ]);

        $secondCall = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . 'wrong-token',
            'Accept'        => 'application/json',
        ]);
        $secondCall->assertStatus(401);
    }

    /** @test */
    public function logout_without_bearer_returns_401()
    {
        $response = $this->postJson('/api/auth/logout', [], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function api_token_is_hidden_in_user_json_response()
    {
        $this->makeAdminUser();

        $loginResponse = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'hemo321',
        ]);
        $token = $loginResponse->json('token');

        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]);

        $response->assertStatus(200);

        $serialized = json_encode($response->json('user'));
        $this->assertStringNotContainsString($token, $serialized);
        $this->assertStringNotContainsString('api_token', $serialized);
    }
}
