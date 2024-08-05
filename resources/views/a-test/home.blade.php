@extends('layouts.dash', ['activePage' => 'atest_index', 'navName' => 'Analisis', 'activeButton' => ''])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Pruebas</li>

        </ol>
    </nav>
    @include('a-test.includes.modals.m_create_group', ['rangeTypeList', $rangeTypeList])
    @include('a-test.includes.modals.m_create_test')
    @include('a-test.includes.modals.m_edit_test')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModalCreateGroupTest();"><i class="fas fa-vials"></i> Crear grupo</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModalCreateTest();"><i class="fas fa-vial"></i> Crear Prueba</button>
            <hr>
            <div id="list_group" class="row">
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            loadTestGroup();
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

        function removeTestTypeRange(button){
            $(button).parent().parent().parent().parent().remove();
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
    </script>
@endpush
