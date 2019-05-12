<a href="{{ url('/'. $route) }}" title="@lang('main.back')">
    <button class="btn btn-warning btn-sm text-uppercase">@svg('arrow-left')
        @lang('main.back')
    </button>
</a>
<a href="{{ url('/'.$route.'/' . $model->id . '/edit') }}"
   title="@lang('main.edit_model', ['model' => (new \ReflectionClass($model))->getShortName()])">
    <button class="btn btn-primary btn-sm text-uppercase">@svg('pencil-alt') @lang('main.edit')
    </button>
</a>

<form method="POST" action="{{ url($route . '/' . $model->id) }}" accept-charset="UTF-8"
      style="display:inline">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
    <button type="submit" class="btn btn-danger btn-sm text-uppercase"
            title="@lang('main.delete_model', ['model' => (new \ReflectionClass($model))->getShortName()])"
            onclick="return confirm(&quot;Confirm delete?&quot;)">@svg('trash')
        @lang('main.delete')
    </button>
</form>

@if ($export ?? false)
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle text-uppercase"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @svg('solid/download') @lang('main.export')
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="{{ url('/spools/' . $spool->id . '/export') }}">JSON</a>
            <a class="dropdown-item" href="#">Slic3r PE</a>
        </div>
    </div>
@endif
<br/>
<br/>