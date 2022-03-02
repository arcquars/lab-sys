<style>
    @page {
        header: page-header;
        footer: page-footer;

        margin-header: 13mm;
        margin-top: 3.5cm;
    }
</style>
<htmlpageheader name="page-header">
    {{--    <div style="width: 100%; text-align: center;">--}}
    {{--        <img src="{{public_path('img/clinica.png')}}" width="580">--}}
    {{--    </div>--}}
    <table style="width: 100%;">
        <tr>
            <td width="33%" class="td-datos">
                <p class="td-p-datos">Dr. Victor Hugo Gonzales M.</p>
                <p class="td-p-datos">Dom. 4470226 - Cel. 717 35336</p>
                <p class="td-p-datos">Dr. Abel Acosta Canedo</p>
                <p class="td-p-datos">Dom. 4534469 - Cel. 717 33419</p>
                <p class="td-p-datos">Dr. Jose Luis Gonzales J.</p>
                <p class="td-p-datos">Dom. 4470226 - Cel. 65348759</p>
            </td>
            <td width="34%" style="text-align: center; vertical-align: text-top;">
                <img src="{{public_path('img/clinica.png')}}" width="700">
            </td>
            <td width="33%" style="text-align: right;">
                <p class="td-p-datos">Calle Lanza esq. Ecuador</p>
                <p class="td-p-datos">Edificio Alba IV 1er. Piso</p>
                <p class="td-p-datos">Oficina 1C - 1D y 1E</p>
                <p class="td-p-datos">Telfs. 4255172 - 4520344</p>
                <p class="td-p-datos">E-Mail: citopatologico@hotmail.com</p>
            </td>
        </tr>
    </table>
    <hr style="padding: 0; margin: 0;">
</htmlpageheader>
<div style="height: 4px;"></div>
<h3 style="text-align: center; padding: 0; margin: 2px;">RECEPCION</h3>
<div style="height: 4px;"></div>
<table style="width: 95%;">
    <tr>
        <td style="width: 80%;">
            <dl>
                <dt>
                    <p><b>Paciente</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->person->nombres }} {{ $analisis->person->apellidos }} {{ $analisis->person->apellido_materno }}</p>
                </dd>
                <dt>
                    <p><b>Analisis</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->tipo_analisis }}</p>
                </dd>
                <dt>
                    <p><b>Codigo</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->codigo  }}</p>
                </dd>
                <dt>
                    <p><b>Fecha</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->fecha->format('Y-m-d') }}</p>
                </dd>
            </dl>

        </td>
        <td style="width: 20%;">
            <img src="{{$pathQr}}" width="110">
        </td>
    </tr>
</table>
<p>Usted puede escanear el codigo QR para ver el resultado de su analisis despues de 3 dias de la fecha de ingreso</p>
<br>
