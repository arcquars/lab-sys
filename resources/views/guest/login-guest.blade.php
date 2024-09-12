@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                <div class="card card-login">
                    <div class="card-header"><h3 class="header text-center">Invitado</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('guest.post.login.guest') }}">
                            @csrf
                            <div class="form-group">
                                <label for="p_ci">CI</label>
`                                <input id="p_ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" autofocus >
                                @error('ci')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="password">Contraseña</label>--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach

                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success btn-wd btn-block">
                                        {{ __('Login') }}
                                    </button>

                                    {{--                                @if (Route::has('password.request'))--}}
                                    {{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--                                        ¿Olvidaste tu contraseña?--}}
                                    {{--                                    </a>--}}
                                    {{--                                @endif--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
