@extends('layouts.dash', ['activePage' => 'admin_users', 'title' => 'Administrar usuarios', 'navName' => 'Usuarios del Sistema', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Usuarios</a></li>
            {{-- Verifica si existe la variable $user para determinar si es edición o creación --}}
            @if(isset($user))
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            @endif
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    @if(isset($user))
                        <h4>Editar Usuario {{$user->name}} </h4>
                    @else
                        <h4>Crear Usuario</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Define la acción del formulario: update (PUT) si existe $user o store (POST) si no --}}
            <form action="{{isset($user)? route('admin.users.update', $user) : route('admin.users.store')}}" method="POST">
                
                {{-- Campo Correo Electrónico --}}
                <div class="form-group">
                    <label for="email">Correo Electronico</label>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        {{-- Prioriza old('email') en caso de error de validación, sino usa el valor del usuario o cadena vacía --}}
                        value="{{ old('email', isset($user)? $user->email : '') }}" 
                        autofocus  
                        autocomplete="off">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input 
                        id="name" 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        {{-- Prioriza old('name') en caso de error de validación --}}
                        value="{{ old('name', isset($user)? $user->name : '') }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                {{-- Campo Contraseña (siempre vacío en edición por seguridad) --}}
                <div class="form-group">
                    <label for="password" class="text-md-right">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    {{-- Nota: El campo password no usa old() por seguridad --}}
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                {{-- Campo Confirmar Contraseña --}}
                <div class="form-group">
                    <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    {{-- Nota: El campo confirm password no usa old() por seguridad --}}
                </div>


                @csrf

                {{-- Si es edición, se añade el campo oculto para el método PUT --}}
                @if(isset($user))
                {{method_field('PUT')}}
                @endif

                {{-- Checkboxes para Roles --}}
                <div class="form-group">
                {{-- Itera sobre la colección de roles disponible --}}
                @foreach($roles as $role)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" id="frol-{{$role->id}}" name="roles[]" value="{{$role->id}}" 
                                       class="form-check-input"
                                       {{-- Lógica para el 'checked' --}}
                                       @php
                                            // 1. Verifica si hay un valor 'old' (error de validación) y si el ID del rol está en ese array
                                            $is_old_checked = in_array($role->id, old('roles', []));
                                            
                                            // 2. Si no hay 'old' y estamos editando, verifica si el rol está asignado al usuario
                                            $is_user_checked = isset($user) && $user->roles->pluck('id')->contains($role->id);
                                       @endphp

                                       @if($is_old_checked || (!$errors->any() && $is_user_checked)) checked @endif
                                >
                                <span class="form-check-sign"></span>
                                {{$role->name}}
                            </label>
                        </div>
                @endforeach

                    @error('roles')
                    <span class="text-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                {{-- Campo Asignar Doctor (solo visible si aplica) --}}
                <div class="form-group group-doctor" 
                    style="display: 
                    {{-- Usa la misma lógica de Old/User para manejar la visibilidad en caso de error --}}
                    @php
                        // Determina si el rol de 'medico' fue seleccionado en el POST fallido o ya estaba asignado
                        $is_doctor_role_selected = in_array($rolDoctor->id, old('roles', [])) || (isset($user) && $user->hasRole('medico') && !$errors->any());
                    @endphp
                    @if($is_doctor_role_selected) block @else none @endif
                    ">
                    <label for="fPerson">Doctor</label>
                    <select name="person" id="fPerson" class="form-control">
                        <option value="">Sin asignar</option>
                        {{-- Itera sobre la lista de doctores --}}
                        @foreach($doctores as $doctor)
                            <option value="{{$doctor->id}}"
                                    {{-- Prioriza old('person') en caso de error, sino usa el valor del usuario --}}
                                    @if (old('person') == $doctor->id || (!old('person') && isset($user) && $user->person == $doctor->id)) selected="selected" @endif
                            >
                                {{$doctor->nombres }} {{$doctor->apellidos }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botones de acción --}}
                <button type="submit" class="btn btn-lab-pdm-primary btn-sm">Grabar</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-dark btn-sm">Atras</a>
            </form>

        </div>

    </div>
@endsection
@push('js')
    <script>
        // Usando jQuery 3.6.0
        $(document).ready(function () {
            // Se define el ID del rol de Doctor para la lógica del checkbox.
            // Esto es crucial para la integración.
            const DOCTOR_ROLE_ID = '{{ $rolDoctor->id }}';

            // Escucha el evento 'change' en todos los checkboxes de roles
            $("input[name='roles[]']").on('change', function() {
                // Verifica si el checkbox que se cambió es el de "Doctor"
                if($(this).val() === DOCTOR_ROLE_ID) {
                    const $groupDoctor = $(".group-doctor");
                    
                    if(this.checked){
                        // Si se marca el rol de doctor:
                        // 1. Limpia la selección actual del dropdown para evitar confusiones.
                        // 2. Muestra el grupo del selector de doctores.
                        $("#fPerson").val('');
                        $groupDoctor.slideDown(); // Usando slideDown para una mejor UX
                    } else {
                        // Si se desmarca el rol de doctor:
                        // Oculta el grupo del selector de doctores.
                        $groupDoctor.slideUp(); // Usando slideUp para una mejor UX
                    }
                }
                // Se ha eliminado la línea $('#textbox1').val(this.checked); ya que no tiene un uso visible aquí.
            });
            
            // Lógica para mantener la visibilidad del campo "Doctor" después de un error de validación.
            // Si Laravel recargó la página debido a un error, y el campo 'Doctor' estaba visible, 
            // nos aseguramos de que siga visible en el frontend.
            if ($(".group-doctor").is(':visible')) {
                // Si el elemento ya es visible por la lógica Blade (debido a old() o user asignado),
                // no hacemos nada, pero si quieres asegurar que siempre esté "block" en el DOM ready:
                // Nota: La lógica Blade ya maneja esto, pero esto es un seguro adicional de frontend.
                // $(".group-doctor").show(); 
            }
        });
    </script>
@endpush