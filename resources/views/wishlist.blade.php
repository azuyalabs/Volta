<h1>{{ $title }}</h1>
<p>
    Below you can find a list of wishes (i.e. feature requests) that have been requested (and completed) up until this
    date.
</p>
<p>
    As this project is still a prototype and in an Alpha stage, I can't make any concrete commitments at the moment
    when/if these will be implemented. That all depends on the complexity and feasibility of your request.
</p>
<p>
    No issue or feature request system is in use yet, so please use the following channels to submit your request:
</p>
<ul>
    <li><a href="https://www.facebook.com/groups/307684149856586/" target="_blank">Facebook Group: Volta Dashboard -
            Alpha Test</a></li>
    <li><a href="mailto:volta@sachatelgenhof.com" target="_blank">Email: volta@sachatelgenhof.com</a></li>
</ul>

<h2>Feature Requests</h2>
<div class="container mt-4">
    @foreach ($requests as $request)
        <div class="row pb-3 pt-3">
            <div class="mr-3 my-auto">
                @if ($request['status'] == 'completed')
                    @svg('request_status_complete', 'icon_req_status')
                @else
                    @svg('request_status_open', 'icon_req_status')
                @endif
            </div>
            <div class="col my-auto"
                 @if($request['status'] == 'completed') style="text-decoration: line-through" @endif>
                {{ $request['description'] }}
            </div>
            <div class="col-2">
                <span class="badge badge-pill badge-primary text-uppercase">{{ $request['category'] }}</span>
            </div>
        </div>
    @endforeach
</div>