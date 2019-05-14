<div class="form-group form-row">
    {!! Form::label('name', __('manufacturers.name'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'id'=> 'name', 'required', 'placeholder' => 'MakerMake Ltd.']); !!}
        <small id="nameHelpBlock" class="form-text text-muted">
            @lang('manufacturers.nameHelpBlock')
        </small>
        {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('website', __('manufacturers.website'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::text('website', null, ['class' => $errors->has('website') ? 'form-control is-invalid' : 'form-control', 'id'=> 'website', 'placeholder' => 'https://www.makermake.com']); !!}
        <small id="websiteHelpBlock" class="form-text text-muted">
            @lang('manufacturers.websiteHelpBlock')
        </small>
        {!! $errors->first('website', '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('country', __('manufacturers.country'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::select('country', $countries, $manufacturer->country ?? 0, ['class' => $errors->has('country') ? 'form-control is-invalid' : 'form-control', 'id'=> 'country']); !!}
        <small id="countryHelpBlock" class="form-text text-muted">
            @lang('manufacturers.countryHelpBlock')
        </small>
        {!! $errors->first('country', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('filament_supplier', __('manufacturers.filament_supplier'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::checkbox('filament_supplier', 1, $manufacturer->filament_supplier ?? 0, ['class' => $errors->has('filament_supplier') ? 'form-control is-invalid' : 'form-control', 'id'=> 'filament_supplier']); !!}
        <small id="filament_supplierHelpBlock" class="form-text text-muted">
            @lang('manufacturers.filament_supplierHelpBlock')
        </small>
        {!! $errors->first('filament_supplier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group form-row">
    {!! Form::label('equipment_supplier', __('manufacturers.equipment_supplier'), ['class' => 'col-md-4 control-label']); !!}
    <div class="col-md-6">
        {!! Form::checkbox('equipment_supplier', 1, $manufacturer->equipment_supplier ?? 0, ['class' => $errors->has('equipment_supplier') ? 'form-control is-invalid' : 'form-control', 'id'=> 'equipment_supplier']); !!}
        <small id="equipment_supplierHelpBlock" class="form-text text-muted">
            @lang('manufacturers.equipment_supplierHelpBlock')
        </small>
        {!! $errors->first('equipment_supplier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']); !!}
    </div>
</div>


