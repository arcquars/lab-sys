<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Pago</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 10px; }
        .table-detail { 
            width: 100%; 
            /* border-collapse: collapse;  */
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-detail th, .table-detail td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { font-weight: bold; font-size: 12px; text-align: right; margin: 2px 0; }
        .datos-analisis {
            margin: 0 4px;
            font-size: 12px;
        }

        .table-pacient { 
            width: 100%; 
            /* border-collapse: collapse;  */
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-pacient tbody tr td{
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="padding: 0; margin: 0;">{{ config('app.name') }}</h2>
        <h4 style="padding: 0; margin: 0;">{{ config('app.name_large') }}</h4>
        <p style="padding: 0; margin: 0;">Recibo de Orden <b>#{{ $analisis->codigo }}</b></p>
    </div>

    <table class="table-pacient">
        <tbody>
            <tr>
                <td colspan="2">
                    <p class="datos-analisis"><strong>Paciente:</strong> {{ $analisis->person->full_name }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="datos-analisis"><strong>Fecha:</strong> {{ $analisis->fecha->format('d/m/Y') }}</p>
                </td>
                <td>
                    <p class="datos-analisis"><strong>Fecha de impresion:</strong> {{ $fecha_impresion }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    
    

    <div style="height: 4px;"></div>
    <table class="table-detail">
        <thead>
            <tr style="background-color: #f78604">
                <th style="width: 70%; text-align: center;">
                    <p style="font-size: 14x !important;"><b>Estudio</b></p>
                </th>
                <th style="width: 70%; text-align: center;">
                    <p style="font-size: 14px;"><b>Precio (Bs.)</b></p>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderGroupTest as $key => $testResults)
                    <tr>
                        <td colspan="2">
                            <h4>{{$key}}</h4>
                        </td>
                    </tr>
                    @foreach($testResults as $testResult)
                    <tr>
                        <td style="width: 70%;">
                            <p style="margin-left: 15px; font-size: 14px;">{{ $testResult->aTest->name }}</p>
                        </td>
                        <td style="text-align: right;">
                            <p style="margin-left: 15px; font-size: 14px;">{{ number_format($testResult->aTest->price, 2) }}</p>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
        </tbody>
    </table>

    <p class="total">Total a Pagar: {{ number_format($analisis->precio, 2) }}</p>
    <p class="total">A Cuenta: {{ number_format($analisis->acuenta, 2) }}</p>
    <p class="total">Saldo: {{ number_format($analisis->precio - $analisis->acuenta, 2) }}</p>
</body>
</html>