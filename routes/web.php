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

Route::get('/get-simple-datatables-data', 'ClientController@getSimpleDatatablesData')->name('simple_datatables_persons_data');
Route::get('/get-custom-column-datatables-data', 'ClientController@getCustomColumnDatatablesData')->name('custom_column_datatables_persons_data');
Route::get('/get-relationship-column-datatables-data', 'ClientController@getRelationshipColumnDatatablesData')->name('relationship_column_datatables_persons_data');
Route::get('/get-extra-data-datatables-attributes-data', 'ClientController@getExtraDataDatatablesAttributesData')->name('get_extra_data_datatables_attributes_data');

Route::resource('analisis', 'AnalisisController');
Route::get('/analisis/crear_analisis/{personId}', 'AnalisisController@crearAnalisisForPersona')->name('analisis.crearanalisis');
Route::get('/analisis/listByPerson/{personId}', 'AnalisisController@listByPerson')->name('analisis.listByPerson');
Route::get('/analisis/analisisextendido/{analisisId}', 'AnalisisController@crearTipoAnalisis')->name('analisis.analisisextendido');
Route::get('/get-analisis/resultadosatatables-analisis', 'AnalisisController@getDatatablesData')->name('simple_datatables_analisis_data');
Route::get('/get-datatables-analisis-person/{personId}', 'AnalisisController@getDatatablesDataByPersonId')->name('datatableAnalisisPerson');
Route::post('/analisis/resultados', 'AnalisisController@resultados')->name('analisis.resultados');

Route::get('/citologia/crear/{analisisId}', 'CitologiaController@create')->name('citologia.crear');
Route::post('/citologia/resultados', 'CitologiaController@resultados')->name('citologia.resultados');
Route::get('/citologia/view/{analisisId}', 'CitologiaController@viewResultado')->name('citologia.viewResultado');