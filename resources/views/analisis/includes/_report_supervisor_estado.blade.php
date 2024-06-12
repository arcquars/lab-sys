@if($analisisSupervisados > 0)
<style>
    .small-box{
        border-radius: .25rem;
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        display: block;
        margin-bottom: 20px;
        position: relative;
    }

    .small-box > .inner{
        padding: 10px;
    }

    .small-box>.small-box-footer {
        background-color: rgba(0, 0, 0, .1);
        color: rgba(255, 255, 255, .8);
        display: block;
        padding: 3px 0;
        position: relative;
        text-align: center;
        text-decoration: none;
        z-index: 10;
    }

    .small-box .icon > i.ion {
        font-size: 70px;
        top: 20px;
    }

    .small-box .icon > i {
        font-size: 90px;
        position: absolute;
        right: 15px;
        top: 15px;
        transition: -webkit-transform .3s linear;
        transition: transform .3s linear;
        transition: transform .3s linear, -webkit-transform .3s linear;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div class="small-box bg-danger text-white">
            <div class="inner">
                <h3>{{$analisisSupervisados}}</h3>
                <p>Análisis sin aprobar interconsultado</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{url('/analisis?interconsultado=1')}}" class="small-box-footer">Ir a los análisis <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>
@endif
