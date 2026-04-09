@extends('layouts.dash', [
    'activePage' => 'profile',
    'title'      => 'Mi Perfil',
    'navName'    => 'Mi Perfil',
    'activeButton' => 'largeButton'
])

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mi Perfil</li>
    </ol>
</nav>

{{-- Mensaje de éxito --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    {{-- Avatar generado con las iniciales del usuario --}}
                    <div class="profile-avatar mr-3">
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                        <small class="text-muted">
                            <i class="far fa-envelope mr-1"></i>
                            Correo: {{ $user->email }} <br>
                            <i class="fas fa-user-tag mr-1"></i>
                            Roles:
                            <span class="badge badge-secondary">
                                {{ Auth::user()->roles->implode('name', ', ') ?: 'Sin rol' }}
                            </span>
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Formulario: usa enctype multipart solo si es médico --}}
                <form
                    action="{{ route('profile.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    {{-- ===== SECCIÓN: DATOS BÁSICOS ===== --}}
                    <h6 class="section-title text-muted mb-3">
                        <i class="fas fa-user mr-1"></i> Datos de la cuenta
                    </h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre de usuario</label>
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    autocomplete="off"
                                >
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    autocomplete="off"
                                >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                    </div>

                    <hr>

                    {{-- ===== SECCIÓN: CAMBIO DE CONTRASEÑA ===== --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title text-muted mb-0">
                            <i class="fas fa-lock mr-1"></i> Cambiar contraseña
                        </h6>
                        {{-- Toggle para mostrar/ocultar la sección de contraseña --}}
                        <div class="custom-control custom-switch">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="togglePassword"
                            >
                            <label class="custom-control-label text-muted" for="togglePassword">
                                Quiero cambiar mi contraseña
                            </label>
                        </div>
                    </div>

                    <div id="passwordSection" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva contraseña</label>
                                    <div class="input-group">
                                        <input
                                            id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            autocomplete="new-password"
                                            placeholder="Mínimo 6 caracteres"
                                        >
                                        <div class="input-group-append">
                                            <button
                                                class="btn btn-outline-secondary btn-toggle-password"
                                                type="button"
                                                data-target="#password"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            class="form-control"
                                            name="password_confirmation"
                                            autocomplete="new-password"
                                            placeholder="Repite la nueva contraseña"
                                        >
                                        <div class="input-group-append">
                                            <button
                                                class="btn btn-outline-secondary btn-toggle-password"
                                                type="button"
                                                data-target="#password_confirmation"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Indicador visual de fortaleza de contraseña --}}
                        <div id="passwordStrengthWrapper" class="mb-3" style="display: none;">
                            <small class="text-muted">Fortaleza:</small>
                            <div class="progress" style="height: 6px;">
                                <div
                                    id="passwordStrengthBar"
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: 0%"
                                    aria-valuenow="0"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                            <small id="passwordStrengthText" class="text-muted"></small>
                        </div>
                    </div>

                    {{-- ===== SECCIÓN: FIRMA DEL MÉDICO (solo si tiene rol medico) ===== --}}
                    @if(Auth::user()->hasRole('medico'))
                        <hr>
                        <h6 class="section-title text-muted mb-3">
                            <i class="fas fa-signature mr-1"></i> Firma digital
                            <small class="text-muted font-weight-normal">(Formatos: JPG, PNG, GIF — Máx. 2MB)</small>
                        </h6>

                        <div class="row align-items-center">
                            {{-- Vista previa de la firma actual --}}
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if($doctor && $doctor->signing)
                                    <div class="signing-preview-box">
                                        <img
                                            id="signingPreview"
                                            src="{{ asset('uploads/signings/' . $doctor->signing) }}"
                                            alt="Firma actual"
                                            class="img-fluid"
                                            style="max-height: 100px; border: 1px dashed #ccc; padding: 5px; border-radius: 4px;"
                                        >
                                    </div>
                                    <small class="text-muted d-block mt-1">Firma actual</small>
                                @else
                                    <div class="signing-empty-box text-center text-muted p-3"
                                        style="border: 2px dashed #dee2e6; border-radius: 6px;">
                                        <i class="fas fa-file-image fa-2x mb-1 d-block"></i>
                                        <small>Sin firma cargada</small>
                                    </div>
                                    {{-- Placeholder para la previsualización al seleccionar archivo --}}
                                    <img
                                        id="signingPreview"
                                        src="#"
                                        alt="Vista previa"
                                        class="img-fluid mt-2"
                                        style="display:none; max-height: 100px; border: 1px dashed #ccc; padding: 5px; border-radius: 4px;"
                                    >
                                @endif
                            </div>

                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <label for="signing_file">
                                        {{ ($doctor && $doctor->signing) ? 'Reemplazar firma' : 'Cargar firma' }}
                                    </label>
                                    <div class="custom-file">
                                        <input
                                            type="file"
                                            class="custom-file-input @error('signing_file') is-invalid @enderror"
                                            id="signing_file"
                                            name="signing_file"
                                            accept="image/jpeg,image/png,image/gif"
                                        >
                                        <label class="custom-file-label" for="signing_file">
                                            Seleccionar imagen...
                                        </label>
                                        @error('signing_file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        La imagen se usará como firma en los reportes generados.
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <hr>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-lab-pdm-primary btn-sm">
                            <i class="fas fa-save mr-1"></i> Guardar cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function () {

    // =============================================
    // Toggle para mostrar/ocultar sección contraseña
    // =============================================
    $('#togglePassword').on('change', function () {
        const $section = $('#passwordSection');
        if (this.checked) {
            $section.slideDown(200);
        } else {
            $section.slideUp(200);
            // Limpiar campos al ocultar para no enviar datos vacíos
            $('#password, #password_confirmation').val('');
            $('#passwordStrengthWrapper').hide();
        }
    });

    // =============================================
    // Toggle mostrar/ocultar texto de contraseña
    // =============================================
    $('.btn-toggle-password').on('click', function () {
        const targetId = $(this).data('target');
        const $input   = $(targetId);
        const $icon    = $(this).find('i');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // =============================================
    // Indicador de fortaleza de contraseña
    // =============================================
    $('#password').on('input', function () {
        const val      = $(this).val();
        const $wrapper = $('#passwordStrengthWrapper');
        const $bar     = $('#passwordStrengthBar');
        const $text    = $('#passwordStrengthText');

        if (val.length === 0) {
            $wrapper.hide();
            return;
        }

        $wrapper.show();

        // Calcula un puntaje básico de fortaleza
        let score = 0;
        if (val.length >= 6)  score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { label: 'Muy débil',  color: 'bg-danger',  width: '20%'  },
            { label: 'Débil',      color: 'bg-warning', width: '40%'  },
            { label: 'Regular',    color: 'bg-info',    width: '60%'  },
            { label: 'Fuerte',     color: 'bg-primary', width: '80%'  },
            { label: 'Muy fuerte', color: 'bg-success', width: '100%' },
        ];

        const level = levels[Math.min(score - 1, 4)] || levels[0];

        $bar
            .removeClass('bg-danger bg-warning bg-info bg-primary bg-success')
            .addClass(level.color)
            .css('width', level.width);
        $text.text(level.label);
    });

    // =============================================
    // Previsualización de firma al seleccionar archivo
    // =============================================
    $('#signing_file').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Actualiza el label del custom-file-input con el nombre del archivo
        $(this).next('.custom-file-label').text(file.name);

        // Muestra la previsualización de la imagen seleccionada
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#signingPreview')
                .attr('src', e.target.result)
                .show();
            // Oculta el placeholder vacío si existía
            $('.signing-empty-box').hide();
        };
        reader.readAsDataURL(file);
    });

    // =============================================
    // Si hubo error de validación y password tenía valor,
    // mostrar automáticamente la sección de contraseña
    // =============================================
    @if($errors->has('password') || $errors->has('password_confirmation'))
        $('#togglePassword').prop('checked', true);
        $('#passwordSection').show();
    @endif

});
</script>

<style>
    /* Avatar con iniciales del usuario */
    .profile-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background-color: #3d7cad;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .profile-avatar span {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 1px;
    }
    /* Título de sección dentro del formulario */
    .section-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
</style>
@endpush