@extends('users.preferences.preferences')

@section('preference_content')
    <form method="POST" action="{{ url('/preferences/dashboard.clock') }}" accept-charset="UTF-8"
          enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <div class="form-check form-check-inline col-10 align-items-baseline">
            <label for="type" class="col-md-4 control-label">@lang('preferences.clock.type.name')</label>
            <div class="col-md-6">
                @php
                    $preferences['clock']['type'] = $preferences['clock']['type'] ?? 'analog';
                @endphp

                {{  Form::radio('type', 'analog', $preferences['clock']['type'] === 'analog' ? true: false  , ['id' => 'analog', 'class' => 'form-check-input']) }}
                {{  Form::label('analog', __('preferences.clock.type.type_values.analog'), ['class' => 'form-check-label']) }}

                {{  Form::radio('type', 'digital', $preferences['clock']['type'] === 'digital' ? true: false, ['id' => 'digital', 'class' => 'form-check-input']) }}
                {{  Form::label('digital', __('preferences.clock.type.type_values.digital'), ['class' => 'form-check-label']) }}

                <small id="typeHelpBlock" class="form-text text-muted">
                    @lang('preferences.clock.type.description')
                </small>
            </div>
        </div>

        <div class="form-group mt-5 form-row justify-content-end">
            <div class="col-md-offset-4 col-md-4">
                <input class="btn btn-primary" type="submit" value="@lang('main.save')">
            </div>
        </div>

    </form>
@endsection