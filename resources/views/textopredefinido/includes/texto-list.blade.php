<div class="table-responsive">
    <table class="table table-bordered table-sm table-clinica">
        <thead class="table-dark">
        <tr>
            <th>Act</th>
            <th>Textos</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tlist as $texto)
            <tr>
                <td style="text-align: center;"><a href="#" onclick="copyToClipboard({{$texto->id}}); return false;" class="btn btn-link btn-sm text-success"><i class="far fa-copy fa-lg"></i></a></td>
                <td>
                    <div id="select_t_{{$texto->id}}" class="div-texto" contenteditable="true">
                        {!! $texto->texto !!}
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>