@extends('layouts.dash', ['activePage' => 'invitado_index', 'title' => 'Invitado', 'navName' => 'Analisis', 'activeButton' => 'invitadoActiveButton'])

@section('content')
    <div style="height: 2px"></div>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista de analisis</h4>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table-full-width table-responsive">
                <div class="table-responsive">
                    <table id="tAnalisisInvitados" class="table table-clinica">
                        <thead class="thead-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <hr>





{{--            <div class="table-full-width table-responsive">--}}
{{--                <table id="tAnalisisInvitadosB" class="table table-hover">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Codigo</th>--}}
{{--                        <th>Tipo</th>--}}
{{--                        <th>Paciente</th>--}}
{{--                        <th>Fecha</th>--}}
{{--                        <th>Acciones</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach ($analisis as $a)--}}
{{--                        <tr data-id="{{$a->id}}">--}}
{{--                            <td>{{$a->codigo}}</td>--}}
{{--                            <td>{{$a->tipo_analisis}}</td>--}}
{{--                            <td>{{$a->nombres}} {{$a->apellidos}} {{$a->apellido_materno}}</td>--}}
{{--                            <td>{{$a->fecha}}</td>--}}
{{--                            <td>--}}
{{--                                <a href="{{route('analisis.open.esultado.pdf', array('analisisId' => base64_encode($a->id)))}}"--}}
{{--                                   class="btn btn-primary btn-sm" title="Archivo pdf" target="_blank"--}}
{{--                                   ><i class="fas fa-file-pdf"></i></a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
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

            var table = $('#tAnalisisInvitados').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                // deferRender: true,
                ajax: {
                    url: "{{ route('invitado.simple.datatables.analisis.data') }}",
                    type: 'post',
                    beforeSend: function(){
                        // Here, manually add the loading message.
                        $('#tAnalisis > tbody').html(
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
                    {name: 'fecha'},
                    {name: 'action', orderable: false, searchable: false},

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
    </script>
@endpush
