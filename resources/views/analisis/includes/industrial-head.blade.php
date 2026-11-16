@php
    $detail = $analisis->industrialExhibition;
    $industrialDisplayFields = [
        'product_name' => 'Producto',
        'rehearsal_date' => 'Fecha de ensayo',
        'lot_number' => 'Nro. de lote',
        'manufacture_date' => 'Fecha de fabricación',
        'expiration_date' => 'Fecha de vencimiento',
    ];
@endphp
<div class="border rounded p-3 mb-3">
    <h6>Muestra industrial</h6>
    @foreach(array_chunk($industrialDisplayFields, 2, true) as $fields)
        <dl class="row row-citologia mb-0">
            @foreach($fields as $field => $label)
                @php
                    $displayValue = $detail ? $detail->{$field} : null;
                    if ($displayValue instanceof \DateTimeInterface) {
                        $displayValue = $displayValue->format('Y-m-d');
                    }
                @endphp
                <dt class="col-md-3">{{ $label }}:</dt>
                <dd class="col-md-3 text-break" style="overflow-wrap: anywhere;">{{ $displayValue ?? '--' }}</dd>
            @endforeach
        </dl>
    @endforeach
</div>
