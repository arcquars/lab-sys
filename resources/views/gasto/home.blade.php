@extends('layouts.dash', ['activePage' => 'gasto_index', 'title' => 'Administrar Gastos', 'navName' => 'Gastos', 'activeButton' => 'gastoActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Gastos</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-lab-pdm-primary" onclick="openModelGasto(); return false;">Registrar Gasto</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="tGastos" class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Monto</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
<!-- Modal registro gasto-->
<div id="mgasto" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="fcreargasto" action="">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="mgasto_title" class="modal-title ">Crear Gasto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detalle">Detalle</label>
                                <input type="text" name="detalle"
                                       onkeyup="uppercaseInput(this);"
                                       class="form-control" placeholder="Detalle">
                                <div class="fcp_error_detalle" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gasto">Monto</label>
                                <input type="number" name="gasto"
                                       onkeyup="uppercaseInput(this);"
                                       class="form-control" min="0" max="5000" step="0.1">
                                <div class="fcp_error_gasto" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha"
                                       value="{{date('Y-m-d')}}"
                                       class="form-control">
                                <div class="fcp_error_fecha" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-lab-pdm-primary">Grabar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tGastos').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('gasto.datatables_gastos') }}",
                columns: [
                    {name: 'id', visible: false},
                    {name: 'fecha', orderable: true},
                    {name: 'detalle'},
                    {name: 'gasto', orderable: false, searchable: false}
                ],
                "order": [[ 1, "desc" ]],
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

            $("#fcreargasto").submit(function (event) {
                event.preventDefault();
                clearErrorMsg();

                var _token = $(this).find("input[name='_token']").val();
                var id = $(this).find("input[name='id']").val();
                var detalle = $(this).find("input[name='detalle']").val();
                var fecha = $(this).find("input[name='fecha']").val();
                var gasto = $(this).find("input[name='gasto']").val();

                $.ajax({
                    url: "{{ route('gastos.createGasto') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        detalle: detalle,
                        fecha: fecha,
                        gasto: gasto
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#mgasto").modal("hide");
                            $('#tGastos').DataTable().ajax.reload();
                        } else {
                            alert(data.errors);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcreardoctor"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });

            $("#mgasto").on('shown.bs.modal', function (event) {
                $("#fcreargasto")[0].reset();
                $("#fcreargasto").find("input[name='id']").val('');
                clearErrorMsg();
            });
        });


        function openModelGasto() {
            $('#mgasto').modal('show');
            $('#mgasto_title').empty().text('Crear Gasto');
        }

        function printErrorMsg(form, msg) {
            $.each(msg.errors, function (key, value) {
                $(form).find("input[name='" + key + "']").addClass('is-invalid');
                var msgs = "<ul class='list-unstyled'>";
                $.each(value, function (key1, value1) {
                    msgs += "<li><span class='text-danger'>" + value1 + "</span></li>";
                });
                msgs += "</ul>";
                $('.fcp_error_' + key).empty().append(msgs);
                $('.fcp_error_' + key).show();
            });
        }

        function clearErrorMsg() {
            $('.fcp_error_detalle').empty();
            $('.fcp_error_fecha').empty();
            $('.fcp_error_gasto').empty();

            $("#fcreargasto").find("input[name='detalle']").removeClass('is-invalid');
            $("#fcreargasto").find("input[name='fecha']").removeClass('is-invalid');
            $("#fcreargasto").find("input[name='gasto']").removeClass('is-invalid');
        }
    </script>
@endpush
