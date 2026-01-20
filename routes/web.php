<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', 'HomeController@index');
Route::get('/', function () {
    return redirect('home');
});


Route::get('/index2', function () {
    return redirect('index2');
});

//Route::middleware('guest')->get('/analisis/cerrar_analisis/{analisisId}')->uses('AnalisisController@cerrarAnalisisForId')->name('analisis.cerraranalisis');
Route::middleware(['guest'])->group(function () {
//    Route::get('/analisis/cerrar_analisis/{analisisId}', 'AnalisisController@cerrarAnalisisForId')->name('analisis.cerraranalisis');
//    Route::get('/analisis/cerrar_analisis/{analisisId}', 'QrController@index')->name('analisis.cerraranalisis');
    Route::get('/index2', 'HomeController@index2')->name('index2');
    Route::get('/guest', 'Guest\LoginController@index')->name('guest.home');
    Route::get('/guest/home', 'Guest\LoginController@home')->name('guest.auth.home');
    Route::get('/guest/login', 'Guest\LoginController@login')->name('guest.login');
    Route::post('/guest/post-login', 'Guest\LoginController@postLogin')->name('guest.postlogin');
    Route::post('/guest/post-login-guest', 'Guest\LoginController@postLoginGuest')->name('guest.post.login.guest');
    Route::post('/guest/post-logout-guest', 'Guest\LoginController@postLogoutGuest')->name('guest.post.logout.guest');
});
Route::get('/analisis/cerrar_analisis/{analisisId}', 'QrController@index')->name('analisis.cerraranalisis');
Route::get('/analisis-pdf/{analisisId}', 'QrController@index')->name('analisis.reporte.pdf.public');
Route::get('/analisis/open_resultado_pdf/{analisisId}', 'QrController@openResultadoPdf')->name('analisis.open.esultado.pdf');
Route::get('/analisis/open_recepcion_pdf/{analisisId}', 'QrController@openRecepcionPdf')->name('analisis.open.erecepcion.pdf');
Route::get('/analisis/resultado/{analisisId}', 'QrController@openResultadoPdf')->name('analisis.open.esultado.simple.pdf');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('admin/users', 'Admin\UsersController');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
//    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
    Route::resource('/users', 'UsersController');
    Route::post('/users/a-get-user/{userId}', 'UsersController@aGetUser')->name('ajax.get.user');
    Route::post('/users/a-set-active', 'UsersController@aActiveUser')->name('ajax.user.active');
});

Route::post('/clients/ajaxcreateperson','ClientController@ajaxCreatePerson')->name('client.createPerson');
Route::post('/clients/ajaxgetperson','ClientController@ajaxGetPerson')->name('client.getPerson');
Route::post('/clients/ajax-search-person','ClientController@ajaxSearchPerson')->name('client.searchAjaxPerson');
Route::post('/clients/ajax-set-analisis-person','ClientController@ajaxSetPersonAnalisis')->name('client.ajaxSetPersonAnalisis');
Route::post('/clients/ajax-create-person-analisis','ClientController@ajaxCreatePersonSetAnalisis')->name('client.ajaxCreatePersonSetAnalisis');
Route::post('/clients/ajax-set-doctor-analisis','ClientController@ajaxSetDoctorAnalisis')->name('client.ajaxSetDoctorAnalisis');
Route::get('/clients/delete-duplicados', 'ClientController@deleteDuplicados')->name('client.deleteDuplicados');
Route::post('/clients/delete-duplicados', 'ClientController@pDeleteDuplicados')->name('client.pdeleteDuplicados');
Route::resource('clients', 'ClientController');

Route::get('/get-simple-datatables-data', 'ClientController@getSimpleDatatablesData')->name('simple_datatables_persons_data');
Route::get('/get-custom-column-datatables-data', 'ClientController@getCustomColumnDatatablesData')->name('custom_column_datatables_persons_data');
Route::get('/get-relationship-column-datatables-data', 'ClientController@getRelationshipColumnDatatablesData')->name('relationship_column_datatables_persons_data');
Route::get('/get-extra-data-datatables-attributes-data', 'ClientController@getExtraDataDatatablesAttributesData')->name('get_extra_data_datatables_attributes_data');

Route::resource('analisis', 'AnalisisController');
Route::get('/analisis/crear_analisis/{personId}', 'AnalisisController@crearAnalisisForPersona')->name('analisis.crearanalisis');
Route::get('/analisis/crear_analisis_hemo/{personId}', 'AnalisisController@crearAnalisisHemoForPersona')->name('analisis.crear.analisis.hemo');
Route::get('/analisis/lista_impresiones/{analisisId}', 'AnalisisController@listaImpresion')->name('analisis.lista.impresion');
Route::get('/analisis/lista_ediciones/{analisisId}', 'AnalisisController@listaEdicion')->name('analisis.lista.edicion');
Route::get('/analisis/listByPerson/{personId}', 'AnalisisController@listByPerson')->name('analisis.listByPerson');
Route::get('/analisis/analisisextendido/{analisisId}', 'AnalisisController@crearTipoAnalisis')->name('analisis.analisisextendido');
Route::post('/get-analisis/resultadosatatables-analisis', 'AnalisisController@getDatatablesData')->name('simple_datatables_analisis_data');
Route::get('/analisis/datatables/analisis/tecnico', 'AnalisisController@getDatatablesTecnico')->name('analisis.datatables.tecnico');
Route::get('/get-datatables-analisis-person/{personId}', 'AnalisisController@getDatatablesDataByPersonId')->name('datatableAnalisisPerson');
Route::post('/analisis/resultados', 'AnalisisController@resultados')->name('analisis.resultados');
Route::post('/analisis/aGetCode', 'AnalisisController@ajaxGetCode')->name('analisis.agetcode');
Route::post('/analisis/a-modal-fecha-cierre', 'AnalisisController@ajaxFormFechaCierre')->name('analisis.model.fecha.cierre');
Route::post('/analisis/a-save-fecha-cierre', 'AnalisisController@ajaxSaveFechaCierre')->name('analisis.save.fecha.cierre');
Route::post('/analisis/agetanalisispago', 'AnalisisController@ajaxGetAnalisisPago')->name('analisis.aGetAnalisisPago');
Route::post('/analisis/generar-rango-analisis', 'AnalisisController@ajaxGenerarRango')->name('analisis.generar.rango.analisis');
Route::post('/analisis/crear-generar-rango-analisis', 'AnalisisController@ajaxCrearGenerarRango')->name('analisis.crear.generar.rango.analisis');
Route::post('/analisis/agetanalisis', 'AnalisisController@ajaxGetAnalisisById')->name('analisis.aGetAnalisisById');
Route::post('/analisis/interconsulta/validar-firmas', 'AnalisisController@ajaxInterconsultaValidarFirmas')->name('analisis.interconsultas.validar.firmas');
Route::post('/analisis/agetanalisispaciente', 'AnalisisController@ajaxGetAnalisisPacienteById')->name('analisis.aGetAnalisisPacienteById');
Route::post('/analisis/realizarpago', 'AnalisisController@ajaxRealizarPago')->name('analisis.aSavePago');
Route::post('/analisis/registrar-fecha-entrega', 'AnalisisController@ajaxRegistrarFechaEntrega')->name('analisis.aSaveFechaEntrega');
Route::post('/analisis/registrar-fecha-cierre', 'AnalisisController@ajaxRegistrarFechaCierre')->name('analisis.aSaveFechaCierre');
Route::post('/analisis/enviar-sms-paciente', 'AnalisisController@ajaxEnviarSmsPaciente')->name('analisis.asend.sms.paciente');
Route::post('/analisis/enviar-wapp-paciente', 'AnalisisController@ajaxEnviarWappPaciente')->name('analisis.asend.wapp.paciente');
Route::post('/analisis/obtener-precio', 'AnalisisController@ajaxGetPrecio')->name('analisis.aGetPrecioByAnalisis');
Route::post('/analisis/grabar-precio', 'AnalisisController@ajaxSetPrecio')->name('analisis.aSetPrecioByAnalisis');
Route::post('/analisis/imprimir-firma', 'AnalisisController@ajaxSetImprimirFirma')->name('analisis.aSetImprimirFirma');
Route::post('/analisis-supervisor/imprimir-firma', 'AnalisisSupervisorController@ajaxSetImprimirFirmaSupervisor')->name('analisisSupervisor.aSetImprimirFirmaSupervisor');
Route::post('/analisis/change-to-citologia', 'AnalisisController@ajaxChageToCitologia')->name('analisis.aChangeToCitologia');
Route::post('/analisis/aSearchPaciente', 'AnalisisController@ajaxSearchPaciente')->name('analisis.paciente.search');
Route::post('/analisis/aChangePaciente', 'AnalisisController@ajaxChangePaciente')->name('analisis.paciente.achangepaciente');
Route::post('/analisis/aSearchDoctor', 'AnalisisController@ajaxSearchDoctor')->name('analisis.doctor.asearchdoctor');
Route::post('/analisis/a-search-envia', 'AnalisisController@ajaxSearchEnvia')->name('analisis.doctor.envia');

Route::post('/analisis/grafic-report', 'AnalisisController@ajaxGraficReport')->name('analisis.aGraficReport');

//Route::get('/analisis/cerrar_analisis/{analisisId}', 'AnalisisController@cerrarAnalisisForId')->name('analisis.cerraranalisis');

Route::get('/analisis/lista/tecnico', 'AnalisisController@listaTec')->name('analisis.listatecnico');

Route::get('/analisis/comprobante/{analisisId}', 'AnalisisController@comprobante')->name('analisis.comprobante');

Route::get('/citologia/crear/{analisisId}', 'CitologiaController@create')->name('citologia.crear');
Route::post('/citologia/resultados', 'CitologiaController@resultados')->name('citologia.resultados');
Route::post('/citologia/resultadosedit', 'CitologiaController@resultadosEdit')->name('citologia.resultadosEdit');
Route::get('/citologia/view/{analisisId}', 'CitologiaController@viewResultado')->name('citologia.viewResultado');
Route::get('/citologia/reporte/{analisisId}', 'CitologiaController@reporte')->name('citologia.reporte');
Route::post('/citologia/setTipo', 'CitologiaController@ajaxSetTipo')->name('citologia.asettipo');
Route::post('/citologia/get-subtitulo', 'CitologiaController@ajaxGetSubtitulo')->name('citologia.agetsubtitulo');
Route::post('/citologia/set-subtitulo', 'CitologiaController@ajaxSetSubtitulo')->name('citologia.asetsubtitulo');

Route::get('/biopsia/crear/{analisisId}/{is_histopatologico}', 'BiopsiaController@create')->name('biopsia.crear');
Route::post('/biopsia/save', 'BiopsiaController@store')->name('biopsia.save');
Route::get('/biopsia/view/{analisisId}', 'BiopsiaController@viewResultado')->name('biopsia.viewResultado');
Route::get('/biopsia/reporte/{analisisId}', 'BiopsiaController@reporte')->name('biopsia.reporte');

Route::get('/bethesda/crear/{analisisId}', 'BethesdaController@create')->name('bethesda.crear');
Route::post('/bethesda/save', 'BethesdaController@store')->name('bethesda.save');
Route::get('/bethesda/view/{analisisId}', 'BethesdaController@viewResultado')->name('bethesda.viewResultado');
Route::get('/bethesda/reporte/{analisisId}', 'BethesdaController@reporte')->name('bethesda.reporte');

Route::get('/liquidos/crear/{analisisId}', 'LiquidoController@create')->name('liquidos.crear');
Route::post('/liquidos/save', 'LiquidoController@store')->name('liquidos.save');
Route::get('/liquidos/view/{analisisId}', 'LiquidoController@viewResultado')->name('liquidos.viewResultado');
Route::get('/liquidos/reporte/{analisisId}', 'LiquidoController@reporte')->name('liquidos.reporte');

Route::get('/histo/crear/{analisisId}', 'InmunohistoquimicaController@create')->name('histo.crear');
Route::post('/histo/save', 'InmunohistoquimicaController@store')->name('histo.save');
Route::get('/histo/view/{analisisId}', 'InmunohistoquimicaController@viewResultado')->name('histo.viewResultado');
Route::get('/histo/reporte/{analisisId}', 'InmunohistoquimicaController@reporte')->name('histo.reporte');
Route::post('/histo/marcador/create-ajax', 'InmunohistoquimicaController@aCreateMarker')->name('histo.marker.acreate');

Route::get('/biologia-molecular/crear/{analisisId}', 'BiologiamolecularController@create')->name('biologiam.crear');
Route::post('/biologia-molecular/save', 'BiologiamolecularController@store')->name('biologiam.save');
Route::get('/biologia-molecular/view/{analisisId}', 'BiologiamolecularController@viewResultado')->name('biologiam.viewResultado');
Route::get('/biologia-molecular/reporte/{analisisId}', 'BiologiamolecularController@reporte')->name('biologiam.reporte');

Route::get('/reportes/reporte1', 'ReporteController@reporte1')->name('reporte.reporte1');
Route::post('/reportes/reporte1', 'ReporteController@reportePost')->name('reporte.reportepost');
Route::get('/reportes/reporte-diario', 'ReporteController@reporteDiario')->name('reporte.reporte.diario');
Route::post('/reportes/reporte-diario', 'ReporteController@reporteDiarioPost')->name('reporte.reporte.diario.post');
Route::get('/reportes/reporte-diario-excel/{fechaIni}/{fechaFin}/{procedencia}/{tipo}/{doctor?}', 'ReporteController@excelDiario')->name('reporte.reporte.diario.exceldiario');
Route::get('/reportes/reporte-diario-pdf/{fechaIni}/{fechaFin}/{procedencia}/{tipo}/{doctor?}', 'ReporteController@pdfDiario')->name('reporte.reporte.diario.pdfdiario');
Route::get('/reportes/reporte-admin/{fechaIni}/{fechaFin}/{procedencia}', 'ReporteController@excelAdminDiario')->name('reporte.reporte.diario.excelAdmindiario');
Route::get('/reportes/reporte-facturacion-diario/{fechaIni}/{fechaFin}/{procedencia}', 'ReporteController@excelFacturacion')->name('reporte.reporte_facturacion');
Route::get('/reportes/reporte-admin-diario/{fechaIni}/{fechaFin}/{procedencia}/{doctor?}/{tipoAnalisis?}', 'ReporteController@excelAdmin')->name('reporte.reporte_admin');
Route::get('/reportes/reporte-admin-desechos/{rango}/{tipo_analisis?}', 'ReporteController@excelAdminDesechos')->name('reporte.reporte_admin_desecho');

Route::get('/reportes/reporte2', 'ReporteController@reporte2')->name('reporte.reporte2');
Route::post('/reportes/reporte2', 'ReporteController@reportePost2')->name('reporte.reportepost2');
Route::get('/reportes/reporte-admin-diario', 'ReporteController@reporteAdminDiario')->name('reporte.reporte_admin_diario');
Route::post('/reportes/reporte-admin-diario', 'ReporteController@reporteAdminDiarioPost')->name('reporte.reporte_admin_diario_post');

Route::get('/reportes/reporte-desechar', 'ReporteController@reporteAdminDesechos')->name('reporte.reporte_admin_desechar');
Route::post('/reportes/reporte-desechar', 'ReporteController@reporteAdminDesechosPost')->name('reporte.reporte_admin_desechar_post');

Route::get('/reportes/reporte-sin-terminar', 'ReporteController@reporteAdminSinterminar')->name('reporte.reporte_admin_sinterminar');
Route::post('/reportes/reporte-sin-terminar', 'ReporteController@reporteAdminSinterminarPost')->name('reporte.reporte_admin_sinterminar_post');
Route::get('/reportes/reporte-admin-sinterminar/{rango}/{tipo_analisis?}', 'ReporteController@excelAdminSinterminar')->name('reporte.reporte_admin_sinterminarx');

Route::get('/reportes/reporte-admin-diario-convenio', 'ReporteController@reporteAdminDiarioConvenio')->name('reporte.reporte_admin_diario_convenio');
Route::post('/reportes/reporte-admin-diario-convenio', 'ReporteController@reporteAdminDiarioConvenioPost')->name('reporte.reporte_admin_diario_convenio_post');
Route::get('/reportes/reporte-admin-diario-convenio/{fechaIni}/{fechaFin}', 'ReporteController@excelAdminConvenio')->name('reporte.reporte_admin_convenio');

Route::get('/reportes/reporte-facturacion', 'ReporteController@reporteFacturacion')->name('reporte.reporte_facturacion');
Route::post('/reportes/reporte-facturacion', 'ReporteController@reporteFacturacionPost')->name('reporte.reporte_facturacion_post');

Route::get('/reportes/reporte-diagnostico', 'ReporteController@reporteDiagnostico')->name('reporte.reporte_diagnostico');
Route::post('/reportes/reporte-diagnostico', 'ReporteController@reporteDiagnosticoPost')->name('reporte.reporte_diagnostico_post');

Route::get('/reportes/reporte-cerrados', 'ReporteController@reporteCerrados')->name('reporte.reporte_cerrados');
Route::post('/reportes/reporte-cerrados', 'ReporteController@reporteCerradosPost')->name('reporte.reporte_cerrados_post');

Route::get('/institucion/index', 'InstitucionController@index')->name('institucion.home');
Route::get('/institucion/datatable', 'InstitucionController@getDatatablesData')->name('institucion.datatablesInstitucionData');
Route::post('/institucion/ajaxCrearInstitucion','InstitucionController@ajaxCreateInstitucion')->name('institucion.createInstitucion');
Route::post('/institucion/ajaxgetinstitucion','InstitucionController@ajaxGetInstitucion')->name('institucion.getInstitucion');
Route::post('/institucion/ajax-delete/{id}','InstitucionController@ajaxDestroy')->name('institucion.a-destroy');

Route::get('/doctores/index', 'DoctorController@index')->name('doctores.home');
Route::post('/doctores/ajaxcreatedoctor','DoctorController@ajaxCreateDoctor')->name('doctores.createDoctor');
Route::get('/doctores/datatables-doctores', 'DoctorController@getDatatablesDoctor')->name('doctor.datatables_doctores');
Route::post('/doctores/ajaxgetdoctor','DoctorController@ajaxGetDoctor')->name('doctor.getDoctor');
Route::post('/doctores/ajaxDeleteSigning','DoctorController@ajaxDeleteSigning')->name('doctor.pDeleteSigning');


Route::get('/gastos/index', 'GastoController@index')->name('gastos.home');
Route::post('/gastos/ajaxcreategasto','GastoController@ajaxCreateGasto')->name('gastos.createGasto');
Route::get('/gastos/datatables-gastos', 'GastoController@getDatatablesGasto')->name('gasto.datatables_gastos');

Route::resource('/marcador', 'MarcadorController');
Route::post('/marcador/ajaxsave','DoctorController@ajaxSave')->name('marcador.ajaxsave');
Route::post('/marcador/store-marker','MarcadorController@aStore')->name('marcador.astore');
Route::post('/marcador/delete-marker','MarcadorController@aDelete')->name('marcador.adelete');
Route::get('/market/datatables-marcadores', 'MarcadorController@getDatatablesMarkets')->name('marcador.datatables_marcadores');
Route::post('/marcador/ajaxgetmarker','MarcadorController@ajaxGetMarker')->name('marcador.getmarket');
Route::post('/marcador/aSearchMarker', 'MarcadorController@ajaxSearchMarker')->name('marker.asearch');
Route::post('/marcador/a-marker-delete', 'MarcadorController@ajaxDeleteMarker')->name('marcador.ajax.delete');
Route::post('/marcador/a-get-markers', 'MarcadorController@ajaxGetMarkers')->name('marcador.ajax.get.markers');
Route::post('/marcador/a-sort-markers', 'MarcadorController@ajaxSortMarkers')->name('marcador.ajax.sort.markers');

Route::post('/texto-predefinido/ajaxgettexto','TextoPredefinidoController@ajaxGetTexto')->name('textopredefinido.agettexto');
Route::post('/texto-predefinido/ajax-crear-text','TextoPredefinidoController@ajaxCreateTexto')->name('textopredefinido.acreatetexto');
Route::post('/texto-predefinido/ajax-delete-text','TextoPredefinidoController@ajaxDeleteTexto')->name('textopredefinido.adeletetexto');
Route::get('/texto-predefinido/datatable', 'TextoPredefinidoController@getDatatablesData')->name('textopredefinido.datatablesTextopredefinidoData');
Route::resource('/texto-predefinido', 'TextoPredefinidoController');

Route::get('/invitado/index', 'InvitadoController@index')->name('invitado.index');
Route::post('/invitado/resultados-atatables-analisis', 'InvitadoController@getDatatablesData')->name('invitado.simple.datatables.analisis.data');

Route::get('/invitado-admin/index', 'InvitadoAdminController@index')->name('invitado.admin.index');
Route::post('/invitado-admin/ajaxSearchDr','InvitadoAdminController@ajaxSearcDr')->name('invitado.admin.searchdr');
Route::post('/invitado-admin/ajaxAsignarAnalisis','InvitadoAdminController@ajaxAsignarAnalisis')->name('invitado.admin.asignaranalisis');
Route::post('/invitado-admin/ajaxRetirarAnalisis','InvitadoAdminController@ajaxRetirarAnalisis')->name('invitado.admin.retiraranalisis');
Route::post('/invitado-admin/ajaxGetDrByUser','InvitadoAdminController@ajaxGetDrByDoctor')->name('invitado.admin.getdrbyuser');
Route::post('/invitado-admin/ajax-remove-analisis-doctor','InvitadoAdminController@ajaxRemoveByDoctor')->name('invitado.admin.removeAnalisisDoctor');
Route::get('/invitado-admin/analisis-asignado/{user_id}','InvitadoAdminController@analisisAsignado')->name('invitado.admin.analisis.asignado');
Route::post('/invitado-admin/ajaxObtenerAnalisisAsignados','InvitadoAdminController@ajaxObtenerAnalisisAsignado')->name('invitado.admin.obteneranalisis.asignados');
Route::post('/invitado-admin/ajaxAsignarAnalisisProcedencia','InvitadoAdminController@ajaxAsignarAnalisisProcedencia')->name('invitado.admin.asignaranalisis.procedencia');
Route::post('/invitado-admin/resultados-atables-analisis', 'InvitadoAdminController@getDatatablesData')->name('invitadoadmin.simple.datatables.analisis.data');

Route::post('/analisis/supervisor/getdata', 'AnalisisSupervisorController@ajaxData')->name('analisis.supervisor.data');
Route::post('/analisis/supervisor/change', 'AnalisisSupervisorController@ajaxChange')->name('analisis.supervisor.change');
Route::post('/analisis/supervisores/getdata', 'AnalisisSupervisorController@ajaxGetSupervisores')->name('analisis.supervisores.data');
Route::post('/analisis/supervisores/change', 'AnalisisSupervisorController@ajaxSaveSupervisores')->name('analisis.supervisores.change');
Route::post('/analisis/supervisores/set-estado', 'AnalisisSupervisorController@ajaxSaveEstado')->name('analisis.supervisores.setEstado');

Route::get('/analisis-test', 'AnalisisTestController@index')->name('analisis-test.home');
Route::get('/analisis-test/get-group-type', 'AnalisisTestController@getGroupAndType')->name('analisis-test.get-group-type');
Route::get('/analisis-test/render-test-group-form', 'AnalisisTestController@renderTestGroupForm')->name('analisis-test.render-test-group-form');
Route::get('/analisis-test/render-test-form', 'AnalisisTestController@renderTestForm')->name('analisis-test.render-test-form');
Route::get('/analisis-test/render-test-form-delete', 'AnalisisTestController@renderTestFormDelete')->name('analisis-test.render-test-form-delete');
Route::get('/analisis-test/render-test-group-form-delete', 'AnalisisTestController@renderTestGroupFormDelete')->name('analisis-test.render-test-group-form-delete');
Route::get('/analisis-test/render-test-type', 'AnalisisTestController@renderTestType')->name('analysis-test.render-test-type');
Route::get('/analisis-test/render-range-option', 'AnalisisTestController@renderRangeOption')->name('analysis-test.render-range-option');
Route::get('/analisis-test/render-range-option-intermediary', 'AnalisisTestController@renderRangeOptionIntermediary')->name('analysis-test.render-range-option-intermediary');
Route::get('/analisis-test/render-range-no-order-option', 'AnalisisTestController@renderRangeNoOrderOption')->name('analysis-test.render-range-no-order-option');
Route::get('/analisis-test/render-limit-option', 'AnalisisTestController@renderLimitOption')->name('analysis-test.render-limit-option');
Route::get('/analisis-test/render-generic-option', 'AnalisisTestController@renderGenericOption')->name('analysis-test.render-generic-option');
Route::post('/analisis-test/store-test', 'AnalisisTestController@store')->name('analysis-test.store.test');
Route::post('/analisis-test/update-test', 'AnalisisTestController@update')->name('analysis-test.update.test');
Route::post('/analisis-test/delete-test', 'AnalisisTestController@destroy')->name('analysis-test.delete.test');
Route::post('/analisis-test/delete-test-group', 'AnalisisTestController@testGroupDestroy')->name('analysis-test.delete.test-group');
Route::post('/analisis-test/a-search', 'AnalisisTestController@ajaxSearch')->name('analisis.test.asearch');
Route::post('/analisis-test/a-search-set-id/{atest}', 'AnalisisTestController@ajaxSearchSetid')->name('analisis.test.asearch.setid');
Route::post('/analisis-test/a-search-set-ids', 'AnalisisTestController@ajaxSearchSetids')->name('analisis.test.asearch.setids');


/** Analisis Test Group */
Route::get('/analysis-test-group/render-form-group', 'AnalysisTestGroupController@renderGroupForm')->name('analysis-test-group.render.form');
Route::get('/analysis-test-group/render-list-groups', 'AnalysisTestGroupController@renderListGroups')->name('analysis-test-group.render.list');
Route::get('/analysis-test-group/render-tree-groups', 'AnalysisTestGroupController@renderTreeGroups')->name('analysis-test-group.render.tree');
Route::get('/analysis-test-group/render-tree-groups-select', 'AnalysisTestGroupController@renderTreeGroupsSelect')->name('analysis-test-group.render.tree.selected');
Route::get('/analysis-test-group/render-list-groups-select', 'AnalysisTestGroupController@renderListGroupsTestSelect')->name('analysis-test-group.render.list.selected');
Route::post('/analysis-test-group/update-group', 'AnalysisTestGroupController@update')->name('analysis-test-group.update_group');
Route::resource('/analysis-test-group', 'AnalysisTestGroupController');

Route::get('/test/crear/{analysisId}', 'TestController@create')->name('test.crear');
Route::post('/test/save', 'TestController@store')->name('test.save');
Route::get('/test/view/{analisisId}', 'TestController@viewResultado')->name('test.viewResultado');
Route::get('/test/reporte/{analisisId}/{sin?}', 'TestController@reporte')->name('test.reporte');

// SIAT
Route::get('/siat/invoicing/{analysisId}', 'SiatController@invoicing')->name('siat.invoicing');
Route::post('/siat/invoicing/a-send-invoice', 'SiatController@ajaxSendInvoide')->name('siat.a_send_invoice');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('finance', 'Admin\FinanceController@index')->name('finance.index');
    Route::get('finance/create', 'Admin\FinanceController@create')->name('finance.create');
    Route::post('finance', 'Admin\FinanceController@store')->name('finance.store');
    Route::delete('finance/{id}', 'Admin\FinanceController@destroy')->name('finance.destroy');
});