@extends('layouts.dash', ['activePage' => 'admin_users', 'title' => 'Administrar usuarios', 'navName' => 'Usuarios del Sistema', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Usuarios</a></li>
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
{{--                <div class="col-md-6 text-right"><a href="{{route('admin.users.create')}}" class="btn btn-success">Crear Usuario</a></div>--}}
            </div>
        </div>
        <div class="card-body">
            <form action="{{isset($user)? route('admin.users.update', $user) : route('admin.users.store')}}" method="POST">
                <div class="form-group">
                    <label for="email">Correo Electronico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($user)? $user->email : ''}}" autofocus  autocomplete="off">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($user)? $user->name : '' }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="text-md-right">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>


                @csrf

                @if(isset($user))
                {{method_field('PUT')}}
                @endif

                <div class="form-group">
                @foreach($roles as $role)
                        <div class="form-check">
                    @if(isset($user))
                        <label class="form-check-label">
                            <input type="checkbox" id="frol-{{$role->id}}" name="roles[]" value="{{$role->id}}" class="form-check-input @error('roles') is-invalid @enderror"
                                   @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                            <span class="form-check-sign"></span>
                            {{$role->name}}
                        </label>
                    @else
                        <label class="form-check-label">
                            <input type="checkbox" id="frol-{{$role->id}}" name="roles[]" value="{{$role->id}}" class="form-check-input @error('roles') is-invalid @enderror">
                            <span class="form-check-sign"></span>
                            {{$role->name}}
                        </label>
                    @endif
                        </div>
                @endforeach

                    @error('roles')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                </div>
                <div class="form-group group-doctor" style="display: @if(isset($user)) {{ $user->hasRole('medico')? 'block' : 'none' }} @else none @endif">
                    <label for="fPerson">Doctor</label>
                    <select name="person" id="fPerson" class="form-control">
                        <option value="">Sin asignar</option>
                        @foreach($doctores as $doctor)
                            <option value="{{$doctor->id}}"
                                    @if (isset($user) && $user->person == $doctor->id) selected="selected" @endif
                            >
                                {{$doctor->nombres }} {{$doctor->apellidos }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Grabar</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-dark">Atras</a>
            </form>

        </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $("input[name='roles[]']").change(function() {
                if($(this).val() === '{{ $rolDoctor->id }}') {
                    if(this.checked){
                        $("#fPerson").val('');
                        $(".group-doctor").show();
                    } else {
                        $(".group-doctor").hide();
                    }
                }
                $('#textbox1').val(this.checked);
            });
        });
    </script>
@endpush
