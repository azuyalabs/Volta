@extends('layouts.app')

@section('title')
    @lang('auth.reset_password.title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-5 text-center pb-3">@lang('auth.reset_password.title')</h1>
                <div class="card card-custom">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group form-row">
                                <label for="email" class="col-sm-4 control-label">E-Mail Address</label>

                                <div class="col-sm-6">
                                    <input id="email" type="email"
                                           autocomplete="username"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-row mb-0">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('auth.reset_password.send_link')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
