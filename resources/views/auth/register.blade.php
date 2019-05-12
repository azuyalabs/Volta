@extends('layouts.app')

@section('title')
    @lang('auth.register.short_title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-5 text-center pb-3">@lang('auth.register.title')</h1>
                <div class="card card-custom">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group form-row">
                                <label for="name"
                                       class="col-md-4 control-label">@lang('main.name')</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name') }}"
                                           placeholder="@lang('auth.register.placeholder_name')" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="email"
                                       class="col-sm-4 control-label">@lang('auth.email')</label>

                                <div class="col-sm-6">
                                    <input id="email" type="email"
                                           autocomplete="username"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}"
                                           placeholder="@lang('auth.placeholder_email')" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="password"
                                       class="col-md-4 control-label">@lang('auth.password')</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           autocomplete="new-password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" placeholder="@lang('auth.placeholder_password')"
                                           required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="password-confirm"
                                       class="col-sm-4 control-label">@lang('auth.register.password_confirmation')</label>

                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           autocomplete="new-password"
                                           name="password_confirmation"
                                           placeholder="@lang('auth.placeholder_password')" required>
                                </div>
                            </div>

                            <div class="form-group form-row mb-0">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary ">
                                        @lang('auth.register.short_title')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center pt-3">@lang('auth.register.already_account')
                    &nbsp;{{ link_to_route('login', __('auth.login.title')) }}</div>
            </div>
        </div>
    </div>
@endsection
