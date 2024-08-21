@if ($isHasResult)
    @if($imprimir_firma )
        <a href="{{route('analisis.open.esultado.simple.pdf', ['analisisId' =>base64_encode($id)])}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Imprimir Comprobante con firma del doctor">
{{--        <a href="{{route($printAnalisis, ['analisisId' => $id])}}" target="_blank" class="btn btn-link float-right btn-clinica" title="Imprimir Comprobante con firma del doctor">--}}
            <i class="fas fa-file-pdf text-success"></i>
        </a>
    @endif
@endif
