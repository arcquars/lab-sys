@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="tAnalisis" class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Cliente</th>
                    <th>Fecha Entrega</th>
                    <th>Tipo</th>
                    <th>Doctor</th>
                    @can('manage-users')
                    <th>Procedencia</th>
                    <th>Precio</th>
                    @endcan
                    <th>A cuenta</th>
                    <th>Pago</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_realizarpago">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pagoModalLabel">Realizar Pago</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-pago-p">
                        <input type="hidden" name="analisis_id" id="i_analisis_id">
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Cliente: </b> <span id="pago_cliente">Maria Jose</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><b>Doctor: </b> <span id="pago_doctor">Carlos Terrazas</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Precio: </b> <span id="pago_precio">450</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><b>A cuenta: </b> <span id="pago_acuenta">50</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right;">
                                <p style="color: #FF9500; font-size: 1rem;"><b>PAGO: </b> <span id="pago_pago">50</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="savePago();" class="btn btn-primary">Realizar Pago</button>
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

            $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('simple_datatables_analisis_data') }}",
                columns: [
                    {name: 'id'},
                    {name: 'codigo'},
                    {name: 'person.nombres', orderable: true},
                    {name: 'fecha', orderable: false},
                    {name: 'tipo_analisis'},
                    {name: 'doctor', orderable: false},
                    {name: 'institucion.nombre'},
                        @can('manage-users')
                    {name: 'precio'},
                    {name: 'acuenta'},
                        @endcan
                    {name: 'pago_efectuado'},
                    {name: 'precio1', orderable: false},
                    {name: 'action', orderable: false, searchable: false}
                ],
                aoColumnDefs: [
                    {
                        "targets": [8],
                        "visible": false,
                        "searchable": false
                    }
                ],
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

        function openModalPago(link){
            analisisId = $(link).data('id');
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisPago') }}",
                type: 'POST',
                data: {'analisis_id': analisisId},
                success: function (data) {
                    $('#pago_cliente').empty().append(data.success.cliente);
                    $('#pago_doctor').empty().append(data.success.doctor);
                    $('#pago_precio').empty().append(data.success.precio);
                    $('#pago_acuenta').empty().append(data.success.acuenta);
                    $('#pago_pago').empty().append(data.success.precio-data.success.acuenta);
                    $('#i_analisis_id').val(analisisId);
                    $('#pagoModal').modal('show');
                }
            });
        }

        function savePago(){
            analisisId = $('#i_analisis_id').val();
            $.ajax({
                url: "{{ route('analisis.aSavePago') }}",
                type: 'POST',
                data: {'analisis_id': analisisId},
                success: function (data) {
                    $('#pagoModal').modal('hide');
                    $('#tAnalisis').DataTable().ajax.reload();
                }
            });
        }
    </script>
@endpush