@extends('users.preferences.preferences')

@section('preference_content')
    <form method="POST" action="{{ url('/preferences/dashboard.weather') }}" accept-charset="UTF-8"
          enctype="multipart/form-data" novalidate>
        @method('PATCH')
        @csrf

        <div class="form-check form-check-inline col-10 align-items-baseline">
            <label for="system_of_measure"
                   class="col-md-4 control-label">@lang('preferences.weather.system_of_measure.name')</label>
            <div class="col-md-6">
                @php
                    $preferences['weather']['system_of_measure'] = $preferences['weather']['system_of_measure'] ?? 'metric';
                @endphp

                {{  Form::radio('system_of_measure', 'metric', $preferences['weather']['system_of_measure'] === 'metric' ? true: false  , ['id' => 'metric', 'class' => 'form-check-input']) }}
                {{  Form::label('metric', __('preferences.weather.system_of_measure.type_values.metric'), ['class' => 'form-check-label']) }}

                {{  Form::radio('system_of_measure', 'imperial', $preferences['weather']['system_of_measure'] === 'imperial' ? true: false, ['id' => 'imperial', 'class' => 'form-check-input']) }}
                {{  Form::label('imperial', __('preferences.weather.system_of_measure.type_values.imperial'), ['class' => 'form-check-label']) }}

                <small id="typeHelpBlock" class="form-text text-muted">
                    @lang('preferences.weather.system_of_measure.description')
                </small>
                {!! $errors->first('system_of_measure', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="form-group mt-5 form-row justify-content-end">
            <div class="col-md-offset-4 col-md-4">
                <input class="btn btn-primary" type="submit" value="@lang('main.save')">
            </div>
        </div>

    </form>
@endsection