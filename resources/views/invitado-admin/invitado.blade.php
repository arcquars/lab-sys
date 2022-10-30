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
                </div>
                <div class="col-md-6 text-right">
                    <a href="#" class="btn btn-link text-danger" onclick="mOpenRemoveDr(); return false;">Quitar analisis por doctor</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-full-width table-responsive">
                <div class="table-responsive">
                    <table id="tAnalisisInvitadosAdmin" class="table table-clinica">
                        <thead class="thead-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Paciente</th>
                            <th>Doctor</th>
                            <th>Procedencia</th>
                            <th>Imprimir Firma</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
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

    <!-- Modal quitar analisis por doctor -->
    <div class="modal fade" id="removeAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="removeAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form onsubmit="openRemoveConfirmarDrModal(this); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeAnalisisModalLabel">Quitar analisis por DOCTOR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Doctor</label>
                        <select class="form-control" name="doctor" required>
                            <option value="">Elija un doctor</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Quitar doctor</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirmacion quitar analisis por doctor -->
    <div class="modal fade" id="removeConfirmacionAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="removeConfirmacionAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form onsubmit="removeAnalisisByDoctor(this); return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeConfirmacionAnalisisModalLabel">Quitar analisis por DOCTOR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="doctor">
                        <div class="alert alert-danger" role="alert">
                            Esta seguro que desea quitar todos los analisis del doctor <b class="bDoctor"></b>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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


            var table = $('#tAnalisisInvitadosAdmin').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                // deferRender: true,
                ajax: {
                    url: "{{ route('invitadoadmin.simple.datatables.analisis.data') }}",
                    data: function ( d ) {
                        d.user_id = "{{ $user_id  }}";
                    },
                    type: 'post',
                    beforeSend: function(){
                        // Here, manually add the loading message.
                        $('#tAnalisisInvitadosAdmin > tbody').html(
                            '<tr class="odd">' +
                            '<td valign="top" colspan="6" class="dataTables_empty">Loading&hellip;</td>' +
                            '</tr>'
                        );
                    }
                },
                columns: [
                    {name: 'codigo'},
                    {name: 'tipo_analisis'},
                    {name: 'nombres'},
                    {name: 'doctor'},
                    {name: 'nombre'},
                    {name: 'imprimir_firma', render: function (data, type, row, meta) {
                            return (data === 0)? 'Sin Firma': 'Con Firma';
                        }},

                    {name: 'fecha'},
                    {name: 'actionAdmin', orderable: false, searchable: false},

                ],
                "pagingType": "full_numbers",
                "order": [[ 3, "desc" ]],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
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
                        $('#tAnalisisInvitadosAdmin').DataTable().ajax.reload();
                        $("#mRetiroAnalisisModal").modal('hide');
                    } else {
                        alert('Ocurrió algo inesperado en el servidor por favor contáctese con el administrador.');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        }

        function mOpenRemoveDr() {
            $.ajax({
                url: "{{ route('invitado.admin.getdrbyuser') }}",
                type: 'POST',
                data: {user_id: '{{$user->id}}'},
                success: function (data) {
                    if(data.success){
                        $("#removeAnalisisModal").modal('show');
                        // alert(JSON.stringify(data));
                        let select = $('#removeAnalisisModal select[name="doctor"]');
                        select.empty();
                        let options = '<option value="">Elija un doctor</option>';
                        $.each(data.doctores, function(index, doctor){
                            options += '<option value="'+doctor.doctor+'">'+doctor.doctor+'</option>';
                        });
                        select.append(options);
                    } else {
                        alert('Ocurrió algo inesperado en el servidor por favor contáctese con el administrador.');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        }

        function openRemoveConfirmarDrModal(form) {
            $("#removeAnalisisModal").modal('hide');
            let doctor = $(form).find('select[name=doctor]').val();
            $("#removeConfirmacionAnalisisModal").modal('show');
            $("#removeConfirmacionAnalisisModal input[name='doctor']").val(doctor);
            $("#removeConfirmacionAnalisisModal .bDoctor").text(doctor);
        }

        function removeAnalisisByDoctor(form){
            let doctor = $(form).find('input[name="doctor"]').val();
            $.ajax({
                url: "{{ route('invitado.admin.removeAnalisisDoctor') }}",
                type: 'POST',
                data: {user_id: '{{$user->id}}', doctor: doctor},
                success: function (data) {
                    if(data.success){
                        $("#removeConfirmacionAnalisisModal").modal('hide');
                        $('#tAnalisisInvitadosAdmin').DataTable().ajax.reload();
                    } else {
                        alert('Ocurrió algo inesperado en el servidor por favor contáctese con el administrador.');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Ocurrió algo inesperado en el servidor por favor contáctese con el administrador.');
                }
            });
        }
    </script>
@endpush
