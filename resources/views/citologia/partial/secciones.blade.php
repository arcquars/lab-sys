<?php
$secciones = array_chunk(Config::get('clinica.extendido_compatible'), 3);
?>
<table>
    @foreach($secciones as $secc)
        <tr>
            @if (count($secc) == 3)
                @foreach($secc as $key => $value12)
                    <td>qqqqqq</td>
                @endforeach
            @endif
        </tr>
    @endforeach
</table>
