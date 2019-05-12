@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container">
        <div class="row" id="docs">
            <div class="col-3">
                <nav id="docs-navigation">
                    {!! $index !!}
                </nav>
            </div>
            <div class="col">
                <article id="docs-body">
                    {!! $content !!}
                </article>
            </div>
        </div>
    </div>
@endsection
