<?php

namespace Tests\Unit;

use App\Analisis;
use App\IndustrialExhibition;
use App\Institucion;
use App\Person;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Tests\Support\IndustrialSampleMemoryConnection;
use Tests\TestCase;

class IndustrialSampleViewTest extends TestCase
{
    private $originalResolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalResolver = Model::getConnectionResolver();
        $resolver = new ConnectionResolver(['memory' => new IndustrialSampleMemoryConnection()]);
        $resolver->setDefaultConnection('memory');
        Model::setConnectionResolver($resolver);
        $this->actingAs((new User())->forceFill(['id' => 10, 'name' => 'Recepción']));
        $this->app['view']->share('errors', new ViewErrorBag());
        $this->app['request']->setLaravelSession($this->app['session.store']);
    }

    protected function tearDown(): void
    {
        Model::setConnectionResolver($this->originalResolver);
        parent::tearDown();
    }

    private function analysis($industrial = true, $detail = true)
    {
        $analysis = (new Analisis())->forceFill([
            'id' => 1, 'person_id' => 12, 'tipo_analisis' => Analisis::PRUEBA,
            'is_industrial' => $industrial, 'edad' => 0, 'fecha' => '2026-11-10',
            'codigo' => 'LAB-0001', 'internal_code' => 'INT-42', 'doctor' => 'Doctor solicitante',
            'tipo_pago_acuenta' => 'EFECTIVO', 'doctor_asignado' => 5,
        ]);
        $analysis->setRelation('person', (new Person())->forceFill([
            'id' => 12, 'nombres' => 'Ana', 'apellidos' => 'Pérez', 'apellido_materno' => 'López',
            'f_nacimiento' => '1990-02-10', 'sexo' => 'mujer', 'ci' => '12345',
        ]));
        $analysis->setRelation('institucion', new Institucion(['nombre' => 'Institución de prueba']));
        $analysis->setRelation('user', new User(['name' => 'Recepción']));
        $analysis->setRelation('doctorasig', null);
        $analysis->setRelation('convenio', null);
        $analysis->setRelation('industrialExhibition', $detail ? new IndustrialExhibition([
            'product_name' => '<Producto> & ' . str_repeat('X', 235),
            'rehearsal_date' => '2026-11-09', 'lot_number' => '001-A',
            'manufacture_date' => null, 'expiration_date' => '2027-01-31',
        ]) : null);
        return $analysis;
    }

    /** Render the actual child Blade, isolating its content/scripts from the dashboard. */
    private function renderForm($view, array $data)
    {
        $source = file_get_contents(resource_path('views/' . str_replace('.', '/', $view) . '.blade.php'));
        $source = preg_replace('/^@extends\(.*\)\s*$/m', '', $source);
        $compiled = Blade::compileString($source);
        $factory = $this->app['view'];
        $factory->incrementRender();
        $evaluate = function () use ($compiled, $data, $factory) {
            $__env = $factory;
            $errors = new ViewErrorBag();
            extract($data, EXTR_SKIP);
            eval('?>' . $compiled);
        };
        ob_start();
        try {
            $evaluate();
            return $factory->yieldContent('content') . $factory->yieldPushContent('js');
        } finally {
            ob_end_clean();
            $factory->decrementRender();
            $factory->flushState();
        }
    }

    private function formData($analysis = null)
    {
        return [
            'analisis' => $analysis, 'persona' => ($analysis ?: $this->analysis())->person,
            'edad' => 36, 'tipoPagoAcuenta' => Analisis::TIPO_PAGO_ACUENTA,
            'procedencias' => collect(), 'doctores' => collect(), 'selectedATests' => [7],
        ];
    }

    private function xpath($html)
    {
        $document = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        return new \DOMXPath($document);
    }

    public function testBothFormsStartClinicalAndRecoverIndustrialOldInputAfterErrors()
    {
        foreach (['analisis.crear-hemo', 'analisis.crear-hemo-v2'] as $view) {
            $this->app['session.store']->forget('_old_input');
            $html = $this->renderForm($view, $this->formData());
            if (getenv('INDUSTRIAL_SAMPLE_ARTIFACT_DIR')) {
                file_put_contents(getenv('INDUSTRIAL_SAMPLE_ARTIFACT_DIR') . '/' . $view . '.html', $html);
            }
            $xpath = $this->xpath($html);
            $this->assertEquals(0, $xpath->query('//input[@id="is_industrial" and @checked]')->length);
            $this->assertEquals(1, $xpath->query('//input[@name="edad" and not(@disabled)]')->length);
            $this->assertEquals(5, $xpath->query('//div[@id="industrialFields"]//input[@disabled]')->length);
            $this->assertStringContainsString('Ana Pérez López', $html);

            $this->app['session.store']->flashInput([
                'is_industrial' => '1', 'product_name' => 'Producto corregido', 'rehearsal_date' => '2026-11-11',
            ]);
            $html = $this->renderForm($view, $this->formData());
            $xpath = $this->xpath($html);
            $this->assertEquals(1, $xpath->query('//input[@id="is_industrial" and @checked]')->length);
            $this->assertEquals(1, $xpath->query('//input[@name="edad" and @disabled]')->length);
            $this->assertEquals(2, $xpath->query('//div[@id="industrialFields"]//input[@required and not(@disabled)]')->length);
            $this->assertEquals(1, $xpath->query('//input[@name="product_name" and @value="Producto corregido"]')->length);
            $this->assertEquals(2, $xpath->query('//*[@data-clinical-demographic and contains(@class,"d-none")]')->length);
            $this->assertStringContainsString('Cliente:', $html);
            $this->assertStringContainsString('submit.industrial', $html);
        }
    }

    public function testAdvancedEditRestoresSavedValuesAndOldUncheckedStateWins()
    {
        $analysis = $this->analysis();
        $html = $this->renderForm('analisis.crear-hemo-v2', $this->formData($analysis));
        $xpath = $this->xpath($html);
        $this->assertEquals(1, $xpath->query('//input[@id="is_industrial" and @checked]')->length);
        $this->assertEquals(1, $xpath->query('//input[@name="rehearsal_date" and @value="2026-11-09"]')->length);
        $this->assertEquals(1, $xpath->query('//input[@name="edad" and @disabled and @value="'.Carbon::parse('1990-02-10')->age.'"]')->length);

        $this->app['session.store']->flashInput(['is_industrial' => '0', 'edad' => '0']);
        $html = $this->renderForm('analisis.crear-hemo-v2', $this->formData($analysis));
        $xpath = $this->xpath($html);
        $this->assertEquals(0, $xpath->query('//input[@id="is_industrial" and @checked]')->length);
        $this->assertEquals(1, $xpath->query('//input[@name="edad" and not(@disabled) and @value="0"]')->length);
        $this->assertEquals(5, $xpath->query('//div[@id="industrialFields"]//input[@disabled]')->length);
        $this->assertNotNull($analysis->industrialExhibition);
    }

    public function testIndustrialFieldsDisplayValidationMessagesAndOldValues()
    {
        $this->app['session.store']->flashInput(['product_name' => 'Intento anterior']);
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag(['product_name' => ['Producto inválido']]));
        $html = view('analisis.includes.industrial-fields', [
            'analisis' => $this->analysis(), 'isIndustrial' => true, 'errors' => $errors,
        ])->render();
        $this->assertStringContainsString('Intento anterior', $html);
        $this->assertStringContainsString('Producto inválido', $html);
        $this->assertStringContainsString('is-invalid', $html);
    }

    public function testIndustrialReportAndSharedHeaderOmitDemographicsAndEscapeProduct()
    {
        $analysis = $this->analysis();
        $analysis->industrialExhibition->manufacture_date = '2026-01-31';
        foreach (['citologia.partial.cliente-head', 'test.labci.partials.reporte-client'] as $view) {
            $html = view($view, ['analisis' => $analysis, 'showCodeIntPdf' => true])->render();
            $this->assertStringContainsString('Muestra industrial', $html);
            $this->assertStringContainsString('2026-11-09', $html);
            $this->assertStringContainsString('2027-01-31', $html);
            $this->assertStringContainsString('001-A', $html);
            $this->assertStringContainsString('&lt;Producto&gt; &amp;', $html);
            $this->assertStringContainsString('2026-01-31', $html);
            $this->assertStringContainsString('LAB-0001', $html);
            $this->assertStringContainsString('Institución de prueba', $html);
            $this->assertStringNotContainsString('1990-02-10', $html);
            $text = strtoupper(strip_tags(explode('<script', $html)[0]));
            foreach (['EDAD:', 'SEXO:', 'GENERO:', 'NOMBRE PACIENTE:', 'FECHA DE NACIMIENTO:'] as $label) {
                $this->assertStringNotContainsString($label, $text);
            }
            $this->assertStringContainsString('CLIENTE:', $text);
        }
    }

    public function testMissingDetailIsToleratedAndClinicalRenderingKeepsAgeFallback()
    {
        foreach (['citologia.partial.cliente-head', 'test.labci.partials.reporte-client'] as $view) {
            $html = view($view, ['analisis' => $this->analysis(true, false), 'showCodeIntPdf' => false])->render();
            $this->assertStringContainsString('--', $html);
            $this->assertStringContainsString('Muestra industrial', $html);
            $html = view($view, ['analisis' => $this->analysis(false, false), 'showCodeIntPdf' => false])->render();
            $this->assertStringNotContainsString('Muestra industrial', $html);
            $this->assertStringContainsString('FEMENINO', $html);
            $this->assertStringContainsString(Carbon::parse('1990-02-10')->age . ' años', $html);
        }
    }

    public function testLabciHeadersRenderWithMpdfForIndustrialAndClinicalSamples()
    {
        foreach ([true, false] as $industrial) {
            $analysis = $this->analysis($industrial);
            $html = view('test.labci.partials.reporte-style')->render()
                . view('test.labci.partials.reporte-client', [
                    'analisis' => $analysis, 'showCodeIntPdf' => true,
                ])->render();
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Letter',
                'tempDir' => sys_get_temp_dir() . '/hemolab-industrial-pdf-tests',
            ]);
            $mpdf->WriteHTML($html);
            $pdf = $mpdf->Output('', 'S');
            $this->assertStringStartsWith('%PDF-', $pdf);
            $this->assertCount(1, $mpdf->pages);
            if (getenv('INDUSTRIAL_SAMPLE_ARTIFACT_DIR')) {
                $prefix = getenv('INDUSTRIAL_SAMPLE_ARTIFACT_DIR') . '/labci-' . ($industrial ? 'industrial' : 'clinical');
                file_put_contents($prefix . '.html', $html);
                file_put_contents($prefix . '.pdf', $pdf);
            }
        }
    }
}
