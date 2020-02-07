<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('admin/users', 'Admin\UsersController');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
//    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
    Route::resource('/users', 'UsersController');
});

Route::resource('clients', 'ClientController');
Route::post('/clients/ajaxcreateperson','ClientController@ajaxCreatePerson')->name('client.createPerson');
Route::post('/clients/ajaxgetperson','ClientController@ajaxGetPerson')->name('client.getPerson');
Route::post('/clients/ajax-search-person','ClientController@ajaxSearchPerson')->name('client.searchAjaxPerson');

Route::get('/get-simple-datatables-data', 'ClientController@getSimpleDatatablesData')->name('simple_datatables_persons_data');
Route::get('/get-custom-column-datatables-data', 'ClientController@getCustomColumnDatatablesData')->name('custom_column_datatables_persons_data');
Route::get('/get-relationship-column-datatables-data', 'ClientController@getRelationshipColumnDatatablesData')->name('relationship_column_datatables_persons_data');
Route::get('/get-extra-data-datatables-attributes-data', 'ClientController@getExtraDataDatatablesAttributesData')->name('get_extra_data_datatables_attributes_data');

Route::resource('analisis', 'AnalisisController');
Route::get('/analisis/crear_analisis/{personId}', 'AnalisisController@crearAnalisisForPersona')->name('analisis.crearanalisis');
Route::get('/analisis/listByPerson/{personId}', 'AnalisisController@listByPerson')->name('analisis.listByPerson');
Route::get('/analisis/analisisextendido/{analisisId}', 'AnalisisController@crearTipoAnalisis')->name('analisis.analisisextendido');
Route::get('/get-analisis/resultadosatatables-analisis', 'AnalisisController@getDatatablesData')->name('simple_datatables_analisis_data');
Route::get('/analisis/datatables/analisis/tecnico', 'AnalisisController@getDatatablesTecnico')->name('analisis.datatables.tecnico');
Route::get('/get-datatables-analisis-person/{personId}', 'AnalisisController@getDatatablesDataByPersonId')->name('datatableAnalisisPerson');
Route::post('/analisis/resultados', 'AnalisisController@resultados')->name('analisis.resultados');
Route::post('/analisis/aGetCode', 'AnalisisController@ajaxGetCode')->name('analisis.agetcode');
Route::post('/analisis/agetanalisispago', 'AnalisisController@ajaxGetAnalisisPago')->name('analisis.aGetAnalisisPago');
Route::post('/analisis/realizarpago', 'AnalisisController@ajaxRealizarPago')->name('analisis.aSavePago');
Route::post('/analisis/registrar-fecha-entrega', 'AnalisisController@ajaxRegistrarFechaEntrega')->name('analisis.aSaveFechaEntrega');
Route::post('/analisis/registrar-fecha-cierre', 'AnalisisController@ajaxRegistrarFechaCierre')->name('analisis.aSaveFechaCierre');

Route::get('/analisis/lista/tecnico', 'AnalisisController@listaTec')->name('analisis.listatecnico');

Route::get('/analisis/comprobante/{analisisId}', 'AnalisisController@comprobante')->name('analisis.comprobante');

Route::get('/citologia/crear/{analisisId}', 'CitologiaController@create')->name('citologia.crear');
Route::post('/citologia/resultados', 'CitologiaController@resultados')->name('citologia.resultados');
Route::post('/citologia/resultadosedit', 'CitologiaController@resultadosEdit')->name('citologia.resultadosEdit');
Route::get('/citologia/view/{analisisId}', 'CitologiaController@viewResultado')->name('citologia.viewResultado');
Route::get('/citologia/reporte/{analisisId}', 'CitologiaController@reporte')->name('citologia.reporte');

Route::get('/biopsia/crear/{analisisId}', 'BiopsiaController@create')->name('biopsia.crear');
Route::post('/biopsia/save', 'BiopsiaController@store')->name('biopsia.save');
Route::get('/biopsia/view/{analisisId}', 'BiopsiaController@viewResultado')->name('biopsia.viewResultado');
Route::get('/biopsia/reporte/{analisisId}', 'BiopsiaController@reporte')->name('biopsia.reporte');

Route::get('/histo/crear/{analisisId}', 'InmunohistoquimicaController@create')->name('histo.crear');
Route::post('/histo/save', 'InmunohistoquimicaController@store')->name('histo.save');
Route::get('/histo/view/{analisisId}', 'InmunohistoquimicaController@viewResultado')->name('histo.viewResultado');
Route::get('/histo/reporte/{analisisId}', 'InmunohistoquimicaController@reporte')->name('histo.reporte');

Route::get('/reportes/reporte1', 'ReporteController@reporte1')->name('reporte.reporte1');
Route::post('/reportes/reporte1', 'ReporteController@reportePost')->name('reporte.reportepost');
Route::get('/reportes/reporte-diario', 'ReporteController@reporteDiario')->name('reporte.reporte.diario');
Route::post('/reportes/reporte-diario', 'ReporteController@reporteDiarioPost')->name('reporte.reporte.diario.post');
Route::get('/reportes/reporte-diario-excel/{fechaIni}/{fechaFin}/{procedencia}/{tipo}', 'ReporteController@excelDiario')->name('reporte.reporte.diario.exceldiario');
Route::get('/reportes/reporte-admin/{fechaIni}/{fechaFin}/{procedencia}', 'ReporteController@excelAdminDiario')->name('reporte.reporte.diario.excelAdmindiario');
Route::get('/reportes/reporte-admin-diario/{fechaIni}/{fechaFin}/{procedencia}', 'ReporteController@excelAdmin')->name('reporte.reporte_admin');


Route::get('/reportes/reporte2', 'ReporteController@reporte2')->name('reporte.reporte2');
Route::post('/reportes/reporte2', 'ReporteController@reportePost2')->name('reporte.reportepost2');
Route::get('/reportes/reporte-admin-diario', 'ReporteController@reporteAdminDiario')->name('reporte.reporte_admin_diario');
Route::post('/reportes/reporte-admin-diario', 'ReporteController@reporteAdminDiarioPost')->name('reporte.reporte_admin_diario_post');

Route::get('/reportes/reporte-cerrados', 'ReporteController@reporteCerrados')->name('reporte.reporte_cerrados');
Route::post('/reportes/reporte-cerrados', 'ReporteController@reporteCerradosPost')->name('reporte.reporte_cerrados_post');

Route::get('/institucion/index', 'InstitucionController@index')->name('institucion.home');
Route::get('/institucion/datatable', 'InstitucionController@getDatatablesData')->name('institucion.datatablesInstitucionData');
Route::post('/institucion/ajaxCrearInstitucion','InstitucionController@ajaxCreateInstitucion')->name('institucion.createInstitucion');
Route::post('/institucion/ajaxgetinstitucion','InstitucionController@ajaxGetInstitucion')->name('institucion.getInstitucion');

Route::get('/doctores/index', 'DoctorController@index')->name('doctores.home');
Route::post('/doctores/ajaxcreatedoctor','DoctorController@ajaxCreateDoctor')->name('doctores.createDoctor');
Route::get('/doctores/datatables-doctores', 'DoctorController@getDatatablesDoctor')->name('doctor.datatables_doctores');
Route::post('/doctores/ajaxgetdoctor','DoctorController@ajaxGetDoctor')->name('doctor.getDoctor');


Route::get('/gastos/index', 'GastoController@index')->name('gastos.home');
Route::post('/gastos/ajaxcreategasto','GastoController@ajaxCreateGasto')->name('gastos.createGasto');
Route::get('/gastos/datatables-gastos', 'GastoController@getDatatablesGasto')->name('gasto.datatables_gastos');