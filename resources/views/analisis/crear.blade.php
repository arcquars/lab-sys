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
        <div class="card-header">
            <dl class="row row-citologia">
                <dt class="col-md-3">Nombres y Apellidos:</dt>
                <dd class="col-md-3">{{$persona->apellidos.' '.$persona->apellido_materno.', '.$persona->nombres}}</dd>
                <dt class="col-md-3">Fecha nacimiento:</dt>
                <dd class="col-md-3">{{($persona->f_nacimiento)? $persona->f_nacimiento : '--'}}</dd>
            </dl>
            <dl class="row row-citologia">
                <dt class="col-md-3">Sexo:</dt>
                <dd class="col-md-3">{{$persona->sexo}}</dd>
            </dl>
        </div>
        <div class="card-body">
            <form method="post" action="/analisis" id="formAnalisis">
                {{ csrf_field() }}
                <input type="hidden" name="person_id" value="{{$persona->id}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="edad">Edad cliente</label>
                                <input type="number" name="edad"
                                       class="form-control @error('edad') is-invalid @enderror"
                                       value="{{old('edad')? old('edad') : $edad}}">
                                @error('edad')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="doctor">Doctor que envia</label>
                                <input type="text" name="doctor"
                                       class="form-control @error('doctor') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                value="{{old('doctor')}}">
                                @error('doctor')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="region">Region de analisis</label>
                                <input type="text" name="region"
                                       class="form-control @error('region') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                       value="{{@old('region')}}">
                                @error('region')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_analisis">Tipo de Analisis</label>
                                <select name="tipo_analisis" id="s_tipoanalisis" onchange="getCodigo();" class="form-control @error('tipo_analisis') is-invalid @enderror">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_analisis">Codigo</label>
                                <input type="text" name="codigo" id="i_codigo" class="form-control i-codigo" readonly>
                                @error('codigo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="procedencia">Procedencia</label>
                            <select id="s_procedencia" name="procedencia" onchange="fntBanca(this);" class="form-control @error('procedencia') is-invalid @enderror">
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
                    @include('analisis.includes.convenio')
                    <div class="row">
                        <div class="col-md-3">
                            <label for="telefono_referencia">Telefono Referencia</label>
                            <input type="text" name="telefono_referencia" class="form-control @error('telefono_referencia') is-invalid @enderror"
                                   value="{{old('telefono_referencia')}}">
                            @error('telefono_referencia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="fecha">Fecha de Ingreso</label>
                            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{old('fecha', date('Y-m-d'))}}"
                                   min="{{date('Y-m-d', strtotime("-10 days"))}}"
                                   max="{{date('Y-m-d', strtotime("5 days"))}}"
                            >
                            {{--                                       value="2019-12-30">--}}
                            @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_asignado">Asignar Doctor</label>
                                <select name="doctor_asignado" class="form-control @error('fecha_entrega') is-invalid @enderror">
                                    <option value="" selected>Elija un doctor</option>
                                    @if(old('doctor_asignado'))
                                        @foreach($doctores as $doctor)
                                            @if(old('doctor_asignado') == $doctor->id)
                                                <option value="{{$doctor->id}}" selected>{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                            @else
                                                <option value="{{$doctor->id}}">{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($doctores as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                        @endforeach
                                    @endif
                                </select>
{{--                                <input type="date" name="fecha_entrega" class="form-control @error('fecha_entrega') is-invalid @enderror"--}}
{{--                                       value="{{old('fecha_entrega', date('Y-m-d'))}}"--}}
{{--                                       min="{{date('Y-m-d', strtotime("-5 days"))}}"--}}
{{--                                       max="{{date('Y-m-d', strtotime("10 days"))}}">--}}
                                @error('doctor_asignado')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <h5>Datos Para Facturacion</h5>
                    <div class="row" style="background-color: #E8F1FF;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="razon_social">Razon Social</label>
                                <input type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                                       value="{{@old('razon_social')}}"
                                >
                                @error('razon_social')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nit">NIT</label>
                            <input type="text" name="nit" class="form-control @error('nit') is-invalid @enderror"
                                   value="{{@old('nit')}}"
                            >
                            @error('nit')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror"
                                       value="{{@old('precio')}}"
                                       min="0" max="10000"
                                >
                                @error('precio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="acuenta">Acuenta</label>
                            <input type="number" name="acuenta" class="form-control @error('acuenta') is-invalid @enderror"
                                   value="{{@old('acuenta')}}"
                                   min="0" max="10000"
                            >
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
                    <button type="submit" id="btnSubmit" class="btn btn-primary">Crear</button>
                </div>
            </form>
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
            fntBanca($('#s_procedencia'));
            getCodigo();

            $("#formAnalisis").submit(function (e) {
                $("#btnSubmit").attr("disabled", true);
                //alert("xxx");
            });

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
