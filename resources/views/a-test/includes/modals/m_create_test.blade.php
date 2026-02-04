<!-- Modal Create Test -->
<div id="mCreateTest" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="saveTest(this); return false;">
        @csrf
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Prueba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 form-group">
                            <label for="mtestname">Nombre</label>
                            <input type="text" id="mtestname" name="name" class="form-control form-control-sm" aria-describedby="validationTestName">
                            <div id="validationTestName" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="mtestname">Precio</label>
                            <input type="number" id="mtestprice" name="price" class="form-control form-control-sm" aria-describedby="validationTestPrice">
                            <div id="validationTestPrice" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="f_metodo">Metodo</label>
                            <select name="metodo" id="f_metodo" class="form-control form-control-sm">
                                {{-- <option value="">Seleccione ...</option>
                                @foreach(config('clinica.metodos') as $metodo)
                                    <option value="{{$metodo}}" @if(isset($testResult->metodo) && strcmp($testResult->metodo, $metodo) == 0 ) selected @endif>{{$metodo}}</option>
                                @endforeach --}}

                                <option value="">-- Seleccionar Método --</option>
                                @foreach($methods as $method)
                                    {{-- Guardamos el nombre tal como definiste en tu migración (varchar) --}}
                                    <option 
                                        value="{{ $method->name }}"
                                        @if(isset($testResult->metodo) && strcmp($testResult->metodo, $metodo->name) == 0 ) selected @endif
                                    >
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="testgroup" class="col-md-4">
{{--                            <label for="mtestgroup">Grupo</label>--}}
{{--                            <select name="group" id="mtestgroup" class="form-control form-control-sm" aria-describedby="validationTestGroup">--}}
{{--                            </select>--}}
{{--                            <div id="validationTestGroup" class="invalid-feedback">--}}
{{--                            </div>--}}
                        </div>
                        <div class="col-md-4">
                            <label for="mtesttype">Tipo</label>
                            <select name="type" id="mtesttype" class="form-control form-control-sm"
                                    onchange="loadTestType(this);" aria-describedby="validationTestType">
                                @foreach($rangeTypeList as $rangeType)
                                <option value="{{$rangeType}}" @if(strcmp($rangeType, "Linea de texto") == 0) selected @endif >{{$rangeType}}</option>
                                @endforeach
                            </select>
                            <div id="validationTestType" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="dTestType"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-lab-pdm-primary">Crear</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
function openModalCreateTest(){
    resetModalCreateTest();
    $.ajax({
        url: "{{ route('analisis-test.get-group-type') }}",
        // data: $(form).serialize(),
        success: function (data) {
            // $("#mCreateTest").modal('show');
            // $("#mtestgroup").empty().append(loadSelectGroup(data.groups));
            $("#mCreateTest").modal('show');
            $("#testgroup").empty().append(data);

        }
    });
}

function loadSelectGroup(groups){
    let options = "<option value=''>Seleccione ...</option>";
    Object.entries(groups).forEach(([key, value]) => {
        options += "<option value='"+value+"'>"+key+"</option>";
        // console.log(`${key} ${value}`);
    });
    return options;
}

function loadTestType(select){
    let testType = $(select).val();
    if(testType !== ''){
        $.ajax({
            url: "{{ route('analysis-test.render-test-type') }}",
            data: {test_type: testType},
            success: function (data) {
                $(".dTestType").empty().append(data);
            }
        });
    } else {
        $(".dTestType").empty();
    }
}

function resetModalCreateTest(){
    $("#mCreateTest form")[0].reset();
    $("#mCreateTest .dTestType").empty();
    clearSaveTestFormValidation();
}

function saveTest(form){
    clearSaveTestFormValidation();
    $.ajax({
        url: "{{ route('analysis-test.store.test') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mCreateTest").modal('hide');
            loadTreeTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (const [key, value] of Object.entries(XMLHttpRequest.responseJSON.errors)) {
                console.log(`${key}: ${value}`);
                let inputName = "#mtest" + key.replaceAll(".", "_");
                console.log("PDM:: ids: " + inputName);
                $(inputName).addClass('is-invalid');
                $(inputName).next().empty().append(value);

                inputName = "#mgroup" + key.replaceAll(".", "_");
                $(inputName).addClass('is-invalid');
                $(inputName).next().empty().append(value);
            }
        }
    });
}

function clearSaveTestFormValidation(){
    // $("#mCreateTest form").find("select, textarea, input:not(:hidden), input").each(function(index, element) {
    //     if($(element).attr('id') !== undefined && $(element).attr('type') !== 'radio'){
    //         $(element).removeClass('is-invalid');
    //         $(element).next().empty();
    //     }
    // });
    $("#mCreateTest form .form-control").each(function(index, element) {
        if($(element).attr('id') !== undefined && $(element).attr('type') !== 'radio'){
            $(element).removeClass('is-invalid');
            $(element).next().empty();
        }
    })
}
    </script>
@endpush
