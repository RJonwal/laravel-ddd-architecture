@extends('Layouts::app')
@section('title', __('global.create').' '.__('cruds.daily_activity_log.title'))

@section('custom_css')
<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin-assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    .task_activity_main {
        /* border: 1px solid #6e6e6e; */
        padding: 20px;
        background: #f3f3f3;
    }
    .task_activity_inner:not(:last-child) {
        border-bottom: 1px solid darkgray;
        margin-bottom: 10px;
        padding-bottom: 20px;
    }
</style>

@endsection

@section('main-content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">@lang('global.add')  @lang('cruds.daily_activity_log.title_singular')</h4>
    </div>
    <div class="card-body">
        <form method="POST" id="AddDailyActivityLogForm" >
            @csrf
            @include('DailyActivityLog::partials.form')     
        </form>
    </div>
</div>
@endsection

@section('custom_js')
@parent

@include('DailyActivityLog::partials.script')

@endsection