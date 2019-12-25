@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Crear Analisis', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>
        </ol>
    </nav>
    <div class="card">
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
                            <select id="s_procedencia" name="procedencia" onchange="fntBanca(this);" class="form-control @error('procedencia') is-invalid @enderror">
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
                    <div class="row banca_seccion">
                        <div class="col-md-6 form-group">
                            <label for="bancaMatricula">Matricula del paciente</label>
                            <input type="text" name="bancaMatricula" class="form-control @error('bancaMatricula') is-invalid @enderror"
                                   value="{{old('bancaMatricula')}}">
                            @error('bancaMatricula')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="bancaPreAfiliacion">Pre afiliacion</label>
                            <input type="text" name="bancaPreAfiliacion" class="form-control @error('bancaPreAfiliacion') is-invalid @enderror"
                                   value="{{old('bancaPreAfiliacion')}}">
                            @error('bancaPreAfiliacion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row banca_seccion">
                        <div class="col-md-4">
                            <h6 class="titleBancaIngreso">Activo</h6>
                            <div class="form-group">
                                <input type="text" name="bancaActivoAsegurado" class="form-control @error('bancaActivoAsegurado') is-invalid @enderror"
                                       value="{{old('bancaActivoAsegurado')}}" placeholder="Asegurado">
                                @error('bancaActivoAsegurado')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaActivoExt" class="form-control @error('bancaActivoExt') is-invalid @enderror"
                                       value="{{old('bancaActivoExt')}}" placeholder="Ext. 19-25">
                                @error('bancaActivoExt')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaActivoResto" class="form-control @error('bancaActivoResto') is-invalid @enderror"
                                       value="{{old('bancaActivoResto')}}" placeholder="Rest Benef.">
                                @error('bancaActivoResto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="titleBancaIngreso">Pasivo</h6>
                            <div class="form-group">
                                <input type="text" name="bancaPasivoAsegurado" class="form-control @error('bancaPasivoAsegurado') is-invalid @enderror"
                                       value="{{old('bancaPasivoAsegurado')}}" placeholder="Asegurado">
                                @error('bancaPasivoAsegurado')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaPasivoExt" class="form-control @error('bancaPasivoExt') is-invalid @enderror"
                                       value="{{old('bancaPasivoExt')}}" placeholder="Ext. 19-25">
                                @error('bancaPasivoExt')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaPasivoResto" class="form-control @error('bancaPasivoResto') is-invalid @enderror"
                                       value="{{old('bancaPasivoResto')}}" placeholder="Rest Benef.">
                                @error('bancaPasivoResto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="titleBancaIngreso">Sec. Vol.</h6>
                            <div class="form-group">
                                <input type="text" name="bancaSecAsegurado" class="form-control @error('bancaSecAsegurado') is-invalid @enderror"
                                       value="{{old('bancaSecAsegurado')}}" placeholder="Asegurado">
                                @error('bancaSecAsegurado')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaSecExt" class="form-control @error('bancaSecExt') is-invalid @enderror"
                                       value="{{old('bancaSecExt')}}" placeholder="Ext. 19-25">
                                @error('bancaSecExt')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="bancaSecResto" class="form-control @error('bancaSecResto') is-invalid @enderror"
                                       value="{{old('bancaSecResto')}}" placeholder="Rest Benef.">
                                @error('bancaSecResto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row banca_seccion">
                        <div class="col-md-4 form-group">
                            <label for="bancaEspecialidad">Especialidad</label>
                            <input type="text" name="bancaEspecialidad" class="form-control @error('bancaEspecialidad') is-invalid @enderror"
                                   value="{{old('bancaEspecialidad')}}">
                            @error('bancaEspecialidad')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="bancaAmbulatorio">Ambulatorio</label>
                            <input type="text" name="bancaAmbulatorio" class="form-control @error('bancaAmbulatorio') is-invalid @enderror"
                                   value="{{old('bancaAmbulatorio')}}">
                            @error('bancaAmbulatorio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="bancaHospitalizado">Hospitalizado</label>
                            <input type="text" name="bancaHospitalizado" class="form-control @error('bancaHospitalizado') is-invalid @enderror"
                                   value="{{old('bancaHospitalizado')}}">
                            @error('bancaHospitalizado')
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
            fntBanca($('#s_procedencia'));

        });

    function fntBanca(select){
        var convenios = [{{ config('clinica.convenios_id', '10, 15') }}];
        for(var i=0; i<convenios.length; i++){
            if($(select).val() == convenios[i]){
                $('.banca_seccion').css('display', 'flex');
                break;
            } else {
                $('.banca_seccion').css('display', 'none');
            }
        }

    }
    </script>
@endpush