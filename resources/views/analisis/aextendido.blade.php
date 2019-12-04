@extends('layouts.dash', ['activePage' => 'clients', 'title' => 'Administrar Clientes', 'navName' => 'Clientes', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form method="post" action="/analisis">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-5 col-form-label" style="text-align: right">Clasificacion del Papanicolau Clase</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <h3 class="ana-ext-title text-muted">Extendido Compatible con los Diagnosticos</h3>
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <input type="checkbox" name="epi">
                                <label for="epi">EPITELIO NORMAL</label>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="colpitis">
                                <label for="colpitis">COLPITIS</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <input type="checkbox" name="ectopia">
                                <label for="ectopia">ECTOPIA</label>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cervicitis">
                                <label for="cervicitis">CERVICITIS</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <input type="checkbox" name="endocervicitis">
                                <label for="endocervicitis">ENDOCERVICITIS</label>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="queratosis">
                                <label for="queratosis">QUERATOSIS</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <input type="checkbox" name="metaplasia-escamosa">
                                <label for="metaplasia-escamosa">METAPLASIA ESCAMOSA</label>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="carcinoma-e-i">
                                <label for="carcinoma-e-i">CARCINOMA ESC. INV.</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <input type="checkbox" name="adenocarcinoma">
                                <label for="adenocarcinoma">ADENOCARCINOMA</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">OMS</h3>
                            <div class="form-group row">
                                <label for="displasia-leve" class="col-md-6 col-form-label text-right">DISPLASIA LEVE</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="displasia-leve">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-moderada" class="col-md-6 col-form-label text-right">DISPLASIA MODERADA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="displasia-moderada">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-severa" class="col-md-6 col-form-label text-right">DISPLASIA SEVERA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="displasia-severa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-in" class="col-md-6 col-form-label text-right">DISPLASIA "IN SITU"</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="displasia-in">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">HICHART</h3>
                            <div class="form-group row">
                                <label for="nic-i" class="col-md-6 col-form-label text-right">NIC I</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="nic-i">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-ii" class="col-md-6 col-form-label text-right">NIC II</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="nic-ii">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-iii" class="col-md-6 col-form-label text-right">NIC III</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="nic-iii">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-iv" class="col-md-6 col-form-label text-right">NIC IV</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="nic-iv">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">BETHESDA (N.C.I.)</h3>
                            <div class="form-group row">
                                <label for="lis-bajo" class="col-md-6 col-form-label text-right">LIS DE BAJO GRADO</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="lis-bajo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lis-alto" class="col-md-6 col-form-label text-right">LIS DE ALTO GRADO</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="lis-alto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="ana-ext-title text-muted">REACCION INFLAMATORIA</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-ausente">
                                    <label for="reac-ausente">AUSENTE</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-ausente-text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-leve">
                                    <label for="reac-leve">LEVE</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-leve-text" class="form-control form-control-sm">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-moderada">
                                    <label for="reac-moderada">MODERADA</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-moderada-text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-acentuada">
                                    <label for="reac-acentuada">ACENTUADA</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-acentuada-text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-vagina">
                                    <label for="reac-vagina">VAGINA</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-vagina-text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-cervi">
                                    <label for="reac-cervi">CERVI</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-cervi-text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-endocermix">
                                    <label for="reac-endocermix">ENDOCERMIX</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-endocermix-text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-right">
                                <div class="checkbox">
                                    <input type="checkbox" name="reac-otros">
                                    <label for="reac-otros">OTROS</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="reac-otros-text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cerrar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {


        });


    </script>
@endpush