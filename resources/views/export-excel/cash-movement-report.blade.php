<style>
    .table-clinica thead tr th{
        font-size: 8px;
    }
    .table-clinica tbody tr td, .table-clinica tfoot tr td {
        font-size: 8px;
    }
    .table-clinica tbody tr{
        border-bottom: solid 1px #000;
    }

    .table-clinica {
        border-collapse: collapse;
    }

    .table-clinica, .table-clinica thead tr th, .table-clinica tbody tr td, .table-clinica tfoot tr td {
        border: 1px solid black;
    }
</style>
<h3 class="h2-cito">Reporte Movimiento de caja</h3>
<br>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th>N.</th>
        <th scope="col">Fecha</th>
        <th scope="col">Concepto</th>
        <th scope="col">Descripción</th>
        <th scope="col">Método</th>
        <th scope="col">Usuario</th>
        <th scope="col">Ingreso</th>
        <th scope="col">Egreso</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
        $ingresos = 0;
        $egresos = 0;
    @endphp
    @foreach($cashMovements as $cashMovement)
        @php
        if((strcmp($cashMovement->type, 'INGRESO') == 0)){
            $ingresos += $cashMovement->amount;
        } else {
            $egresos += $cashMovement->amount;
        }
        @endphp
        <tr>
            <td>{{$i++}}</td>
            <td>{{$cashMovement->movement_date}}</td>
            <td>{{$cashMovement->concept->name}}</td>
            <td>{{$cashMovement->description}}</td>
            <td>{{$cashMovement->payment_method}}</td>
            <td>{{$cashMovement->user->name}}</td>
            <td>{{(strcmp($cashMovement->type, 'INGRESO') == 0)? $cashMovement->amount : '-'}}</td>
            <td>{{(strcmp($cashMovement->type, 'INGRESO') != 0)? $cashMovement->amount : '-'}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTALES</td>
        <td>{{$ingresos}}</td>
        <td>{{$egresos}}</td>
    </tr>
    </tfoot>
</table>
