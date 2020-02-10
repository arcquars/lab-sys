<?php
$t_CitologiaTotal = 0;
$t_BiopsiaTotal = 0;
$t_InmunoTotal = 0;
$t_BethesdaTotal = 0;
$t_Acuenta = 0;
$t_PagoEfectuado = 0;
$t_Ingreso = 0;
foreach ($resultados as $reporte){
    $t_CitologiaTotal += $reporte->getCitologiaTotal();
    $t_BiopsiaTotal += $reporte->getBiopsiaTotal();
    $t_InmunoTotal += $reporte->getInmunoTotal();
    $t_BethesdaTotal += $reporte->getBethesdaTotal();
    $t_Acuenta += $reporte->getAcuenta();
    $t_PagoEfectuado += $reporte->getPagoEfectuado();
    $t_Ingreso += $reporte->getIngreso();
}
?>
<table>
    <tr>
        <td colspan="11"><h4>Procedencia: {{$institucion}}</h4></td>
    </tr>
</table>
<table class="table-clinica">
    <thead class="thead-dark">
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{\App\Analisis::CITOLOGIA}}</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{\App\Analisis::BIOPSIA}}</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{\App\Analisis::INMUNOHISTOQUIMICA}}</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{\App\Analisis::BETHESDA}}</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Acuenta</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Pago Efectuado</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Ingreso</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($resultados as $reporte)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getFecha()->format('Y-m-d')}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getCitologiaTotal()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getBiopsiaTotal()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getInmunoTotal()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getBethesdaTotal()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getAcuenta()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getPagoEfectuado()}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$reporte->getIngreso()}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Totales</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_CitologiaTotal}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_BiopsiaTotal}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_InmunoTotal}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_BethesdaTotal}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_Acuenta}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_PagoEfectuado}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">{{$t_Ingreso}}</td>
    </tr>
    </tfoot>
</table>
