@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Bethesda', 'navName' => 'Bethesda', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Bethesda</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
        </div>
        <div class="card-body">
            <ul class="ul-clinica-errors">
                @foreach ($errors->get('celulas_observadas') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    @foreach ($errors->get('calidad_muestra') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('clasificacion_general') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('interpretacion') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('observaciones') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
            </ul>
            <form action="{{url('/bethesda/save')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="bethesda" value="{{$bethesda ? $bethesda->id : ''}}">
                <div class="form-group">
                    <label for="calidad_muestra">Calidad de la Muestra</label>
                    <select name="calidad_muestra" class="form-control">
                        <option value="">Seleccione ...</option>
                        @if ($bethesda)
                            @php
                            $cmId = $bethesda->getCalidadMuestraId();
                            @endphp
                            @foreach($bethesda_calidad_muestras as $key => $value)
                                @if($cmId==$key)
                                    <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($bethesda_calidad_muestras as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="clasificacion_general">Clasificacion General</label>
                    <select name="clasificacion_general" class="form-control">
                        <option value="">Seleccione ...</option>
                        @if ($bethesda)
                            @php
                                $cgId = $bethesda->getClasificacionGeneralId();
                            @endphp
                            @foreach($bethesda_clasificacion_generales as $key => $value)
                                @if($cgId==$key)
                                    <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($bethesda_clasificacion_generales as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <label for="">Interpretacion / Resultados</label>
                <div class="row">
                    <div class="col-md-12 overflow-auto table-bordered" style="height: 150px;">
                        <div class="row">
                            @if ($bethesda)
                                @php
                                    $interpretaciones = $bethesda->getInterpretacionesArray();
                                @endphp
                                @foreach($bethesda_interpretaciones as $key => $value)
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                @php
                                                    $valid = false;
                                                @endphp

                                                @if ($interpretaciones)
                                                @foreach($interpretaciones as $key1 => $value1)
                                                    @if ($key1==$key)
                                                        @php
                                                            $valid = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @endif

                                                @if ($valid)
                                                    <input class="form-check-input" name="interpretaciones[]" type="checkbox" value="{{$key}}" checked>
                                                @else
                                                    <input class="form-check-input" name="interpretaciones[]" type="checkbox" value="{{$key}}">
                                                @endif
                                                <span class="form-check-sign"></span>
                                                {{$value}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach($bethesda_interpretaciones as $key => $value)
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" name="interpretaciones[]" type="checkbox" value="{{$key}}">
                                                <span class="form-check-sign"></span>
                                                ({{$key}}) {{ $value }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
                <br>
                <label for="">Celulas Observadas</label>
                <div class="row">
                    @if ($bethesda)
                        @php
                            $celulasObs = $bethesda->getCelulasObservadasArray();
                        @endphp
                        @foreach($bethesta_checks as $key => $value)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @php
                                        $valid = false;
                                        @endphp
                                        @foreach($celulasObs as $key1 => $value1)
                                            @if ($key1==$key)
                                                @php
                                                    $valid = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($valid)
                                            <input class="form-check-input" name="celulas_observadas[]" type="checkbox" value="{{$key}}" checked>
                                        @else
                                            <input class="form-check-input" name="celulas_observadas[]" type="checkbox" value="{{$key}}">
                                        @endif
                                        <span class="form-check-sign"></span>
                                        {{$value}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach($bethesta_checks as $key => $value)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="celulas_observadas[]" type="checkbox" value="{{$key}}">
                                        <span class="form-check-sign"></span>
                                        {{$value}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    @if ($bethesda)
                        <textarea name="observaciones" class="form-control">{{$bethesda->observaciones}}</textarea>
                    @else
                        <textarea name="observaciones" class="form-control"></textarea>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <input type="submit" class="btn btn-primary float-right" value="Grabar">
                    </div>
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
