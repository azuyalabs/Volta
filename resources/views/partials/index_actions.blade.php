<a href="{{ url('/'.$entity.'/create') }}" class="btn btn-success btn-sm text-uppercase"
   title="Add 1New {{ trans_choice($entity.'.model_name', 1) }}">
    @svg('plus') @lang('main.add')
</a>

<form method="GET" action="{{ url('/'.$entity) }}" accept-charset="UTF-8"
      class="form-inline my-2 my-lg-0 float-right" role="search">
    <div class="input-group">
        <input type="text" class="form-control" name="search"
               placeholder="@lang('main.search')..."
               value="{{ request('search') }}">
        <span class="input-group-append">
        <button class="btn btn-secondary" type="submit">
            @svg('search')
        </button>
        </span>
    </div>
</form>
