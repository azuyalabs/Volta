<div class="form-group form-row">
    {!! Form::label('manufacturer_id', __('spools.brand'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {{ Form::select('manufacturer_id', $spool_manufacturers, $spool->manufacturer_id ?? 0, ['placeholder' => 'Pick a manufacturer...', 'class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'required']) }}
        <small id="manufacturer_idHelpBlock" class="form-text text-muted">
            @lang('spools.manufacturer_idHelpBlock')
        </small>
        {!! $errors->first('manufacturer_id', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('material', __('spools.material'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {{ Form::select('material', ['abs' => 'ABS', 'pla' => 'PLA', 'pet' => 'PET'], $spool->material ?? 0, ['placeholder' => 'Pick a material...', 'class' => $errors->has('material') ? 'form-control is-invalid' : 'form-control', 'required']) }}
        <small id="materialHelpBlock" class="form-text text-muted">
            @lang('spools.materialHelpBlock')
        </small>
        {!! $errors->first('material', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('name', __('spools.name'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'id'=> 'name', 'required']); !!}
        <small id="nameHelpBlock" class="form-text text-muted">
            @lang('spools.nameHelpBlock')
        </small>
        {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('purchase_price', __('spools.purchase_price'), ['class' => 'col-md-4 control-label']); !!}
    <div class="input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text"
                  id="purchase_price_currency">@CurrencySymbol(Auth::user()->profile->currency)</span>
        </div>
        {!! Form::number('purchase_price', $spool->purchase_price ?? 0, ['class' => $errors->has('manufacturer_id') ? 'form-control w-50 is-invalid' : 'form-control w-50', 'id'=>
        'purchase_price', 'aria-label' => __('spools.purchase_price'), 'aria-describedby' => 'purchase_price']);
        !!}
        <small id="purchase_priceHelpBlock" class="form-text text-muted">
            @lang('spools.purchase_priceHelpBlock')
        </small>
        {!! $errors->first('purchase_price', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('weight', __('spools.weight'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('weight',$spool->weight ?? 0, ['class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'id'=>
        'weight', 'aria-label' => __('spools.weight'), 'aria-describedby' => 'weight', 'required']);
        !!}
        <small id="weightHelpBlock" class="form-text text-muted">
            @lang('spools.weightHelpBlock')
        </small>
        {!! $errors->first('weight', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('diameter', __('spools.diameter'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('diameter', $spool->diameter ?? 0, ['class' => $errors->has('diameter') ? 'form-control is-invalid' : 'form-control', 'id'=> 'diameter', 'aria-label' => __('spools.diameter'), 'aria-describedby' => 'diameter', 'step' => '0.01', 'required']); !!}
        <small id="diameterHelpBlock" class="form-text text-muted">
            @lang('spools.diameterHelpBlock')
        </small>
        {!! $errors->first('diameter', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('density', __('spools.density'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('density', $spool->density ?? 0, ['class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'id'=> 'density', 'aria-label' => __('spools.density'), 'aria-describedby' => 'density', 'step' => '0.01', 'required']); !!}
        <small id="densityHelpBlock" class="form-text text-muted">
            @lang('spools.densityHelpBlock')
        </small>
        {!! $errors->first('density', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<!-- Usage/consumption -->
<div class="form-group form-row">
    {!! Form::label('usage', __('spools.usage'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::number('usage', $spool->usage ?? 0, ['class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'id'=> 'usage', 'aria-label' => __('spools.usage'), 'aria-describedby' => 'usage', 'min' => 0, 'max' => $spool->length ?? 0]); !!}
        <small id="usageHelpBlock" class="form-text text-muted">
            @lang('spools.usageHelpBlock')
        </small>
        {!! $errors->first('usage', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('color', __('spools.color'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::text('color', null, ['class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'id'=> 'color', 'required']); !!}
        <small id="colorHelpBlock" class="form-text text-muted">
            @lang('spools.colorHelpBlock')
        </small>
        {!! $errors->first('color', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('color_value', __('spools.color_value'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::color('color_value', null, ['class' => $errors->has('manufacturer_id') ? 'form-control is-invalid' : 'form-control', 'id'=> 'color_value', 'required']); !!}
        <small id="colorvalueHelpBlock" class="form-text text-muted">
            @lang('spools.colorvalueHelpBlock')
        </small>
        {!! $errors->first('color_value', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']); !!}
    </div>
</div>