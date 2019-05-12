<div class="form-group form-row">
    {!! Form::label('model_id', __('machines.model'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::select('model_id',$models, $machine->model_id ?? 0,['class' => $errors->has('model_id') ? 'form-control is-invalid' : 'form-control', 'id'=> 'model_id', 'required']); !!}
        {!! $errors->first('model_id', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('name', __('machines.name'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'id'=> 'name', 'required']); !!}
        {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('lifespan', __('machines.lifespan'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('lifespan',$machine->lifespan ?? 1, ['class' => $errors->has('lifespan') ? 'form-control is-invalid' : 'form-control', 'id'=> 'lifespan', 'aria-label' => __('machines.lifespan'), 'aria-describedby' => 'lifespanHelpBlock']); !!}
        <small id="lifespanHelpBlock" class="form-text text-muted">
            The expected number of years this machine will be used.
        </small>
        {!! $errors->first('lifespan', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('acquisition_cost', __('machines.acquisition_cost'), ['class' => 'col-md-4 control-label']); !!}
    <div class="input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text" id="acquisition_cost_currency">@CurrencySymbol(Auth::user()->profile->currency)</span>
        </div>
        {!! Form::number('acquisition_cost', isset($machine) ? $machine->acquisition_cost->formatByDecimal() : 0, ['class' => $errors->has('acquisition_cost') ? 'form-control is-invalid' : 'form-control', 'id'=> 'acquisition_cost', 'aria-label' => __('machines.acquisition_cost'), 'aria-describedby' => 'acquisition_cost_currency']); !!}
        <small id="acquisition_costHelpBlock" class="form-text text-muted w-100">
            The price of this machine when purchased or acquired.
        </small>
        {!! $errors->first('acquisition_cost', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('residual_value', __('machines.residual_value'), ['class' => 'col-md-4 control-label']); !!}
    <div class="input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text"
                  id="residual_value_currency">@CurrencySymbol(Auth::user()->profile->currency)</span>
        </div>
        {!! Form::number('residual_value', isset($machine) ? $machine->residual_value->formatByDecimal() : 0, ['class' => $errors->has('residual_value') ? 'form-control is-invalid' : 'form-control', 'id'=> 'residual_value', 'aria-label' => __('machines.residual_value'), 'aria-describedby' => 'residual_value_currency']); !!}
        <small id="residual_valueHelpBlock" class="form-text text-muted w-100">
            The expected value of this machine after it has been retired.
        </small>
        {!! $errors->first('residual_value', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('maintenance_cost', __('machines.maintenance_cost'), ['class' => 'col-md-4 control-label']); !!}
    <div class="input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text" id="maintenance_cost_currency">@CurrencySymbol(Auth::user()->profile->currency)</span>
        </div>
        {!! Form::number('maintenance_cost', isset($machine) ? $machine->maintenance_cost->formatByDecimal() : 0, ['class' => $errors->has('maintenance_cost') ? 'form-control is-invalid' : 'form-control', 'id'=> 'maintenance_cost', 'aria-label' => __('machines.maintenance_cost'), 'aria-describedby' => 'maintenance_cost_currency']); !!}
        <small id="maintenance_costHelpBlock" class="form-text text-muted w-100">
            The estimated maintenance cost (part upgrades, materials for regular upkeep, etc.) of this machine during
            it's lifetime.
        </small>
        {!! $errors->first('maintenance_cost', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('operating_hours', __('machines.operating_hours'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('operating_hours',$machine->operating_hours ?? 1, ['class' => $errors->has('operating_hours') ? 'form-control is-invalid' : 'form-control', 'id'=> 'operating_hours', 'aria-label' => __('machines.operating_hours'), 'aria-describedby' => 'operating_hours']); !!}
        <small id="operating_hoursHelpBlock" class="form-text text-muted">
            The estimated number of hours annually this machine will be in operation.
        </small>
        {!! $errors->first('operating_hours', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('energy_consumption', __('machines.energy_consumption'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('energy_consumption',$machine->energy_consumption ?? 0, ['class' => $errors->has('energy_consumption') ? 'form-control is-invalid' : 'form-control', 'id'=> 'energy_consumption', 'aria-label' => __('machines.energy_consumption'), 'aria-describedby' => 'energy_consumption']); !!}
        <small id="energy_consumptionHelpBlock" class="form-text text-muted">
            Average power usage during normal usage.
        </small>
        {!! $errors->first('energy_consumption', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']); !!}
    </div>
</div>


