@extends('layouts.dash', ['activePage' => 'invitados_admin_users', 'title' => 'Invitado Admin', 'navName' => 'Invitado Analisis', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Invitado</li>
{{--            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Usuarios</a></li>--}}
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista de analisis del usuario: <b>{{$user->name}}</b></h4>
                    <p>Total Analisis: <span>{{ count($analisis) }}</span></p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-full-width table-responsive">
                <table id="tAnalisisAsignados" class="table table-hover">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo</th>
                        <th>Paciente</th>
                        <th>Procedencia</th>
                        <th>Imprimir Firma</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($analisis as $a)
                        <tr data-id="{{$a->id}}">
                            <td>{{$a->codigo}}</td>
                            <td>{{$a->tipo_analisis}}</td>
                            <td>{{$a->nombres}} {{$a->apellidos}} {{$a->apellido_materno}}</td>
                            <td>{{ $a->ins_nombre  }}</td>
                            <td>{{ $a->imprimir_firma == 0? 'Con firma' : 'Sin firma'  }}</td>
                            <td>{{$a->fecha}}</td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" title="Quitar asignacion"
                                   onclick="mConfirmar('{{$a->id}}', '{{$a->codigo}}');"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal confirmar retiro de analisis -->
    <div class="modal fade" id="mRetiroAnalisisModal" tabindex="-1" aria-labelledby="retiroAnaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form onsubmit="fSendRetirarAnalisis(this); return false;">
                    <input type="hidden" name="analisisId">
                <div class="modal-header">
                    <h5 class="modal-title" id="retiroAnaModalLabel">Confirma retiro de analisis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <p>Esta seguro que quiere quitar el analisis <span id="msCodigo" style="font-weight: 700;"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
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

        function mConfirmar(analisisId, codigo){
            $("#mRetiroAnalisisModal").modal('show');
            $("#msCodigo").empty().text(codigo);
            $("#mRetiroAnalisisModal input[name='analisisId']").val(analisisId);
        }

        function fSendRetirarAnalisis(form){
            let analisis_id = $(form).find('input[name="analisisId"]').val();
            let user_id = '{{$user_id}}';
            $.ajax({
                url: "{{ route('invitado.admin.retiraranalisis') }}",
                type: 'POST',
                data: {user_id, analisis_id},
                success: function (data) {
                    if(data.success){
                        let trs = $("#tAnalisisAsignados tbody tr");
                        let trRemove = null;
                        // buscar tr para quitar de la tabla
                        $.each(trs, function(i, tr){
                            if($(tr).attr('data-id') === analisis_id){
                                trRemove = tr;
                            }
                        });
                        $(trRemove).remove();
                        $("#mRetiroAnalisisModal").modal('hide');
                    } else {
                        alert('Ocurrió algo inesperado en el servidor por favor contáctese con el administrador.');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        }
    </script>
@endpush
