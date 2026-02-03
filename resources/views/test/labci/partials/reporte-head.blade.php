<htmlpageheader name="page-header">
    @if(!$sin)
    <table class="table-head" style="border: solid 1px #1e3a8a">
        <tbody>
            <tr>
                <td style="width: 35%; vertical-align: middle;">
                    <img src="{{public_path('img/labci/labci-new-logo-azul-oscuro.png')}}" width="170">
                </td>
                <td style="width: 65%; vertical-align: middle; text-align: right;">
                    <img src="{{ public_path($pathQr) }}" width="70" />
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
