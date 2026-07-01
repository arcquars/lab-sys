<style>
    @page {
        header: page-header;
        margin-header: 10mm;
        margin-top: 3cm;
    }
    body { font-family: sans-serif; font-size: 12px; color: #1e293b; }
    table.cotiz-items { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table.cotiz-items th {
        text-align: left; border-bottom: 1px solid #1e3a8a; padding: 6px 4px; font-size: 11px; color: #1e3a8a;
    }
    table.cotiz-items td { border-bottom: 1px solid #cbd5e1; padding: 6px 4px; }
    table.cotiz-items td.price { text-align: right; white-space: nowrap; }
    .cotiz-total-row td { border-top: 2px solid #1e3a8a; border-bottom: none; font-weight: bold; font-size: 13px; }
    .cotiz-disclaimer { margin-top: 20px; font-size: 10px; color: #64748b; }
</style>

<htmlpageheader name="page-header">
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <img src="{{ public_path('images/hemo-todo.png') }}" width="150">
            </td>
            <td style="width: 50%; text-align: right; vertical-align: middle;">
                <p style="margin: 0;">Cotización de análisis</p>
                <p style="margin: 0; font-size: 10px;">{{ $fecha->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>
    <hr>
</htmlpageheader>

<h3 style="text-align: center;">Cotización de análisis</h3>

<table class="cotiz-items">
    <thead>
        <tr>
            <th>Análisis / Grupo</th>
            <th>Detalle</th>
            <th style="text-align: right;">Precio</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['detail'] }}</td>
                <td class="price">
                    @if($item['price'] > 0)
                        {{ number_format($item['price'], 2) }} Bs.
                    @else
                        Incluido
                    @endif
                </td>
            </tr>
        @endforeach
        <tr class="cotiz-total-row">
            <td colspan="2">Total</td>
            <td class="price">{{ number_format($total, 2) }} Bs.</td>
        </tr>
    </tbody>
</table>

<p class="cotiz-disclaimer">
    Esta cotización es referencial y no representa un compromiso de precio final. Los precios pueden variar
    al momento de realizar el análisis. Válido a la fecha de emisión indicada arriba.
</p>
