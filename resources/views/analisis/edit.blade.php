@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Crear Analisis', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Editar Analisis</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <dl class="row row-citologia">
                <dt class="col-md-3">Nombres y Apellidos:</dt>
                <dd class="col-md-3">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</dd>
                <dt class="col-md-3">Edad:</dt>
                <dd class="col-md-3">{{$analisis->person->edad}}</dd>
            </dl>
            <dl class="row row-citologia">
                <dt class="col-md-3">Sexo:</dt>
                <dd class="col-md-3">{{$analisis->person->sexo}}</dd>
            </dl>
        </div>
        <div class="card-body">
            <form action="{{ route('analisis.update',$analisis->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor">Doctor que envia</label>
                                <input type="text" name="doctor"
                                       class="form-control @error('doctor') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                       value="{{old('doctor', $analisis->doctor)}}">
                                @error('doctor')
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
                                        @if($analisis->procedencia == $procedencia->id)
                                            <option value="{{$procedencia->id}}" selected>{{$procedencia->nombre}}</option>
                                        @else
                                            <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                        @endif

                                    @endforeach
                                @endif
                            </select>
                            @error('procedencia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="telefono_referencia">Telefono Referencia</label>
                            <input type="text" name="telefono_referencia" class="form-control @error('telefono_referencia') is-invalid @enderror"
                                   value="{{old('telefono_referencia', $analisis->telefono_referencia)}}">
                            @error('telefono_referencia')
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
                                            @if($analisis->doctor_asignado == $doctor->id)
                                                <option value="{{$doctor->id}}" selected>{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                            @else
                                                <option value="{{$doctor->id}}">{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
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
                                       value="{{@old('razon_social', $analisis->razon_social)}}"
                                >
                                @error('razon_social')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nit">NIT</label>
                            <input type="text" name="nit" class="form-control @error('nit') is-invalid @enderror"
                                   value="{{@old('nit', $analisis->nit)}}"
                            >
                            @error('nit')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                          name="observaciones" rows="3" style="resize: none;">{{@old('observaciones', $analisis->observaciones)}}</textarea>
                                @error('observaciones')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Atras</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
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
