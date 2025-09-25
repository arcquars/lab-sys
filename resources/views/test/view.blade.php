@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Análisis</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Pruebas</a></li>
            <li class="breadcrumb-item">Detalle Pruebas</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5 class="h5-cito-titulo">INFORME Pruebas</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <hr>
            @foreach($orderGroupTest as $key => $testResults)
                <h4>{{$key}}</h4>
                @foreach($testResults as $testResult)
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">
                                {{ $testResult['testResult']->aTest->name }}
                            </label>
                        </div>
                        <div class="col-md-4">
                            @if($testResult['testResult']->aTest->analysisTestType)
                            {!! $testResult['testResult']->aTest->analysisTestType->getHtmlResult($testResult['testResult']->id, $testResult['testResult']->result) !!}
{{--                            {!! $testResult->aTest->analysisTestType->getHtmlResult($testResult->id, $testResult->result) !!}--}}
                            @endif
                        </div>
                        <div class="col-md-4">
                            @if($testResult['testResult']->aTest->analysisTestType)
                            {!! $testResult['testResult']->aTest->analysisTestType->getHtmlDescription() !!}
                            @endif

                            @if($testResult['testResult']->metodo)
                                <p style="font-size: 12px"><b>Método: </b> {{ $testResult['testResult']->metodo }}</p>
                            @endif
                        </div>
                    </div>
                    <hr class="m-0" style="background: #91A0B9">
                @endforeach
                <br>
            @endforeach
            <hr>
            <div class="form-group">
                <label for="">Observaciones</label>
                <div class="form-control">
                    {{$analisis->observaciones}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    @can('manage-users-dr')
                    <a href="{{route('test.reporte', ['analisisId' => $analisis->id, 'sin' => 1])}}" target="_blank" class="btn btn-warning">Imprimir para SOBRE</a>
                    <a href="{{route('test.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    @endcan
                    <a href="{{route('test.crear', ['analysisId' => $analisis->id])}}" class="btn btn-lab-pdm-primary">Editar</a>
                    <a href="{{url()->previous()}}" class="btn btn-dark">Atras</a>
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
