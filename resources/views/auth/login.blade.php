@extends('layouts.app')

@section('title')
    @lang('auth.login.title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-5 text-center pb-3">@lang('auth.login.title')</h1>
                <div class="card card-custom">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group form-row">
                                <label for="email" class="col-sm-4 control-label">@lang('auth.email')</label>
                                <div class="col-sm-6">
                                    <input type="email" id="email" autocomplete="username"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}"
                                           placeholder="@lang('auth.placeholder_email')" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="password" class="col-sm-4 control-label">@lang('auth.password')</label>
                                <div class="col-sm-6">
                                    <input type="password" id="password" autocomplete="current-password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           placeholder="@lang('auth.placeholder_password')" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            @lang('auth.login.remember_me')
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-row mb-0">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('auth.login.title')
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        @lang('auth.login.forgot_password')
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="text-center pt-3">@lang('auth.login.no_account_yet')
                    &nbsp;{{ link_to_route('register', __('auth.login.register_now')) }}</div>
            </div>
        </div>
    </div>
@endsection
