<?php
use \App\Helpers\HelperConfig;
?>
@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>

        </ol>EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
        </div>
        <div class="card-body">
            @if (isset($resultados))
                <form method="post" action="/citologia/resultadosedit">
            @else
                <form method="post" action="/citologia/resultados">
            @endif

                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisisId}}">
                <div class="modal-body">
                    <p class="text-muted" style="margin-bottom: 2px;">Clasificacion del Papanicolau Clase</p>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="text" name="papanicolaou_clase1"
                                   class="form-control @error('papanicolaou_clase1') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
                                   value="{{old('papanicolaou_clase1', (isset($resultados)? $resultados->papanicolaou_clase1 : ''))}}"

                            >
                            @error('papanicolaou_clase1')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="papanicolaou_clase2"
                                   class="form-control @error('papanicolaou_clase2') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
{{--                                   value="{{isset($resultados)? $resultados->papanicolaou_clase2 : ''}}"--}}
                                   value="{{old('papanicolaou_clase2', (isset($resultados)? $resultados->papanicolaou_clase2 : ''))}}"
                            >
                            @error('papanicolaou_clase2')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS</p>
                    <div id="ecdList" class="row">
                        @foreach(Config::get('clinica.extendido_compatible') as $extComp)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input name="ExtComp[]" class="form-check-input" type="checkbox" value="{{$extComp}}"
                                               @if ($resultados && HelperConfig::existEdcKey($seccECD, $extComp))
                                            checked
                                               @endif
                                        >
                                        <span class="form-check-sign"></span>
                                        {{$extComp}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">OMS</h3>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccOms as $secc)
                                            @if (strcmp($secc->key, 'displasia-leve') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-leve]"
                                                   checked >
                                        @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-leve]"
                                                   >
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-leve]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    DISPLASIA LEVE
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccOms as $secc)
                                            @if (strcmp($secc->key, 'displasia-moderada') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-moderada]" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-moderada]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-moderada]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    DISPLASIA MODERADA
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccOms as $secc)
                                            @if (strcmp($secc->key, 'displasia-severa') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-severa]" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-severa]" >
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-severa]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    DISPLASIA SEVERA
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccOms as $secc)
                                            @if (strcmp($secc->key, 'displasia-in') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-in]" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-in]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="oms[displasia-in]">
                                    @endif

                                    <span class="form-check-sign"></span>
                                    DISPLASIA IN SITU
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">RICHART</h3>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccHichart as $secc)
                                            @if (strcmp($secc->key, 'nic-i') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-i]" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-i]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-i]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    NIC I
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccHichart as $secc)
                                            @if (strcmp($secc->key, 'nic-ii') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-ii]" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-ii]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-ii]">
                                    @endif

                                    <span class="form-check-sign"></span>
                                    NIC II
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccHichart as $secc)
                                            @if (strcmp($secc->key, 'nic-iii') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii]" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    NIC III
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccHichart as $secc)
                                            @if (strcmp($secc->key, 'nic-iii-i') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if(isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii-i]" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii-i]">
                                            @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="hichart[nic-iii-i]">
                                    @endif

                                    <span class="form-check-sign"></span>
                                    NIC III
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">BETHESDA (N.C.I.)</h3>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccBethesda as $secc)
                                            @if (strcmp($secc->key, 'sil-de-bajo-grado') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-bajo-grado]" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-bajo-grado]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-bajo-grado]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    SIL DE BAJO GRADO
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;
                                        @endphp
                                        @foreach($seccBethesda as $secc)
                                            @if (strcmp($secc->key, 'sil-de-alto-grado') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp

                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-alto-grado]" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-alto-grado]">
                                        @endif
                                    @else
                                        <input class="form-check-input" type="checkbox" value="SI" name="bethesda[sil-de-alto-grado]">
                                    @endif
                                    <span class="form-check-sign"></span>
                                    SIL DE ALTO GRADO
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">REACCION INFLAMATORIA</p>
                    <div id="reacInflamatoriaList" class="row">
                        <?php $indiceInflamatoria = 0; ?>
                        @foreach(Config::get('clinica.reac_inflamatoria') as $key => $reacInfla)
                            <?php $indiceInflamatoria++; ?>
                            @if ($indiceInflamatoria == 5 || $indiceInflamatoria == 8)
                                    <div class="col-md-3">
                                    </div>
                                @endif
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="reacInfla[{{$reacInfla}}]" class="form-check-input" type="checkbox" value="SI"
                                                       @if ($resultados && HelperConfig::existEdcKey($seccReaccInfl, $reacInfla))
                                                       checked
                                                        @endif
                                                >
                                                <span class="form-check-sign"></span>
                                                {{$reacInfla}}
                                            </label>
                                        </div>
                                    </div>


                        @endforeach
                    </div>
                    <hr>
                    <p class="text-muted">ESTUDIO MICROBIOLOGICO
                    </p>
                    <div id="estMicroList" class="row">
                        @foreach(Config::get('clinica.estudio_microbiologico') as $estMicro)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{$estMicro}}</label>
                                    <input name="estudioMicro[{{$estMicro}}]" type="text" class="form-control"
                                           value="@if ($resultados && HelperConfig::existEdcKey($seccEstMicro, $estMicro)){{HelperConfig::getValueSeccionByKey($seccEstMicro, $estMicro)}}@endif"
                                    >
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6" style="background-color: #EBEBE9;">
                            <p class="text-muted text-center" style="background-color: #EBEBE9;">ESTUDIO CITO - HORMONAL</p>
                        </div>
                        <div class="col-md-6" style="background-color: #FFF6ED;">
                            <p class="text-muted text-center" style="background-color: #FFF6ED;">CITOLOGIA POSMENOPAUSIA</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="background-color: #EBEBE9;">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="estCito[PARABASALES]">PARABASALES</label>
                                    @if ($resultados)
                                        @php
                                        $seccAux = null;
                                        @endphp
                                        @foreach($seccCitoHormonal as $secc)
                                            @if (strcmp($secc->key, 'PARABASALES') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (isset($seccAux))
                                            <input type="text" class="form-control"
                                                   name="estCito[PARABASALES]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="estCito[PARABASALES]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="estCito[PARABASALES]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="estCito[INTERMEDIAS]">INTERMEDIAS</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoHormonal as $secc)
                                            @if (strcmp($secc->key, 'INTERMEDIAS') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="estCito[INTERMEDIAS]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="estCito[INTERMEDIAS]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="estCito[INTERMEDIAS]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="estCito[SUPERFICIALES]">SUPERFICIALES</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoHormonal as $secc)
                                            @if (strcmp($secc->key, 'SUPERFICIALES') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="estCito[SUPERFICIALES]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="estCito[SUPERFICIALES]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="estCito[SUPERFICIALES]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="background-color: #FFF6ED;">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="citoPosmenopausia[ESTROGENICO]">T. ESTROGENICO</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoPosm as $secc)
                                            @if (strcmp($secc->key, 'ESTROGENICO') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[ESTROGENICO]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[ESTROGENICO]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="citoPosmenopausia[ESTROGENICO]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="citoPosmenopausia[INTERMEDIO]">T. INTERMEDIO</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoPosm as $secc)
                                            @if (strcmp($secc->key, 'INTERMEDIO') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[INTERMEDIO]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[INTERMEDIO]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="citoPosmenopausia[INTERMEDIO]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="citoPosmenopausia[PARABASAL]">T. PARABASAL</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoPosm as $secc)
                                            @if (strcmp($secc->key, 'PARABASAL') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[PARABASAL]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[PARABASAL]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="citoPosmenopausia[PARABASAL]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="citoPosmenopausia[ATROFICO]">T. ATROFICO</label>
                                    @if ($resultados)
                                        @php
                                            $seccAux = null;

                                        @endphp
                                        @foreach($seccCitoPosm as $secc)
                                            @if (strcmp($secc->key, 'ATROFICO') == 0)
                                                @php
                                                    $seccAux = $secc;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($seccAux)
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[ATROFICO]"
                                                   onkeyup="uppercaseInput(this);"
                                                   value="{{$seccAux->value}}"
                                            >
                                        @else
                                            <input type="text" class="form-control"
                                                   name="citoPosmenopausia[ATROFICO]"
                                                   onkeyup="uppercaseInput(this);"
                                            >
                                        @endif
                                    @else
                                        <input type="text" class="form-control"
                                               name="citoPosmenopausia[ATROFICO]"
                                               onkeyup="uppercaseInput(this);"
                                        >
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="desviacion[DESVIACION A LA IZQUIERDA]">DESVIACION A LA IZQUIERDA</label>
                            @if ($resultados)
                                @php
                                    $seccAux = null;

                                @endphp
                                @foreach($seccDesviacion as $secc)
                                    @if (strcmp($secc->key, 'DESVIACION A LA IZQUIERDA') == 0)
                                        @php
                                            $seccAux = $secc;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($seccAux)
                                    <input type="text" class="form-control"
                                           name="desviacion[DESVIACION A LA IZQUIERDA]"
                                           onkeyup="uppercaseInput(this);"
                                           value="{{$seccAux->value}}"
                                    >
                                @else
                                    <input type="text" class="form-control"
                                           name="desviacion[DESVIACION A LA IZQUIERDA]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                @endif
                            @else
                                <input type="text" class="form-control"
                                       name="desviacion[DESVIACION A LA IZQUIERDA]"
                                       onkeyup="uppercaseInput(this);"
                                >
                            @endif

                        </div>
                        <div class="col-md-4 form-group">
                            <label for="desviacion[DESVIACION A LA DERECHA]">DESVIACION A LA DERECHA</label>
                            @if ($resultados)
                                @php
                                    $seccAux = null;

                                @endphp
                                @foreach($seccDesviacion as $secc)
                                    @if (strcmp($secc->key, 'DESVIACION A LA DERECHA') == 0)
                                        @php
                                            $seccAux = $secc;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($seccAux)
                                    <input type="text" class="form-control"
                                           name="desviacion[DESVIACION A LA DERECHA]"
                                           onkeyup="uppercaseInput(this);"
                                           value="{{$seccAux->value}}"
                                    >
                                @else
                                    <input type="text" class="form-control"
                                           name="desviacion[DESVIACION A LA DERECHA]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                @endif
                            @else
                                <input type="text" class="form-control"
                                       name="desviacion[DESVIACION A LA DERECHA]"
                                       onkeyup="uppercaseInput(this);"
                                >
                            @endif
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="desviacion[VALOR DE MADURACION (MV)]">VALOR DE MADURACION (MV)</label>
                            @if ($resultados)
                                @php
                                    $seccAux = null;

                                @endphp
                                @foreach($seccDesviacion as $secc)
                                    @if (strcmp($secc->key, 'VALOR DE MADURACION (MV)') == 0)
                                        @php
                                            $seccAux = $secc;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($seccAux)
                                    <input type="text" class="form-control"
                                           name="desviacion[VALOR DE MADURACION (MV)]"
                                           onkeyup="uppercaseInput(this);"
                                           value="{{$seccAux->value}}"
                                    >
                                @else
                                    <input type="text" class="form-control"
                                           name="desviacion[VALOR DE MADURACION (MV)]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                @endif
                            @else
                                <input type="text" class="form-control"
                                       name="desviacion[VALOR DE MADURACION (MV)]"
                                       onkeyup="uppercaseInput(this);"
                                >
                            @endif
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">OBSERVACIONES</p>
                    <div class="row">
                        <div class="col-md-12">
                            @if ($resultados)
                                <textarea id="observaciones1" name="observaciones1" class="form-control" style="resize: none;" rows="3">{{$resultados->observaciones1}}</textarea>
                                @else
                                <textarea id="observaciones1" name="observaciones1" class="form-control" style="resize: none;" rows="3"></textarea>
                            @endif
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                            <div class="float-right">
                                <input type="submit" name="grabar-imprimir" class="btn btn-success" value="Grabar/Imprimir">
                                <input type="submit" name="grabar" class="btn btn-primary" value="Grabar">
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <!-- Modal Extendido compatible-->
    <div class="modal fade" id="ecdModal" tabindex="-1" role="dialog" aria-labelledby="ecdModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ecdModalLabel">Añadir Extendido Compatible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="s_extendido_compatible">
                            @foreach(Config::get('clinica.extendido_compatible') as $extComp)
                                <option>{{$extComp}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="addExtendidoCompatible();">Añadir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reaccion inflamatoria -->
    <div class="modal fade" id="reacInflaModal" tabindex="-1" role="dialog" aria-labelledby="reacModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="reacInflaForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="reacModalLabel">Añadir reaccion inflamatoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" name="tipo" required>
                                <option value="">Seleccione ...</option>
                                @foreach(Config::get('clinica.reac_inflamatoria') as $reacInfla)
                                    <option>{{$reacInfla}}</option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <input type="text" name="descripcion" class="form-control"--}}
{{--                                   onkeyup="uppercaseInput(this);"--}}
{{--                                   required>--}}
{{--                        </div>--}}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Estudio Microbiologico-->
    <div class="modal fade" id="estMicroModal" tabindex="-1" role="dialog" aria-labelledby="estMicroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="estMicroForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="estMicroModalLabel">Añadir Estudio Microbiologico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" name="tipo" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach(Config::get('clinica.estudio_microbiologico') as $estMicro)
                                        <option>{{$estMicro}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="descripcion" class="form-control"
                                       onkeyup="uppercaseInput(this);"
                                       value="ESCASOS">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($nuevoAnalisis)
        <!-- Modal Elegir tipo de analisis -->
        <div class="modal" id="tipoAnalisisModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="tipoAnalisisForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tipoAModalLabel">Establecer Tipo de analisis</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" value="{{$analisis->id}}" name="analisis_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control" name="tipo" required>
                                        <option value="">Seleccione ...</option>
                                        <option value="{{\App\Analisis::CITOLOGIA}}">{{\App\Analisis::CITOLOGIA}}</option>
                                        <option value="{{\App\Analisis::BETHESDA}}">{{\App\Analisis::BETHESDA}}</option>
                                        <option value="{{\App\Analisis::LIQUIDOS}}">{{\App\Analisis::LIQUIDOS}}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary align-right">Establecer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            @if ($nuevoAnalisis)
            if($('#mCambiarPaciente').hasClass('show')){
                $('#mCambiarPaciente').modal('hide');
            }

            $("#tipoAnalisisModal").modal("show");
            @endif


            tinymce.init({
                selector: '#observaciones1',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
            });

            $("#tipoAnalisisForm").submit(function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('citologia.asettipo') }}",
                    type: 'POST',
                    dataType : 'json',
                    data: $('#tipoAnalisisForm').serialize(),
                    success: function (data) {
                        // alert(data.tipo_analisis);
                        if(data.tipo_analisis === '{{ \App\Analisis::LIQUIDOS }}'){
                            window.location.href = "{{ url('/liquidos/crear/'.$analisis->id) }}";
                        } else if(data.tipo_analisis === '{{ \App\Analisis::BETHESDA }}') {
                            window.location.href = "{{ url('/bethesda/crear/'.$analisis->id) }}";
                        } else {
                            window.location.href = "{{ url('/citologia/crear/'.$analisis->id) }}";
                        }
                    },
                    beforeSend: function(xhr, status){
                        // Handle the beforeSend event
                    },
                    complete: function(xhr, status){
                        // Handle the complete event
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcrearinstitucion"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });

            $("#reacInflaForm").submit(function (event) {
                event.preventDefault();
                var riKey = $("#reacInflaForm").find("select[name=tipo]").val();
                var riValue = "SI";

                //alert(riKey+" || "+riValue);
                var numItemReacInfla = $("#reacInflamatoriaList").find("input[type=text]").length;
                if(numItemReacInfla < 10){
                    tplItemReacInfla(riKey, riValue);
                    $("#reacInflaForm")[0].reset();
                    $("#reacInflaModal").modal("hide");
                } else {
                    alert("No puede aumentar mas items.");
                }


            });
            $("#estMicroForm").submit(function (event) {
                event.preventDefault();
                var riName = $("#estMicroForm").find("select[name=tipo]").find('option:selected').text();
                var riKey = $("#estMicroForm").find("select[name=tipo]").val();
                var riValue = $("#estMicroForm").find("input[name=descripcion]").val();

                // alert(riName+" || "+riKey+" || "+riValue);
                var numItemEstMicro = $("#estMicroList").find("input[type=text]").length;
                if(numItemEstMicro < 10){
                    tplItemEstMicro(riName,riKey, riValue);
                    $("#estMicroForm")[0].reset();
                    $("#estMicroModal").modal("hide");
                } else {
                    alert("No puede aumentar mas items.");
                }


            });

        });

        function addExtendidoCompatible(){
            var numItemExtComp = $("#ecdList").find("input[type=checkbox]").length;
            if(numItemExtComp < 10){
                tplItemExtendido($("#s_extendido_compatible").val());
            } else {
                alert("No puede Añadir mas items.");
            }

            $("#ecdModal").modal('hide');
        }

        function tplItemExtendido(nombre){
            var html = "";
            html += "<div class='col-md-3'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemExtendido(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+nombre;
            html += "</p>";
            html += "<input type='checkbox' style='visibility: hidden;' name='ExtComp[]' checked value='"+nombre+"'>";
            html += "</div>";

            $("#ecdList").append(html);
        }

        function removeItemExtendido(link){
            $(link).parent().parent().remove();
        }

        function tplItemReacInfla(key, value){
            var html = "";
            html += "<div class='col-md-4 row'>";
            html += "<div class='col-md-12'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemReacInfla(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+key+' <i class="far fa-check-square"></i>';
            html += "</p>";
            html += "<input type='hidden' name='reacInfla["+key+"]' value='"+value+"'>";
            html += "</div>";
            html += "</div>";

            $("#reacInflamatoriaList").append(html);
        }

        function tplItemEstMicro(name, key, value){
            var html = "";
            html += "<div class='col-md-4 row'>";
            html += "<div class='col-md-6'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px; text-align: right;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemEstudioMicro(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+name;
            html += "</p>";
            html += "</div>";
            html += "<div class='col-md-6'>";
            html += "<input type='text' class='form-control' name='estudioMicro["+key+"]' value='"+value+"' readonly>";
            html += "</div>";
            html += "</div>";

            $("#estMicroList").append(html);
        }


        function removeItemReacInfla(link){
            $(link).parent().parent().parent().remove();
        }

        function removeItemEstudioMicro(link){
            $(link).parent().parent().parent().remove();
        }
    </script>
@endpush
