<htmlpageheader name="page-header">
    @if(!$sin)
    <table class="table-head" style="border: solid 1px #1e3a8a">
        <tbody>
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <img src="{{public_path('img/labci/labci-new-logo-azul-oscuro.png')}}" width="155">
                </td>
                <td style="width: 69%; vertical-align: top; vertical-align: middle; text-align: center;">
                    <h4 style="text-align: center; color: #172554; font-size: 15px;">
                        LABORATORIO CLÍNICO Y DE INVESTIGACIÓN LABCI S.R.L
                    </h4>
                    <p style="font-size: 8px; color: #172554; text-transform: uppercase;"> 
                        Hematología - Coagulación -Química sanguínea - Serología - Inmunología - Endocrinología - Toxicología - Uroanalisis - Parasitología - Microbiología - Biología Molecular y genética
                    </p>
                </td>
                <td style="width: 11%; vertical-align: middle; text-align: right;">
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
