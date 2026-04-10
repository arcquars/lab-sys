<div class="dropdown action-dropdown">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="viewport">
        Acciones
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @can('manage-users')
            @if(!$entregado)
        <a href="#" onclick="openModalFechaEntrega(this); return false;" data-id="{{$id}}" class="dropdown-item" title="Fecha Entrega">
            <i class="far fa-calendar-times"></i> Fecha entrega
        </a>
            @endif
        {{--    @if(!isset($fechaCierre))--}}
        <a href="#" onclick="openModalCerrarAnalisis(this); return false;" data-id="{{$id}}" class="dropdown-item" title="Cerrar Analisis">
            <i class="fas fa-hourglass-end "></i> Cerrar análisis
        </a>
        {{--    @endif--}}
        @endcan
        @if (!$isHasResult)
            <a href="{{ route('analisis.analisisextendido', $id) }}" class="dropdown-item" title="Detallar Resultados">
                <i class="fas fa-tasks"></i> Resultados
            </a>
        @else
            <a href="{{route($routeView, ['analisisId' => $id])}}" class="dropdown-item" title="Ver Resultados">
                <i class="far fa-eye"></i> Ver resultados
            </a>
            @if($imprimir_firma)
            <a href="{{route($printAnalisis, ['analisisId' => $id])}}" target="_blank" class="dropdown-item" title="Imprimir Comprobante con firma del doctor">
                <i class="fas fa-file-pdf text-success"></i> Imprimir con firma
            </a>

            <a href="#" class="dropdown-item" onclick="openModalFechaCierre({{$id}}); return false;" title="Cerrar análisis y actualizar la fecha de entrega">
                <i class="far @if(isset($fechaCierre)) fa-check-square @else fa-square @endif" ></i> Cerrar análisis / Actualizar entrega
            </a>

            @else
                <a href="{{route($printAnalisis, ['analisisId' => $id])}}" target="_blank" class="dropdown-item" title="Imprimir Comprobante sin firma del doctor">
                    <i class="fas fa-file-pdf text-danger"></i> Imprimir sin firma
                </a>
            @endif
            @if(($precio == ($acuenta + $pago_efectuado) && $imprimir_firma) || $convenio)
                @if($send_sms==0)
                <a href="#" onclick="openModalEnviarWappAnalisis(this); return false;" data-id="{{$id}}" target="_blank" class="dropdown-item" title="Enviar analisis por whatsapp">
                    <i class="fab fa-whatsapp text-info"></i> Enviar Resultados
                </a>
                @else
                    <a href="#" onclick="openModalEnviarWappAnalisis(this); return false;" data-id="{{$id}}" target="_blank" class="dropdown-item" title="Enviar analisis por whatsapp">
                        <i class="fab fa-whatsapp text-danger"></i> Enviar Resultados
                    </a>
                @endif
            @endif

        @endif
        @if($precio != ($acuenta + $pago_efectuado))
            @can('manage-users')
            <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="dropdown-item" title="Realizar pago">
                <i class="fas fa-money-bill-wave text-success"></i> Pagar
            </a>
            @endcan
        @endif

        @if($hasAnalisisSupervisado)
            @if($hasAnalisisSupervisadoEstado)
                <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="dropdown-item" title="Análisis verificado">
                    <i class="fas fa-file-excel"></i>
                </a>
            @else
                <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="dropdown-item disabled" title="Análisis sin verificar">
                    <i class="fas fa-file-excel"></i>
                </a>
            @endif
        @endif
        @if(config('clinica.siat_active'))
        <a href="{{ route('siat.invoicing', $id) }}" class="dropdown-item" title="Crear/Ver Factura">
            <i class="fas fa-file-invoice-dollar"></i>
        </a>
        @endif

        @can('manage-admin')
            @if(!$imprimir_firma)
            <a href="#" onclick="openModalDeleteAnalisis({{$id}}); return false;" class="dropdown-item text-danger" title="Crear/Ver Factura">
                <i class="fas fa-trash"></i>
                Eliminar análisis
            </a>
            @endif
        @endcan
    </div>
</div>