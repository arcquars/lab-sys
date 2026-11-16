@php
    $industrialDetail = isset($analisis) ? $analisis->industrialExhibition : null;
    $industrialFields = [
        'product_name' => ['Producto', 'text', true, 'col-md-6'],
        'rehearsal_date' => ['Fecha de ensayo', 'date', true, 'col-md-6'],
        'lot_number' => ['Nro. de lote', 'text', false, 'col-md-4'],
        'manufacture_date' => ['Fecha de fabricación', 'date', false, 'col-md-4'],
        'expiration_date' => ['Fecha de vencimiento', 'date', false, 'col-md-4'],
    ];
@endphp
<div class="form-group">
    <input type="hidden" name="is_industrial" value="0">
    <div class="form-check">
        <label class="form-check-label" for="is_industrial">
            <input class="form-check-input @error('is_industrial') is-invalid @enderror"
                   id="is_industrial" name="is_industrial" type="checkbox" value="1"
                   @if($isIndustrial) checked @endif>
            <span class="form-check-sign"></span>
            Muestra industrial
        </label>
    </div>
    @error('is_industrial')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div id="industrialFields" class="border rounded p-3 mb-3 @if(!$isIndustrial) d-none @endif">
    <h6>Muestra industrial</h6>
    <div class="row">
        @foreach($industrialFields as $field => $definition)
            @php
                $savedValue = $industrialDetail ? $industrialDetail->{$field} : null;
                if ($savedValue && $definition[1] === 'date') {
                    $savedValue = $savedValue->format('Y-m-d');
                }
            @endphp
            <div class="col-12 {{ $definition[3] }} form-group">
                <label for="industrial_{{ $field }}">
                    {{ $definition[0] }} @if($definition[2]) <span class="text-danger">*</span> @endif
                </label>
                <input id="industrial_{{ $field }}" name="{{ $field }}" type="{{ $definition[1] }}"
                       class="form-control @error($field) is-invalid @enderror"
                       value="{{ old($field, $savedValue) }}"
                       @if($definition[1] === 'text') maxlength="250" @endif
                       @if($definition[2]) data-industrial-required="1" @if($isIndustrial) required @endif @endif
                       @if(!$isIndustrial) disabled @endif>
                @error($field)
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    </div>
</div>
@push('js')
    @include('analisis.includes.industrial-script')
@endpush
