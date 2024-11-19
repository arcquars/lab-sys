@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Editar Analisis', 'activeButton' => 'clientActiveButton'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>

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
                <dt class="col-md-3">Fecha de nacimiento:</dt>
                <dd class="col-md-3">{{($analisis->person->f_nacimiento)? $analisis->person->f_nacimiento : '--'}}</dd>
            </dl>
            <dl class="row row-citologia">
                <dt class="col-md-3">Sexo:</dt>
                <dd class="col-md-3">{{$analisis->person->sexo}}</dd>
            </dl>
        </div>
        <div class="card-body">
            @can('manage-admin')
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#mcambiarpaciente">Cambiar paciente</button>
            @endcan
            <form action="{{ route('analisis.update',$analisis->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="edad">Edad cliente</label>
                                <input type="number" name="edad"
                                       class="form-control @error('edad') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                       value="{{old('edad', $analisis->edad)}}">
                                @error('edad')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
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
                        <div class="col-md-2">
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
                            <div class="form-group">
                                <label for="region">Region de analisis</label>
                                <input type="text" name="region"
                                       class="form-control @error('region') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                       value="{{@old('region', $analisis->region)}}">
                                @error('region')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @include('analisis.includes.convenio')
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror"
                                       value="{{@old('precio', $analisis->precio)}}"
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
                                   value="{{@old('acuenta', $analisis->acuenta)}}"
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
                    <button type="submit" class="btn btn-lab-pdm-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal cambiar paciente -->
    <div id="mcambiarpaciente" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="fcambiarpaciente" action="">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="mgasto_title" class="modal-title ">Cambiar paciente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="js-paciente-ajax-id">Paciente buscar por apellido:</label>
                        <select class="js-data-example-ajax" id="js-paciente-ajax-id"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-lab-pdm-primary btn-sm">Grabar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // alert(CSRF_TOKEN);

            fntBanca($('#s_procedencia'));

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{ route('analisis.paciente.search') }}',
                    type: "post",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });

            $("#fcambiarpaciente").submit(function (event) {
                event.preventDefault();
                let selects = $('#js-paciente-ajax-id').select2('data');
                if(selects.length > 0){
                    // alert(JSON.stringify(selects[0].id));
                    $.ajax({
                        url: "{{ route('analisis.paciente.achangepaciente') }}",
                        type: 'POST',
                        data: {'paciente_id': selects[0].id, 'analisis_id': '{{$analisis->id}}'},
                        success: function (data) {
                            // alert(JSON.stringify(data.analisis));
                            location.reload();
                        }
                    });
                } else {
                    alert('no valido');
                }
                // alert(JSON.stringify());
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
