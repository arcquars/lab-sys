<htmlpageheader name="page-header">
    @if(!$sin)
    <table class="table-head" style="border: solid 1px #1e3a8a">
        <tbody>
            <tr>
                <td style="width: 22%; vertical-align: middle;">
                    <img src="{{public_path('img/labci/labci-new-logo-azul-oscuro.png')}}" width="170">
                </td>
                <td style="width: 56%; vertical-align: top; text-align: center;">
                    <p style="font-size: 15px; text-align: center; font-weight: 900; margin: 5px; color: #172554;">
                        LABORATORIO CLINICO Y DE INVESTIGACIÓN LABCI S.R.L
                    </p>
                    <p style="font-size: 10px; margin-top: 10px; padding-top: 10px;"> 
                        Hematología, Coagulación, Química sanguínea, Serología, Inmunología, Endocrinólogia, Toxicología , Uroanalisis, Parasitología, Microbiología, Biología Molecular.
                    </p>
                </td>
                <td style="width: 22%; vertical-align: middle; text-align: right;">
                    @if($analisis->imprimir_firma && isset($pathQr))
                    <img src="{{ public_path($pathQr) }}" width="70" />
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @endif
</htmlpageheader>
{{--<header>--}}
{{--    <img src="{{public_path('img/hemolab-banner-2.png')}}" >--}}
{{--</header>--}}
<div style="height: 4px;"></div>
