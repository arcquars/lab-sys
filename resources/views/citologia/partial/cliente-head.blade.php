<dl class="row row-citologia">
    <dt class="col-md-3">Nombres y Apellidos:</dt>
    <dd class="col-md-3">{{$analisis->person->apellidos.', '.$analisis->person->nombres}}</dd>
    <dt class="col-md-3">Enviado por (Doctor):</dt>
    <dd class="col-md-3">{{$analisis->doctor}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Procedencia:</dt>
    <dd class="col-md-3">{{$analisis->institucion->nombre}}</dd>
    <dt class="col-md-3">Edad:</dt>
    <dd class="col-md-3">{{$analisis->person->edad}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Sexo:</dt>
    <dd class="col-md-3">{{$analisis->person->sexo}}</dd>
    <dt class="col-md-3">Codigo:</dt>
    <dd class="col-md-3">{{$analisis->codigo}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Analisis Entregado A:</dt>
    <dd class="col-md-3">{{(isset($analisis->persona_entrega)? $analisis->persona_entrega: '--NO ENTREGADO--')}}</dd>
    <dt class="col-md-3">Fecha Entrega:</dt>
    <dd class="col-md-3">{{(isset($analisis->persona_entrega)? $analisis->fecha_entrega: '--NO ENTREGADO--')}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Fecha Cierre:</dt>
    <dd class="col-md-3">{{(isset($analisis->fecha_cierre)? $analisis->fecha_cierre: '--NO CERRADO--')}}</dd>
</dl>
