@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Biopsia', 'navName' => 'Biopsia', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Análisis</a></li>
            <li class="breadcrumb-item">Crear Prueba</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analysis])
        </div>
        <div class="card-body">
            <form action="{{url('/test/save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analysis->id}}">

                @foreach($orderGroupTest as $key => $testResults)
                    <h4>{{$key}}</h4>
                    @foreach($testResults as $testResult)
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">
                                    {{ $testResult->aTest->name }}
                                </label>
                            </div>
                            <div class="col-md-4">
                                @if($testResult->aTest->analysisTestType)
                                    {!! $testResult->aTest->analysisTestType->getHtmlInput($testResult->id) !!}
                                    <div class="form-group">
                                        <label for="f_metodo_{{$testResult->a_test_id}}">Metodo</label>
                                        @if(strcmp($metodo, '1') == 0)
                                            <input 
                                                type="text" class="form-control form-control-sm" 
                                                value="{{ $testResult->metodo }}"
                                                name="metodos[{{$testResult->a_test_id}}]" id="f_metodo_{{$testResult->a_test_id}}">
                                        @else
                                        <select name="metodos[{{$testResult->a_test_id}}]" id="f_metodo_{{$testResult->a_test_id}}" class="form-control form-control-sm">
                                            <option value="">Seleccione ...</option>
                                            @foreach(config('clinica.metodos') as $metodo1)
                                                <option value="{{$metodo1}}" @if(isset($testResult->metodo) && strcmp($testResult->metodo, $metodo1) == 0 ) selected @endif>{{$metodo1}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                @else
                                    {{ $testResult->aTest->id }}
                                @endif

                            </div>
                            <div class="col-md-4">
                                @if($testResult->aTest->analysisTestType)
                                {!! $testResult->aTest->analysisTestType->getHtmlDescription() !!}
                                @endif
                            </div>
                        </div>
                        <hr class="m-0" style="background: #91A0B9">
                    @endforeach
                    <br>
                @endforeach

                <div class="form-group">
                    <label for="a-observaciones">Observaciones</label>
                    <textarea name="observaciones" id="a-observaciones" rows="3" class="form-control">{{$analysis->observaciones}}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <div class="float-right">
{{--                            @can('manage-users')--}}
{{--                                <input type="submit" name="grabar-imprimir" class="btn btn-success" value="Grabar/Imprimir" onclick="this.form.target='_blank';return true;">--}}
{{--                            @endcan--}}
                            <input type="submit" name="grabar" class="btn btn-lab-pdm-primary" value="Grabar">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
        });

    </script>
@endpush
