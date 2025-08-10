@can('manage-users')
    @if(!$entregado)
<a href="#" onclick="openModalFechaEntrega(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Fecha Entrega">
    <i class="far fa-calendar-times"></i>
</a>
    @endif
{{--    @if(!isset($fechaCierre))--}}
<a href="#" onclick="openModalCerrarAnalisis(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Cerrar Analisis">
    <i class="fas fa-hourglass-end "></i>
</a>
{{--    @endif--}}
@endcan
@if (!$isHasResult)
    <a href="{{ route('analisis.analisisextendido', $id) }}" class="btn btn-link float-right btn-clinica" title="Detallar Resultados">
        <i class="fas fa-tasks"></i>
    </a>
@else
    <a href="{{route($routeView, ['analisisId' => $id])}}" class="btn btn-link float-right btn-clinica" title="Ver Resultados">
        <i class="far fa-eye"></i>
    </a>
    @if($imprimir_firma)
    <a href="{{route($printAnalisis, ['analisisId' => $id])}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Imprimir Comprobante con firma del doctor">
        <i class="fas fa-file-pdf text-success"></i>
    </a>

    <a href="#" class="btn btn-link float-right btn-clinica" onclick="openModalFechaCierre({{$id}}); return false;" title="Cerrar análisis y actualizar la fecha de entrega">
        <i class="far @if(isset($fechaCierre)) fa-check-square @else fa-square @endif" ></i>
    </a>

    @else
        <a href="{{route($printAnalisis, ['analisisId' => $id])}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Imprimir Comprobante sin firma del doctor">
            <i class="fas fa-file-pdf text-danger"></i>
        </a>
    @endif
    @if(($precio == ($acuenta + $pago_efectuado) && $imprimir_firma) || $convenio)
        @if($send_sms==0)
        <a href="#" onclick="openModalEnviarWappAnalisis(this); return false;" data-id="{{$id}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Enviar analisis por whatsapp">
            <i class="fab fa-whatsapp text-info"></i>
        </a>
        @else
            <a href="#" onclick="openModalEnviarWappAnalisis(this); return false;" data-id="{{$id}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Enviar analisis por whatsapp">
                <i class="fab fa-whatsapp text-danger"></i>
            </a>
        @endif
    @endif

@endif
@if($precio != ($acuenta + $pago_efectuado))
    @can('manage-users')
    <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Realizar pago">
        <i class="fas fa-money-bill-wave"></i>
    </a>
    @endcan
@endif

@if($hasAnalisisSupervisado)
    @if($hasAnalisisSupervisadoEstado)
        <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica text-dark disabled" title="Análisis verificado">
            <i class="fas fa-file-excel"></i>
        </a>
    @else
        <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica text-danger disabled" title="Análisis sin verificar">
            <i class="fas fa-file-excel"></i>
        </a>
    @endif
@endif
{{--<a href="{{route('analisis.comprobante', ['analisisId' => $id])}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Imprimir Comprobante">--}}
{{--    <i class="fas fa-print text-success"></i>--}}
{{--</a>--}}
@if(config('clinica.siat_active'))
<a href="{{ route('siat.invoicing', $id) }}" class="btn btn-link float-right btn-clinica" title="Crear/Ver Factura">
    <i class="fas fa-file-invoice-dollar"></i>
</a>
@endif
