<htmlpageheader name="page-header">
    @if(!$sin)
    <table class="table-head" style="border: solid 1px #1e3a8a">
        <tbody>
            <tr>
                <td style="width: 35%; vertical-align: middle;">
                    <img src="{{public_path('img/labtest/labtest-logo.png')}}" width="170">
                </td>
                <td style="width: 65%; vertical-align: middle; text-align: right;">
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
