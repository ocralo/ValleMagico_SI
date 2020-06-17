@extends('layouts.app')


@section('styles')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid container-page-login">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-10 d-flex justify-content-center">
            <div class="card card-register-body">
                <div class="card-header text-center">
                    <h4>
                        {{ __('¿Prolemas para iniciar sesión?') }}
                    </h4>
                </div>

                <div class="card-body pt-1 px-4 text-justify">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form> --}}
                <p>
                    {{ __('
                        Si presenta problema para recordar su contraseña e ingresar al sistema de información de ') }}
                    <strong>
                        {{ __('
                        Valle magico) }}
                    </strong>
                    {{ __('
                        , por favor, enviar un email a, ') }}
                    <strong>
                        {{ __('
                        vallemagico.soporte@gmail.com ') }}
                    </strong>
                    {{ __('
                        con el asunto "Olvidé mi contraseña"') }}
                </p>
                <p>
                    {{ __('Con la siguiente información:') }}
                </p>
                <ol>

                    <li>
                        {{ __('Nombre completo') }}
                    </li>
                    <li>
                        {{ __('Nombre de usuario') }}
                    </li>
                    <li>
                        {{ __('Última contraseña que recuerde') }}
                    </li>

                </ol>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
