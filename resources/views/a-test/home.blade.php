@extends('layouts.dash', ['activePage' => 'atest_index', 'navName' => 'Analisis', 'activeButton' => ''])

@section('content')
    <style>
    .searchResalt{
        background-color: aqua;
    }        
    </style>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Pruebas</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-body ">
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModalCreateGroupTest();"><i class="fas fa-vials"></i> Crear grupo</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModalCreateTest();"><i class="fas fa-vial"></i> Crear Prueba</button>
            <div class="form-group">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                    </div>
                    <input type="text" class="form-control" placeholder="Buscar ..." onchange="searchAtest(this);">
                </div>

            </div>
            <hr>
            <div id="list_group" class="row">
            </div>

            <div class="tree_group">

            </div>
        </div>
    </div>

@endsection
@include('a-test.includes.modals.m_create_group', ['rangeTypeList', $rangeTypeList])
@include('a-test.includes.modals.m_create_test')
@include('a-test.includes.modals.m_edit_test')
@include('a-test.includes.modals.m_delete_test')
@include('a-test.includes.modals.m_delete_test_group')
@include('a-test.includes.modals.m_edit_group')
@push('js')
    <script>
        $(document).ready(function () {
            // loadTestGroup();
            loadTreeTestGroup();
        });

        function loadTestGroup(){
            $("#list_group").empty().append(renderLoading());
            $.ajax({
                url: "{{ route('analysis-test-group.render.list') }}",
                success: function (data) {
                    $("#list_group").empty().append(data);
                }
            });
        }

        function loadTreeTestGroup(){
            $(".tree_group").empty().append(renderLoading());
            $.ajax({
                url: "{{ route('analysis-test-group.render.tree') }}",
                success: function (data) {
                    $(".tree_group").empty().append(data);
                }
            });
        }

        function renderLoading(){
            return '<div style="text-align: center; width: 100%;"><div class="fa-3x"><i class="fas fa-cog fa-spin"></i></div></div>';
        }

        function addTestTypeRange(){
            $.ajax({
                url: "{{ route('analysis-test.render-range-option') }}",
                success: function (data) {
                    $("#rangeListOptions").append(data);
                }
            });
        }

        function addTestTypeRangeNoOrder(){
            $.ajax({
                url: "{{ route('analysis-test.render-range-no-order-option') }}",
                success: function (data) {
                    // alert("sss oo");
                    $("#rangeNoOrderListOptions").append(data);
                }
            });
        }

        function addTestTypeLimit(){
            $.ajax({
                url: "{{ route('analysis-test.render-limit-option') }}",
                success: function (data) {
                    $("#rangeListOptions").append(data);
                }
            });
        }

        function addTestTypeGeneric(){
            $.ajax({
                url: "{{ route('analysis-test.render-generic-option') }}",
                success: function (data) {
                    $("#genericListOptions").append(data);
                }
            });
        }

        function removeTestTypeRange(button){
            $(button).parent().parent().parent().parent().remove();
        }

        function removeTestTypeLimit(button){
            $(button).parent().parent().parent().remove();
        }

        function removeTestTypeGeneric(button){
            $(button).parent().parent().parent().remove();
        }

        function addRangeIntermediary(link, tempId) {
            let intermediary = $(link).prev();
            $.ajax({
                url: "{{ route('analysis-test.render-range-option-intermediary') }}",
                data: {tempId, count: $(intermediary).children().length},
                success: function (data) {
                    $(intermediary).append(data);
                }
            });
        }

        function removeRangeIntermediary(link) {
            $(link).parents().eq(3).remove();
        }

        function searchAtest(input){
            const strSearch = $(input).val().toLowerCase().trim();
            const strLength = strSearch.length;
            let collapseIds = [];
            const testCards = $("#accordionTestGroup .card");
            $("#accordionTestGroup").find(".searchResalt").removeClass("searchResalt");
            if(strLength > 2){
                $.each(testCards, function(){
                    let testNames = $(this).find('.collapse .card-body p');
                    $.each(testNames, function(){
                        let testName = $(this).text().toLowerCase().trim();
                        let contains = testName.includes(strSearch);
                        if(contains){
                            collapseIds.push($(this).parent().parent().attr('id'));
                            $(this).addClass('searchResalt');
                        }
                    });
                });
                const idsUnicos = [...new Set(collapseIds)];
                console.log(idsUnicos);
                // Cerrar todos los collapse
                $.each(testCards, function(){
                    let collapses = $(this).find('.collapse');
                    $.each(collapses, function(){
                        $(this).removeClass('show');
                    });
                });
                // Mostrar solo grupos que se encontraron test
                $.each(testCards, function(){
                    let hidden = true;
                    const collapseTemp = $(this).find('.collapse');
                    $(collapseTemp).parent().show();
                    $.each(idsUnicos, function(index, idColl){ // Usamos el parámetro idColl en lugar de 'this'
                        // Ahora idColl es un string primitivo y el === funcionará
                        if($(collapseTemp).attr('id') === idColl){
                            console.log("ccccc:: ", idColl);
                            hidden = false;
                        }    
                    });
                    if(hidden){
                        $(collapseTemp).parent().hide();
                    }
                    
                });
                // Mostrar collapse
                $.each(idsUnicos, function(i, id) {
                    // Seleccionamos directamente el ID y le ponemos la clase
                    if(id) { 
                        $('#' + id).addClass('show'); 
                    }
                });
                
            } else {
                console.log("mostrar TODO....");
                $.each(testCards, function(){
                    let collapses = $(this).find('.collapse');
                    $.each(collapses, function(){
                        $(this).removeClass('show');
                    });
                });
                $.each(testCards, function(){
                    const collapseTemp = $(this).find('.collapse');
                    $(collapseTemp).parent().show();
                });
            }
        }
    </script>
@endpush
