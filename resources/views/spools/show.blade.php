@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-1">
                <svg height="50" width="50">
                    <circle cx="25" cy="25" r="25" fill="{{ $spool->color_value }}"></circle>
                </svg>
            </div>
            <div class="col-7"><h1 class="display-5">{{ $spool->name }}</h1>
                <p class="text-muted">by {{ $spool->manufacturer->name }}
                    @if (!empty($spool->manufacturer->country))
                        ({{ Punic\Territory::getName($spool->manufacturer->country, Auth::_user()->profile->language) }})
                    @endif
                </p>
            </div>

            <div class="col-4" style="text-align: right">

                <a href="{{ url('/spools/' . $spool->{$spool->getRouteKeyName()} . '/edit') }}"
                   title="@lang('main.edit_model', ['model' => (new \ReflectionClass($spool))->getShortName()])">
                    <button class="btn btn-outline-primary btn-mini text-uppercase">
                        @svg('pencil-alt') @lang('main.update')
                    </button>
                </a>

                <form method="POST" action="{{ url('/spools/' . $spool->{$spool->getRouteKeyName()}) }}"
                      accept-charset="UTF-8"
                      style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-danger btn-mini text-uppercase"
                            title="@lang('main.delete_model', ['model' => (new \ReflectionClass($spool))->getShortName()])"
                            onclick="return confirm(&quot;Confirm delete?&quot;)">@svg('trash')
                        @lang('main.delete')
                    </button>
                </form>


                <div class="btn-group" role="group">
                    <button id="btnGroupDownload" type="button"
                            class="btn btn-outline-secondary btn-mini dropdown-toggle text-uppercase"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        @svg('download') @lang('main.export')
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDownload">
                        <a class="dropdown-item"
                           href="{{ url('/spools/' . $spool->{$spool->getRouteKeyName()} . '/export') }}">JSON</a>
                        <a class="dropdown-item" href="#">Slic3r PE</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-deck mt-4">
            <div class="card-volta card">
                <div class="card-header">
                    General
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>@lang('spools.material')</th>
                                <td>
                                    <a href="{{ route('spools.index', ['search' => $spool->material]) }}">{{ $spool->material }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('spools.color')</th>
                                <td>{{ $spool->color }} ({{ $spool->color_value }})</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-volta card">
                <div class="card-header-custom card-header">
                    Specifications
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>@lang('spools.diameter')</th>
                                <td>{{ $spool->diameter }} mm</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.density')</th>
                                <td>{{ $spool->density }} g/cm<sup>3</sup></td>
                            </tr>
                            <tr>
                                <th>@lang('spools.weight')</th>
                                <td>{{ $spool->weight }} g</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.length')</th>
                                <td>{{ number_format($spool->length, 2) }} m</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-volta card">
                <div class="card-header">
                    Price
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>@lang('spools.purchase_price')</th>
                                <td style="text-align:right">
                                    @moneyFormat($spool->purchase_price)
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('spools.priceperweight')</th>
                                <td style="text-align: right">@moneyFormat($spool->priceperweight->getAmount())</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.priceperlength')</th>
                                <td style="text-align: right">@moneyFormat($spool->priceperlength->getAmount())</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.pricepervolume')</th>
                                <td style="text-align: right">@moneyFormat($spool->pricepervolume->getAmount())</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.priceperkilogram')</th>
                                <td style="text-align: right">@moneyFormat($spool->priceperkilogram->getAmount())</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-deck mt-4">
            <div class="card-volta card">
                <div class="card-header-custom card-header">
                    Specifications
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>@lang('spools.diameter')</th>
                                <td>{{ $spool->diameter }} mm</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.density')</th>
                                <td>{{ $spool->density }} g/cm<sup>3</sup></td>
                            </tr>
                            <tr>
                                <th>@lang('spools.weight')</th>
                                <td>{{ $spool->weight }} g</td>
                            </tr>
                            <tr>
                                <th>@lang('spools.length')</th>
                                <td>{{ number_format($spool->length, 2) }} m</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-volta card">
                <div class="card-header">
                    Calibrations
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    <div class="icon-inline">@svg('image')</div>
                                    Linear Advance
                                </th>
                                <td style="text-align:right"> 33 @svg('plus-circle')</td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="icon-inline">@svg('resize_6')</div>
                                    Diameter
                                </th>
                                <td style="text-align:right"><abbr
                                            title="This {{ $spool->name }} filament has a variance of {{ 1.76 - $spool->diameter }} mm ({{ round(((1.76 / $spool->diameter) - 1) * 100, 2) }}%)">1.76
                                        mm</abbr>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="icon-inline">@svg('square_down')</div>
                                    Extrusion
                                </th>
                                <td style="text-align:right"><abbr v-b-tooltip title="Your filament ">0.49 mm</abbr>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
