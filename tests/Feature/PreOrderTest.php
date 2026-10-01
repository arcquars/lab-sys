<?php

namespace Tests\Feature;

use App\OrderStateLog;
use App\PreOrder;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * IMPORTANTE — comportamiento de aislamiento de datos:
 *
 * Esta suite usa RefreshDatabase (NO DatabaseMigrations). Laravel ejecuta
 * `php artisan migrate --force` UNA sola vez al inicio del primer test
 * y luego envuelve cada método en una transacción con rollback al final.
 *
 * - Las migraciones de este plan SOLO crean tablas (Schema::create) y
 *   agregan FKs salientes. Ninguna hace DROP/TRUNCATE/DELETE.
 * - Los `down()` lanzan RuntimeException (IRREVERSIBLES).
 * - Por lo tanto la BD productiva NO sufre pérdida de datos al correr
 *   esta suite.
 *
 * Si tu entorno CI necesita aislamiento extra, configura DB_DATABASE
 * distinto en .env.testing antes de correr `phpunit`.
 */
class PreOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test' . mt_rand(1, 999999) . '@test.com',
            'password' => Hash::make('hemo321'),
            'active'   => true,
        ]);

        $secretaria = Role::firstOrCreate(['name' => 'secretaria']);
        $user->roles()->attach($secretaria);

        $this->user = $user->fresh();
    }

    private function validPayload(array $overrides = [])
    {
        return array_merge([
            'branch_id' => 'central-oquendo',
            'is_stat'   => false,
            'patient'   => [
                'full_name'  => 'Ana Pérez',
                'age'        => '42 Años',
                'gender'     => 'F',
                'ci'         => '5948302 CBBA',
                'birth_date' => '1984-08-14',
                'diagnosis'  => 'Control',
                'physician'  => 'Dr. X',
            ],
            'tests' => [
                ['id' => 'hem-01', 'test_name' => 'Hemograma completo automatizado', 'category_name' => 'Hematología'],
                ['id' => 'hem-08', 'test_name' => 'Tiempo de Protrombina (TP) + INR', 'category_name' => 'Coagulación'],
            ],
        ], $overrides);
    }

    /** @test */
    public function store_creates_pre_order_with_valid_payload()
    {
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());

        $response->assertStatus(201)
            ->assertJsonStructure(['order_number', 'issued_at']);

        $token = $response->json('order_number');
        $this->assertMatchesRegularExpression('/^ORD-\d{2}-\d{4}$/', $token);
    }

    /** @test */
    public function store_persists_pre_order_row_with_state_nuevo()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload())
            ->assertStatus(201);

        $orderNumber = PreOrder::first()->order_number;

        $this->assertDatabaseHas('pre_orders', [
            'order_number'      => $orderNumber,
            'state'             => 'nuevo',
            'branch_id'         => 'central-oquendo',
            'is_stat'           => false,
            'patient_full_name' => 'Ana Pérez',
            'patient_ci'        => '5948302 CBBA',
            'patient_gender'    => 'F',
            'created_by'        => $this->user->id,
        ]);
    }

    /** @test */
    public function store_persists_initial_state_log_entry()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload())
            ->assertStatus(201);

        $preOrder = PreOrder::first();

        $this->assertDatabaseHas('order_states_log', [
            'pre_order_id'   => $preOrder->id,
            'previous_state' => null,
            'new_state'      => 'nuevo',
            'user_id'        => $this->user->id,
        ]);

        $this->assertSame(1, OrderStateLog::where('pre_order_id', $preOrder->id)->count());
    }

    /** @test */
    public function store_increments_correlative_across_calls()
    {
        $first = $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());
        $first->assertStatus(201);
        $this->assertStringEndsWith('-0001', $first->json('order_number'));

        $second = $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());
        $second->assertStatus(201);
        $this->assertStringEndsWith('-0002', $second->json('order_number'));
    }

    /** @test */
    public function store_persists_tests_snapshot_as_array()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload())
            ->assertStatus(201);

        $preOrder = PreOrder::first();

        $this->assertSame(2, count($preOrder->tests_snapshot));
        $this->assertSame('hem-01', $preOrder->tests_snapshot[0]['id']);
        $this->assertSame('Hematología', $preOrder->tests_snapshot[0]['category_name']);
    }

    /** @test */
    public function store_persists_optional_patient_fields_as_nullable()
    {
        $payload = $this->validPayload();
        unset($payload['patient']['age']);
        unset($payload['patient']['birth_date']);
        unset($payload['patient']['diagnosis']);
        unset($payload['patient']['physician']);

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('pre_orders', [
            'patient_ci'           => '5948302 CBBA',
            'patient_age'          => null,
            'patient_birth_date'   => null,
            'patient_diagnosis'    => null,
            'patient_physician'    => null,
        ]);
    }

    /** @test */
    public function store_returns_401_when_unauthenticated()
    {
        $response = $this->postJson('/pre-orders', $this->validPayload());

        $response->assertStatus(401);
    }

    /** @test */
    public function store_returns_422_when_branch_id_missing()
    {
        $payload = $this->validPayload();
        unset($payload['branch_id']);

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch_id']);
    }

    /** @test */
    public function store_returns_422_when_patient_full_name_missing()
    {
        $payload = $this->validPayload();
        unset($payload['patient']['full_name']);

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['patient.full_name']);
    }

    /** @test */
    public function store_returns_422_when_patient_ci_missing()
    {
        $payload = $this->validPayload();
        unset($payload['patient']['ci']);

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['patient.ci']);
    }

    /** @test */
    public function store_returns_422_when_gender_is_invalid()
    {
        $payload = $this->validPayload();
        $payload['patient']['gender'] = 'X';

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['patient.gender']);
    }

    /** @test */
    public function store_returns_422_when_birth_date_format_is_invalid()
    {
        $payload = $this->validPayload();
        $payload['patient']['birth_date'] = '14/08/1984';

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['patient.birth_date']);
    }

    /** @test */
    public function store_returns_422_when_tests_empty()
    {
        $payload = $this->validPayload();
        $payload['tests'] = [];

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['tests']);
    }

    /** @test */
    public function store_returns_422_when_each_test_lacks_required_fields()
    {
        $payload = $this->validPayload();
        $payload['tests'] = [
            ['category_name' => 'Hematología'],
        ];

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['tests.0.id', 'tests.0.test_name']);
    }

    /** @test */
    public function store_returns_422_when_is_stat_missing()
    {
        $payload = $this->validPayload();
        unset($payload['is_stat']);

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['is_stat']);
    }

    /** @test */
    public function store_accepts_arbitrary_branch_id_without_validation()
    {
        $payload = $this->validPayload();
        $payload['branch_id'] = 'cualquier-string-no-catalogo';

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('pre_orders', [
            'branch_id' => 'cualquier-string-no-catalogo',
        ]);
    }

    /** @test */
    public function store_accepts_arbitrary_test_id_without_validation()
    {
        $payload = $this->validPayload();
        $payload['tests'][0]['id'] = 'XXX-CUSTOM';

        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $payload)
            ->assertStatus(201);

        $preOrder = PreOrder::first();
        $this->assertSame('XXX-CUSTOM', $preOrder->tests_snapshot[0]['id']);
    }

    /** @test */
    public function change_state_records_log_and_updates_state_to_rechasado()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());

        $preOrder = PreOrder::first();
        $preOrder->changeState(PreOrder::STATE_RECHASADO, $this->user->id, 'No procede');

        $this->assertSame('rechasado', $preOrder->fresh()->state);

        $this->assertDatabaseHas('order_states_log', [
            'pre_order_id'   => $preOrder->id,
            'previous_state' => 'nuevo',
            'new_state'      => 'rechasado',
            'user_id'        => $this->user->id,
            'note'           => 'No procede',
        ]);

        $this->assertSame(2, OrderStateLog::where('pre_order_id', $preOrder->id)->count());
    }

    /** @test */
    public function change_state_can_promote_to_creado()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());

        $preOrder = PreOrder::first();
        $preOrder->changeState(PreOrder::STATE_CREADO, $this->user->id);

        $this->assertSame('creado', $preOrder->fresh()->state);
    }

    /** @test */
    public function change_state_throws_for_invalid_transition()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());

        $preOrder = PreOrder::first();
        $preOrder->changeState(PreOrder::STATE_RECHASADO, $this->user->id);
        $preOrder = $preOrder->fresh();

        $this->expectException(\DomainException::class);
        $preOrder->changeState(PreOrder::STATE_CREADO, $this->user->id);
    }

    /** @test */
    public function change_state_rejects_creado_already_terminal()
    {
        $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload());

        $preOrder = PreOrder::first();
        $preOrder->changeState(PreOrder::STATE_CREADO, $this->user->id);
        $preOrder = $preOrder->fresh();

        $this->expectException(\DomainException::class);
        $preOrder->changeState(PreOrder::STATE_NUEVO, $this->user->id);
    }

    /** @test */
    public function issued_at_format_is_iso_8601_with_offset()
    {
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/pre-orders', $this->validPayload())
            ->assertStatus(201);

        $issuedAt = $response->json('issued_at');

        $this->assertNotFalse(\DateTime::createFromFormat(\DateTime::ATOM, $issuedAt)
            ?: \DateTime::createFromFormat('Y-m-d\TH:i:sP', $issuedAt));
    }
}
