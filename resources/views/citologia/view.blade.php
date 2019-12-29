@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Citologia</a></li>
            <li class="breadcrumb-item">Detalle Analisis Citologia</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5 class="h5-cito-titulo">INFORME CITOLOGICO</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <h6 class="h6-cito-titulo">RESULTADO</h6>
            <hr>
            <dl class="row row-citologia">
                <dt class="col-md-3">Clasificacion del Papanicolaou Clase</dt>
                <dd class="col-md-9">{{'( '.$resultados->papanicolaou_clase1.' ) '.$resultados->papanicolaou_clase2}}</dd>
            </dl>
            <h6 class="h6-cito-titulo">Extendido Compatible con los Diagnosticos</h6>
            <div style="height: 8px;"></div>
            <div class="row">
                @foreach(Config::get('clinica.extendido_compatible') as $extComp)
                    @php
                        $item = '(NO) ';
                    @endphp
                    @foreach($seccionExtendidoCompatible as $seccExtComp)
                        @if (strcmp($seccExtComp->key, $extComp) == 0)
                            @php
                                $item = '( SI ) ';
                            @endphp
                        @endif
                    @endforeach
                    <div class="col-md-4">
                        <p class="p-cito-resultado">{{ $item.$extComp}}</p>
                    </div>
                @endforeach
            </div>
            <div style="height: 8px;"></div>
            <table class="table table-bordered table-cito">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">OMS</th>
                    <th scope="col">RICHART</th>
                    <th scope="col">BETHESDA</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="33%" class="align-top">
                        @foreach ($seccionOMG as $seccOmg)
                            <dl class="row row-citologia">
                                <dt class="col-md-8">{{str_replace('-', ' ', $seccOmg->key)}}</dt>
                                <dd class="col-md-4">{{$seccOmg->value}}</dd>
                            </dl>
                        @endforeach
                    </td>
                    <td width="33%" class="align-top">
                        @foreach ($seccionRichart as $seccR)
                            <dl class="row row-citologia">
                                <dt class="col-md-8">{{str_replace('-', ' ', $seccR->key)}}</dt>
                                <dd class="col-md-4">{{$seccR->value}}</dd>
                            </dl>
                        @endforeach
                    </td>
                    <td width="34%" class="align-top">
                        @foreach ($seccionBeth as $seccB)
                            <dl class="row row-citologia">
                                <dt class="col-md-8">{{str_replace('-', ' ', $seccB->key)}}</dt>
                                <dd class="col-md-4">{{$seccB->value}}</dd>
                            </dl>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
            <h6 class="h6-cito-titulo">Reaccion Inflamatoria</h6>
            <div style="height: 8px;"></div>
            <div class="row">
                @foreach(Config::get('clinica.reac_inflamatoria') as $extComp)
                    @php
                    $item = '(NO) ';
                    @endphp
                    @foreach($seccionReacInflamatoria as $seccReacInfla)
                        @if (strcmp($seccReacInfla->key, $extComp) == 0)
                            @php
                                $item = '( SI ) ';
                            @endphp
                        @endif
                    @endforeach
                    <div class="col-md-4">
                        <p class="p-cito-resultado">{{ $item.$extComp}}</p>
                    </div>
                @endforeach
            </div>
            <h6 class="h6-cito-titulo">Estudio Microbiologico</h6>
            <div style="height: 8px;"></div>
            <div class="row">
                @foreach(Config::get('clinica.estudio_microbiologico') as $extComp)
                    @php
                        $item = '(NO) ';
                    @endphp
                    @foreach($seccionEstudioMicro as $seccEstudioMicro)
                        @if (strcmp($seccEstudioMicro->key, $extComp) == 0)
                            @php
                                $item = '( SI ) ';
                            @endphp
                        @endif
                    @endforeach
                    <div class="col-md-4">
                        <p class="p-cito-resultado">{{ $item.$extComp}}</p>
                    </div>
                @endforeach
            </div>
            <div style="height: 8px;"></div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <a href="{{route('citologia.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    <a href="{{route('analisis.index')}}" class="btn btn-dark">Atras</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

        });

    </script>
@endpush