@extends('Layouts::app')
@section('title', __('global.dashboard'))

@section('custom_css')
@endsection

@section('main-content')

 
<div class="row mt-3">
    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-primary">
            <div class="card-body">
                <a class="dashboard-card" href="{{route('admin.dashboard')}}">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">@lang('cruds.user.title')</h6>
                    <h2 class="my-2">20</h2>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat text-bg-purple">
            <div class="card-body">
                <a class="dashboard-card" href="{{route('admin.dashboard')}}">
                    <div class="float-end">
                        <i class="ri-wallet-2-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Revenue</h6>
                    <h2 class="my-2">{{ config('constant.curreny.symbol') }}2</h2>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_js')

@endsection