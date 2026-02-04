<input type="hidden" name="id" value="{{$analysisTest->id}}">
<div class="row">
    <div class="col-md-10 form-group">
        <label for="mtestname">Nombre</label>
        <input type="text" id="mtestname" name="name" class="form-control form-control-sm" value="{{$analysisTest->name}}" aria-describedby="validationTestName">
        <div id="validationTestName" class="invalid-feedback">
        </div>
    </div>
    <div class="col-md-2 form-group">
        <label for="mtestname">Precio</label>
        <input type="number" id="mtestprice" name="price" class="form-control form-control-sm"
               aria-describedby="validationTestPrice" value="{{$analysisTest->price}}">
        <div id="validationTestPrice" class="invalid-feedback">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label for="f_metodo_e">Metodo</label>
        <select name="metodo" id="f_metodo_e" class="form-control form-control-sm">
            {{-- <option value="">Seleccione ...</option>
            @foreach(config('clinica.metodos') as $metodo)
                <option value="{{$metodo}}" @if(isset($analysisTest->metodo) && strcmp($analysisTest->metodo, $metodo) == 0 ) selected @endif>{{$metodo}}</option>
            @endforeach --}}

            <option value="">-- Seleccionar Método.. --</option>
            @foreach($methods as $method)
                {{-- Guardamos el nombre tal como definiste en tu migración (varchar) --}}
                <option 
                    value="{{ $method->name }}"
                    @if(isset($analysisTest->metodo) && strcmp($analysisTest->metodo, $method->name) == 0 ) selected @endif
                >
                    {{ $method->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        @include('a-test.partials.render-group-select-html',['$groups' => $groups, 'group_id' => $analysisTest->a_test_group_id])
{{--        <label for="mtestgroup">Grupo</label>--}}
{{--        <select name="group" id="mtestgroup" class="form-control form-control-sm" aria-describedby="validationTestGroup">--}}
{{--            <option value="">Seleccione...</option>--}}
{{--            @foreach($groups as $id => $gName)--}}
{{--                <option value="{{$id}}" @if($id == $analysisTest->a_test_group_id) selected @endif>{{$gName}}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <div id="validationTestGroup" class="invalid-feedback">--}}
{{--        </div>--}}
    </div>
    <div class="col-md-4">
        <input type="hidden" name="type" value="{{$analysisTest->type}}">
        <fieldset>
            <div class="from-group">
                <label for="mtesttype">Tipo</label>
                <select 
                    id="mtesttype" 
                    class="form-control form-control-sm"
                    aria-describedby="validationTestType"
                    onchange="reloadType(this, '{{ $analysisTest->id }}');"
                >
                    <option value="">Seleccione ...</option>
                    @foreach($aTestTypes as $type)
                        <option value="{{$type}}" @if(strcmp($type, $analysisTest->type) == 0) selected @endif>{{$type}}</option>
                    @endforeach
                </select>
                <div id="validationTestType" class="invalid-feedback">
                </div>
            </div>
        </fieldset>
    </div>
</div>
<hr>
<div class="dTestType">
    @switch($analysisTest->type)
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN)
            @include('a-test.includes.partial-edit-test-range-no-order', ['analysisTestRange' => $analysisTest->analysisTestType])
            @break
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_LIMITE)
            @include('a-test.includes.partial-edit-test-limit', ['analysisTestLimit' => $analysisTest->analysisTestType])
            @break
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_GENERICO)
            @include('a-test.includes.partial-edit-test-generic', ['analysisTestGeneric' => $analysisTest->analysisTestType])
            @break
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO)
            @include('a-test.includes.partial-edit-test-text', ['analysisTestText' => $analysisTest->analysisTestType])
            @break
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_LINEA_TEXTO)
            @include('a-test.includes.partial-edit-test-text', ['analysisTestLineText' => $analysisTest->analysisTestType])
            @break
        @case(\App\AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO)
            @include('a-test.includes.partial-edit-test-positive', ['analysisTestPositive' => $analysisTest->analysisTestType])
            @break
        @default
            @include('a-test.includes.partial-edit-test-range', ['analysisTestRange' => $analysisTest->analysisTestType])
            @break
    @endswitch
</div>
