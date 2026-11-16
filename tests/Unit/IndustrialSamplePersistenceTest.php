<?php

namespace Tests\Unit;

use App\Analisis;
use App\Http\Controllers\AnalisisController;
use App\Http\Requests\StoreAnalisisPost;
use App\Http\Requests\UpdateAnalisisPost;
use App\User;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tests\Support\IndustrialSampleMemoryConnection;
use Tests\TestCase;

class IndustrialSamplePersistenceTest extends TestCase
{
    private $memory;
    private $originalResolver;
    private $originalDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalResolver = Model::getConnectionResolver();
        $this->originalDatabase = DB::getFacadeRoot();
        $this->memory = new IndustrialSampleMemoryConnection();
        $resolver = new ConnectionResolver(['memory' => $this->memory]);
        $resolver->setDefaultConnection('memory');
        Model::setConnectionResolver($resolver);
        DB::swap($this->memory);
        config(['clinica.convenios_id' => '99']);
        $this->memory->tables['doctores'] = [['id' => 5, 'supervisado' => 0]];
        $this->memory->tables['a_tests'] = [['id' => 7, 'metodo' => 'Método original']];
        $this->actingAs((new User())->forceFill(['id' => 10, 'name' => 'Recepción']));
    }

    protected function tearDown(): void
    {
        Model::setConnectionResolver($this->originalResolver);
        DB::swap($this->originalDatabase);
        parent::tearDown();
    }

    private function payload(array $overrides = [])
    {
        return array_merge([
            'person_id' => 12, 'tipo_analisis' => Analisis::PRUEBA, 'procedencia' => 1,
            'doctor_asignado' => 5, 'doctor' => 'Doctor Solicitante', 'fecha' => '2026-11-10',
            'precio' => 100, 'aTests' => [7], 'is_industrial' => '1', 'edad' => 35,
            'product_name' => ' Agua de proceso ', 'rehearsal_date' => '2026-11-10',
            'manufacture_date' => '', 'expiration_date' => null, 'lot_number' => '001-A',
            'user_id' => 999,
        ], $overrides);
    }

    private function store(array $overrides = [])
    {
        $request = StoreAnalisisPost::create('/analisis', 'POST', $this->payload($overrides));
        $request->setLaravelSession($this->app['session.store']);
        return (new AnalisisController())->store($request);
    }

    private function update(array $payload)
    {
        $request = UpdateAnalisisPost::create('/analisis/1', 'PUT', $payload);
        $request->setLaravelSession($this->app['session.store']);
        return (new AnalisisController())->update($request, 1);
    }

    public function testCreationAndRepeatedEditsKeepOneDetailAndTheOriginalAuthor()
    {
        $response = $this->store();
        $this->assertEquals(url('/clients'), $response->getTargetUrl());
        $analysis = $this->memory->tables['analisis'][0];
        $detail = $this->memory->tables['industrial_exhibition'][0];
        $this->assertEquals(1, $analysis['is_industrial']);
        $this->assertEquals(0, $analysis['edad']);
        $this->assertEquals(12, $analysis['person_id']);
        $this->assertEquals(10, $detail['user_id']);
        $this->assertEquals('Agua de proceso', $detail['product_name']);
        $this->assertNull($detail['manufacture_date']);
        $this->assertEquals(1, $detail['analisis_id']);
        $this->assertCount(1, $this->memory->tables['a_test_results']);
        $this->memory->tables['a_test_results'][0]['result'] = 'Resultado registrado';
        $this->memory->tables['a_test_results'][0]['metodo'] = 'Método registrado';
        $this->actingAs((new User())->forceFill(['id' => 20, 'name' => 'Editor']));

        $this->update($this->payload(['product_name' => 'Aceite']));
        $this->update($this->payload(['product_name' => 'Leche']));
        $this->assertCount(1, $this->memory->tables['industrial_exhibition']);
        $this->assertEquals('Leche', $this->memory->tables['industrial_exhibition'][0]['product_name']);
        $this->assertEquals(10, $this->memory->tables['industrial_exhibition'][0]['user_id']);
        $this->assertEquals($detail['id'], $this->memory->tables['industrial_exhibition'][0]['id']);
        $this->assertEquals('Resultado registrado', $this->memory->tables['a_test_results'][0]['result']);
        $this->assertEquals('Método registrado', $this->memory->tables['a_test_results'][0]['metodo']);
        $this->assertTrue($this->memory->lockedRead);
    }

    public function testClinicalCreationActivationDeactivationAndReactivation()
    {
        $this->store(['is_industrial' => '0']);
        $this->assertEmpty($this->memory->tables['industrial_exhibition'] ?? []);
        $this->assertEquals(35, $this->memory->tables['analisis'][0]['edad']);
        $this->update($this->payload());
        $this->assertCount(1, $this->memory->tables['industrial_exhibition']);
        $this->update($this->payload(['is_industrial' => '0', 'edad' => 40, 'product_name' => 'Ignorado']));
        $this->assertEquals(0, $this->memory->tables['analisis'][0]['is_industrial']);
        $this->assertEquals(40, $this->memory->tables['analisis'][0]['edad']);
        $this->assertEmpty($this->memory->tables['industrial_exhibition']);
        $this->actingAs((new User())->forceFill(['id' => 20, 'name' => 'Editor']));
        $this->update($this->payload(['product_name' => 'Nuevo producto']));
        $this->assertEquals(20, $this->memory->tables['industrial_exhibition'][0]['user_id']);
        $this->assertEquals('Nuevo producto', $this->memory->tables['industrial_exhibition'][0]['product_name']);
    }

    public function testOmittedControlDoesNotDeleteOrOverwriteIndustrialDetail()
    {
        $this->store();
        $detail = $this->memory->tables['industrial_exhibition'];
        $data = $this->payload(['product_name' => 'Ignorado']);
        unset($data['is_industrial'], $data['tipo_analisis']);
        $this->update($data);
        $this->assertEquals($detail, $this->memory->tables['industrial_exhibition']);
        $this->assertEquals(1, $this->memory->tables['analisis'][0]['is_industrial']);
        $this->assertEquals(0, $this->memory->tables['analisis'][0]['edad']);
    }

    public function testFailedCreationRollsBackAnalysisDetailAndLogs()
    {
        $this->memory->failOn = ['industrial_exhibition', 'insert'];
        $before = $this->memory->tables;
        try {
            $this->store();
            $this->fail('Expected a simulated failure');
        } catch (\RuntimeException $e) {
            $this->assertEquals('Simulated persistence failure', $e->getMessage());
        }
        $this->assertEquals($before, $this->memory->tables);
        $this->assertEquals(1, $this->memory->rollbacks);
        $this->assertFalse($this->app['session.store']->has('status'));
    }

    public function testFailedDeactivationAndTestSyncRestorePreviousState()
    {
        $this->store();
        $before = $this->memory->tables;
        $this->memory->failOn = ['industrial_exhibition', 'delete'];
        try {
            $this->update($this->payload(['is_industrial' => '0']));
            $this->fail('Expected a simulated failure');
        } catch (\RuntimeException $e) {
            $this->assertEquals('Simulated persistence failure', $e->getMessage());
        }
        $this->assertEquals($before, $this->memory->tables);

        $this->memory->tables['a_tests'][] = ['id' => 8, 'metodo' => 'Nuevo'];
        $before = $this->memory->tables;
        $this->memory->failOn = ['a_test_results', 'insert'];
        try {
            $this->update($this->payload(['is_industrial' => '0', 'aTests' => [7, 8]]));
            $this->fail('Expected a simulated failure');
        } catch (\RuntimeException $e) {
            $this->assertEquals('Simulated persistence failure', $e->getMessage());
        }
        $this->assertEquals($before, $this->memory->tables);
        $this->assertEquals(2, $this->memory->rollbacks);
        $this->assertFalse($this->app['session.store']->has('success'));
    }

    public function testPreorderAssociationAndStateLogRemainInsideTransaction()
    {
        $this->memory->tables['pre_orders'] = [['id' => 3, 'state' => 'nuevo', 'deleted_at' => null]];
        config(['clinica.pre_order_state_transitions.nuevo' => ['creado']]);
        $this->store(['preOrden' => 3]);
        $this->assertEquals(1, $this->memory->tables['pre_orders'][0]['analisis_id']);
        $this->assertEquals('creado', $this->memory->tables['pre_orders'][0]['state']);
        $this->assertCount(1, $this->memory->tables['order_states_log']);
    }
}
