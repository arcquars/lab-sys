@extends('layouts.dash', ['activePage' => 'clients', 'title' => 'Administrar Clientes', 'navName' => 'Clientes', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4><b>Crear Analisis:</b> <span>{{$persona->nombres.' '.$persona->apellidos}}</span></h4>
                </div>
                <div class="col-md-6 text-right"><a href="#" class="btn btn-primary" onclick="openModelPerson();">Registrar
                        Cliente</a></div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="/analisis">
                {{ csrf_field() }}
                <input type="hidden" name="person_id" value="{{$persona->id}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor">Doctor</label>
                                <input type="text" name="doctor" class="form-control @error('doctor') is-invalid @enderror"
                                value="{{old('doctor')}}">
                                @error('doctor')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                       value="{{old('fecha')}}">
                                @error('fecha')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_analisis">Tipo Analisis</label>
                                <select name="tipo_analisis" class="form-control @error('tipo_analisis') is-invalid @enderror">
                                    <option value="">Elija un Analisis</option>
                                    @if(old('tipo_analisis'))
                                        @foreach($tipoAnalisis as $analisis)
                                            @if(strcmp(old('tipo_analisis'), $analisis) == 0)
                                                <option value="{{$analisis}}" selected>{{$analisis}}</option>
                                            @else
                                                <option value="{{$analisis}}">{{$analisis}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($tipoAnalisis as $analisis)
                                            <option value="{{$analisis}}">{{$analisis}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('tipo_analisis')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="procedencia">Procedencia</label>
                            <select name="procedencia" class="form-control @error('procedencia') is-invalid @enderror">
                                <option value="0">SIN PROCEDENCIA</option>
                                @if(old('procedencia'))
                                    @foreach($procedencias as $procedencia)
                                        @if(old('procedencia') == $procedencia->id)
                                            <option value="{{$procedencia->id}}" selected>{{$procedencia->nombre}}</option>
                                        @else
                                            <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($procedencias as $procedencia)
                                        <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('procedencia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="region">Region</label>
                                <input type="text" name="region" class="form-control @error('region') is-invalid @enderror"
                                value="{{@old('region')}}">
                                @error('region')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="text" name="precio" class="form-control @error('precio') is-invalid @enderror"
                                       value="{{@old('precio')}}">
                                @error('precio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="acuenta">Acuenta</label>
                            <input type="text" name="acuenta" class="form-control @error('acuenta') is-invalid @enderror"
                                   value="{{@old('acuenta')}}">
                            @error('acuenta')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                          name="observaciones" rows="3" style="resize: none;">{{@old('observaciones')}}</textarea>
                                @error('observaciones')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cerrar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
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