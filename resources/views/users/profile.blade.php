@extends('layouts.default')

@section('page')
@section('title')
    @lang('profile.section')
@endsection
@section('subtitle')
    @lang('profile.subtitle')
@endsection
@section('page-content')
    <form method="POST" action="{{ url('/profile/' . $_user->id) }}" accept-charset="UTF-8"
          enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        @csrf

        <div class="form-group form-row">
            <label for="name" class="col-md-4 control-label">@lang('main.name')</label>
            <div class="col-md-6">
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" name="name" type="text"
                       id="name"
                       value="{{ $_user->name }}" required>
                {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="email" class="col-md-4 control-label">@lang('auth.email')</label>
            <div class="col-md-6">
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" type="email"
                       id="email"
                       value="{{ $_user->email }}" required>
                {!! $errors->first('email', '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="api_token" class="col-md-4 control-label">@lang('profile.api_token')</label>
            <div class="col-md-6">
                <input class="form-control {{ $errors->has('api_token') ? 'is-invalid' : ''}}" name="api_token"
                       type="text" id="api_token"
                       value="{{ $_user->api_token }}" required disabled>
                <small id="apiTokenHelpBlock" class="form-text text-muted">
                    @lang('profile.apiTokenHelpBlock')
                </small>
                {!! $errors->first('api_token', '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="language" class="col-md-4 control-label">@lang('profile.language')</label>
            <div class="col-md-6">
                <select name="language"
                        class="form-control {{ $errors->has('language') ? 'is-invalid' : ''}}"
                        id="language" disabled>
                    @foreach (['en-US' => 'English', 'ja-JP' => 'Japanese'] as $optionKey => $optionValue)
                        <option value="{{ $optionKey }}" {{ (isset($_user->profile->language) && $_user->profile->language === $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                    @endforeach
                </select>
                <small id="languageHelpBlock" class="form-text text-muted">
                    @lang('profile.languageHelpBlock')
                </small>
                {!! $errors->first('language', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="city" class="col-md-4 control-label">@lang('profile.city')</label>
            <div class="col-md-6">
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : ''}}" name="city" type="text"
                       id="city"
                       value="{{ $_user->profile->city }}">
                <small id="cityHelpBlock" class="form-text text-muted">
                    @lang('profile.cityHelpBlock')
                </small>
                {!! $errors->first('city', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="country" class="col-md-4 control-label">@lang('profile.country')</label>
            <div class="col-md-6">
                <select name="country"
                        class="form-control {{ $errors->has('country') ? 'is-invalid' : ''}}"
                        id="country">
                    @foreach (Punic\Territory::getCountries() as $optionKey => $optionValue)
                        <option value="{{ $optionKey }}" {{ (isset($_user->profile->country) && $_user->profile->country === $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                    @endforeach
                </select>
                <small id="countryHelpBlock" class="form-text text-muted">
                    @lang('profile.countryHelpBlock')
                </small>
                {!! $errors->first('country', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group form-row">
            <label for="currency" class="col-md-4 control-label">@lang('profile.currency')</label>
            <div class="col-md-6">
                <select name="currency"
                        class="form-control {{ $errors->has('currency') ? 'is-invalid' : ''}}"
                        id="currency">
                    @foreach (Punic\Currency::getAllCurrencies() as $optionKey => $optionValue)
                        <option value="{{ $optionKey }}" {{ (isset($_user->profile->currency) && $_user->profile->currency === $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                    @endforeach
                </select>
                <small id="currencyHelpBlock" class="form-text text-muted">
                    @lang('profile.currencyHelpBlock')
                </small>
                {!! $errors->first('currency', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <input class="btn btn-primary" type="submit" value="@lang('main.save')">
            </div>
        </div>

    </form>
@endsection
@endsection
