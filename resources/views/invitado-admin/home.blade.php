@extends('layouts.dash', ['activePage' => 'invitados_admin_users', 'title' => 'Invitado Admin', 'navName' => 'Invitado Analisis', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Invitados admin</li>
{{--            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Usuarios</a></li>--}}
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista de invitados</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-full-width table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="{{route('invitado.admin.analisis.asignado', [$user->id])}}" class="btn btn-success btn-sm" title="Lista de analisis"><i class="fas fa-microscope"></i></a>&nbsp;
                                <a href="#" class="btn btn-success btn-sm" onclick="openSearchAnalisis('{{$user->id}}', '{{$user->name}}')" title="Anadir analisis a invitado"><i class="fas fa-folder-plus"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal buscar analisis -->
    <div class="modal fade" id="searchAnalisisModal" tabindex="-1" aria-labelledby="searchAnaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form onsubmit="fAsignarDr(this); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchAnaModalLabel">Asignar analisis a <span id="mtitleName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" id="inputUserId" name="user_id">
                    <div class="form-row align-items-center">
                        <div class="col-sm-10 my-1">
                            <label class="sr-only" for="inlineFormInputBuscar">Buscar</label>
                            <input type="text" class="form-control" id="inputBuscarDr" placeholder="Buscar por doctor" autocomplete="off">
                        </div>
                        <div class="col-sm-2 my-1">
                            <button type="button" onclick="searchAnalisis()" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <br>
                    <table class="table" id="tResultDr">
                        <thead>
                        <tr>
                            <th>Nombres</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function openSearchAnalisis(userId, name) {
            $("#searchAnalisisModal").modal('show');
            $("#mtitleName").empty().text(name);
            $("#inputBuscarDr").val('');
            $("#tResultDr tbody").empty();
            $("#searchAnalisisModal input[name='user_id']").val(userId);
        }

        function searchAnalisis() {
            let searchText = $('#inputBuscarDr').val();
            if(searchText !== '' && searchText.length > 3){
                $.ajax({
                    url: "{{ route('invitado.admin.searchdr') }}",
                    type: 'POST',
                    data: {user_id: $("#inputUserId").val(), search: searchText},
                    success: function (data) {
                        console.log(JSON.stringify(data));
                        $("#tResultDr tbody").empty().append(appendTableResult(data.analisis));
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            } else {
                alert('Texto muy corto!');
            }

        }

        function fAsignarDr(form){
            let checkedAry = [];
            $.each($('#searchAnalisisModal input[name="doctores[]"]:checked'), function(index, check){
                checkedAry.push($(check).val());
            });
            console.log(checkedAry);
            $.ajax({
                url: "{{ route('invitado.admin.asignaranalisis') }}",
                type: 'POST',
                data: {user_id: $("#inputUserId").val(), doctores: checkedAry},
                success: function (data) {
                    console.log(JSON.stringify(data));
                    $("#searchAnalisisModal").modal('hide');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        }

        function appendTableResult(results){
            let html = '';
            $.each(results, function(i, analisis){
                html += '<tr>';
                html += '<td>'+analisis.doctor+'</td>';
                html += '<td><input type="checkbox" name="doctores[]" value="'+analisis.doctor+'"></td>';
                html += '</tr>';
            });
            return html;
        }
    </script>
@endpush
