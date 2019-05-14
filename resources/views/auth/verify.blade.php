@extends('layouts.app')

@section('title')
    @lang('auth.verify.title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-5 pb-3">@lang('auth.verify.title')</h1>
                <div class="card card-custom">
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                @lang('auth.verify.link_sent')
                            </div>
                        @endif

                        @lang('auth.verify.before_proceeding')<br/>
                        @lang('auth.verify.request_another', ['link' => route('verification.resend')])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
