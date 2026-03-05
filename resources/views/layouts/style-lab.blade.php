<style>
            @switch(config('app.theme_color'))
                @case('red')
                    .btn-lab-pdm-primary{
                        color: #fff;
                        background-color: #dc3545;
                        border-color: #e3342f;
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background: #F86870;
                        border-color: #e3342f;
                    }
                    @break

                @case('blue')
                    .btn-lab-pdm-primary {
                        color: #fff;
                        background-color: #2274D1; /* Azul solicitado */
                        border-color: #1e67ba;     /* Un azul un poco más oscuro para el borde */
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background-color: #3e8ae1; /* Un azul más claro para el efecto hover */
                        border-color: #1e67ba;
                    }
                    @break
                @case('purple')
                    .btn-lab-pdm-primary {
                        color: #fff;
                        background-color: #AC88EE; /* Púrpura solicitado */
                        border-color: #9575d1;     /* Un tono más oscuro para el borde */
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background-color: #c0a4f2; /* Un tono más claro y vibrante para el hover */
                        border-color: #9575d1;
                    }
                    @break
                @case('green')
                    .btn-lab-pdm-primary {
                        color: #fff;
                        background-color: #A1D64D; /* Verde solicitado */
                        border-color: #88B641;     /* Un verde más oscuro para el borde */
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background-color: #BBE07D; /* Una versión más clara para el efecto hover */
                        border-color: #88B641;
                    }
                    @break
                @case('orange')
                    .btn-lab-pdm-primary {
                        color: #fff;
                        background-color: #FFA033; /* Naranja solicitado */
                        border-color: #E68A19;     /* Un tono más oscuro/quemado para el borde */
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background-color: #FFB766; /* Una versión más clara y vibrante para el hover */
                        border-color: #E68A19;
                    }
                    @break
                @default
                    .btn-lab-pdm-primary {
                        color: #fff;
                        background-color: #777777; /* Gris solicitado */
                        border-color: #666666;     /* Gris un poco más oscuro para el borde */
                    }

                    .btn-lab-pdm-primary:hover {
                        color: #fff;
                        opacity: 1;
                        background-color: #999999; /* Gris más claro para el efecto hover */
                        border-color: #666666;
                    }
            @endswitch
        </style>