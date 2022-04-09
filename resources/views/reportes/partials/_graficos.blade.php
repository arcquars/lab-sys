<form id="fGraficReport" onsubmit="ftnSubmit(this); return false;">
<div class="row" style="text-align: left;">
    <div class="col-md-5 form-group">
        <label for="f_inicio">Fecha inicio</label>
        <input type="date" name="f_inicio" value="{{ $dateI->format('Y-m-d') }}" class="form-control form-control-sm">
        <div class="fcp_error fcp_error_f_inicio"></div>
    </div>
    <div class="col-md-5 form-group">
        <label for="f_inicio">Fecha Fin</label>
        <input type="date" name="f_fin" class="form-control form-control-sm" value="{{ $dateF->format('Y-m-d') }}">
        <div class="fcp_error fcp_error_f_fin"></div>
    </div>
    <div class="col-md-2">
        <label for="">.</label><br>
        <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fas fa-search"></i></button>
    </div>
</div>
</form>
<div class="row">
    <div class="col-md-12">
        <div id="chart_div"></div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div id="chart_doctores_div"></div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div id="chart_creadores_div"></div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div id="chart_usuario_trabajo"></div>
        <br>
        <div class="table-responsive table-responsive-sm">
            <table id="t_result_works" class="table table-sm table-bordered">
                <thead class="table-dark">
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>
@push('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $(document).ready(function () {
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart', 'table', 'bar'], 'callback': ftnSubmit});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // $("#fGraficReport").submit();
        });
    </script>
    <script type="text/javascript">
        function ftnSubmit(){
            ftnAnalisisCount($('#fGraficReport'));
        }

        function ftnAnalisisCount(form){
            $.ajax({
                url: "{{ route('analisis.aGraficReport') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    console.log(JSON.stringify(data));
                    google.charts.setOnLoadCallback(drawChart(data.analisisTipo));
                    google.charts.setOnLoadCallback(drawChartDoctores(data.analisisDoctores));
                    google.charts.setOnLoadCallback(drawChartCreadores(data.analisisCreadores));
                    google.charts.setOnLoadCallback(drawBarWorkings(data.usuarioWorks));

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    printErrorMsg(form, XMLHttpRequest.responseJSON);
                }
            });
        }

        function drawChart(result) {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Analisis');
            data.addColumn('number', 'Total');

            var datos = [];
            $.each(result, function(indice, analisi){
                if(analisi.tipo_analisis === "{{ \App\Analisis::HISTOPATOLOGICO  }}"){
                    datos.push(['{{\App\Analisis::BIOPSIA_DE_RINON}}', analisi.count]);
                } else {
                    datos.push([analisi.tipo_analisis, analisi.count]);
                }

            });
            data.addRows(datos);
            // Set chart options
            const options = {'title':'Análisis mas requeridos',
                'width': 'auto',
                'height':'auto'};
            // Instantiate and draw our chart, passing in some options.
            const chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function drawChartDoctores(result) {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Doctores');
            data.addColumn('number', 'Total');

            var datos = [];
            $.each(result, function(indice, analisi){
                datos.push([analisi.nombres, analisi.count]);
            });
            data.addRows(datos);
            // Set chart options
            const options = {'title':'Asignacion de doctores',
                'width': 'auto',
                'height':'auto'};
            // Instantiate and draw our chart, passing in some options.
            const chart = new google.visualization.PieChart(document.getElementById('chart_doctores_div'));
            chart.draw(data, options);
        }

        function drawChartCreadores(result) {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Creador');
            data.addColumn('number', 'Total');

            var datos = [];
            $.each(result, function(indice, analisi){
                datos.push([analisi.name, analisi.count]);
            });
            data.addRows(datos);
            // Set chart options
            const options = {'title':'Usuarios que registraron análisis',
                'width': 'auto',
                'height':'auto'};
            // Instantiate and draw our chart, passing in some options.
            const chart = new google.visualization.PieChart(document.getElementById('chart_creadores_div'));
            chart.draw(data, options);
        }

        function drawBarWorkings(result) {
            // Create the data table.
            console.log('wwwwwwwwwww');
            console.log(JSON.stringify(result));
            const data = google.visualization.arrayToDataTable(result);

            // Set chart options
            const options = {
                chart: {
                    title: 'Usuario que trabajaron en el llenado de analisis',
                    // subtitle: 'Usuario, ',
                }
            };
            // Instantiate and draw our chart, passing in some options.
            const chart = new google.charts.Bar(document.getElementById('chart_usuario_trabajo'));
            chart.draw(data, google.charts.Bar.convertOptions(options));

            let tr = "";
            let trH = "";
            $.each(result, function(index, res){
                if(index == 0){
                    trH += "<tr>";
                    trH += "<th>" + res[0] + "</th>";
                    trH += "<th>" + res[1] + "</th>";
                    trH += "<th>" + res[2] + "</th>";
                    trH += "<th>" + res[3] + "</th>";
                    trH += "<th>" + res[4] + "</th>";
                    trH += "<th>" + res[5] + "</th>";
                    trH += "<th>" + res[6] + "</th>";
                    trH += "<th>Totales</th>";
                    trH += "</tr>";
                } else {
                    tr += "<tr>";
                    tr += "<td>" + res[0] + "</td>";
                    tr += "<td>" + res[1] + "</td>";
                    tr += "<td>" + res[2] + "</td>";
                    tr += "<td>" + res[3] + "</td>";
                    tr += "<td>" + res[4] + "</td>";
                    tr += "<td>" + res[5] + "</td>";
                    tr += "<td>" + res[6] + "</td>";
                    tr += "<td>" + (res[1]+res[2]+res[3]+res[4]+res[5]+res[6]) + "</td>";
                    tr += "</tr>";
                }

            });
            $("#t_result_works tHead").empty().append(trH);
            $("#t_result_works tbody").empty().append(tr);
        }

        function printErrorMsg(form, msg) {
            $(".fcp_error").empty();
            $.each(msg.errors, function (key, value) {
                // $(form).find("input[name='" + key + "']").addClass('is-invalid');
                var msgs = "<ul class='list-unstyled'>";
                $.each(value, function (key1, value1) {
                    msgs += "<li><span class='text-danger'>" + value1 + "</span></li>";
                });
                msgs += "</ul>";
                $('.fcp_error_' + key).empty().append(msgs);
                $('.fcp_error_' + key).show();
            });
        }
    </script>

@endpush
