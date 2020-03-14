@extends('layouts.dash', ['activePage' => 'clients', 'title' => 'Administrar Clientes', 'navName' => 'Clientes', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('clients.index')}}">Clientes</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Analisis</h4>
                </div>
                <div class="col-md-6 text-right"><a href="#" class="btn btn-primary" onclick="openModelPerson();">Registrar
                        Cliente</a></div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Analisis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor">Doctor</label>
                                <input type="text" name="doctor" class="form-control">
                                <div class="fca_error_doctor" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="procedencia">Procedencia</label>
                                <select name="procedencia" class="form-control">
                                    <option value="SIN PROCEDENCIA">SIN PROCEDENCIA</option>
                                    @foreach($procedencias as $procedencia)
                                        <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="fca_error_procedencia" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_analisis">Tipo Analisis</label>
                                <select name="tipo_analisis" class="form-control">
                                    @foreach($tipoAnalisis as $analisis)
                                        <option value="{{$analisis}}">{{$analisis}}</option>
                                    @endforeach
                                </select>
                                <div class="fca_error_tipo_analisis" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" class="form-control datepicker">
                            <div class="fca_error_fecha" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="region">Region</label>
                                <input type="text" name="region" class="form-control">
                                <div class="fca_error_region" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="text" name="precio" class="form-control">
                                <div class="fca_error_precio" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="acuenta">Acuenta</label>
                            <input type="text" name="acuenta" class="form-control">
                            <div class="fca_error_acuenta" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control" id="observaciones" rows="3" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cerrar</a>
                    <button type="button" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {


        });


    </script>
@endpush