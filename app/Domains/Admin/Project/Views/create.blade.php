@extends('Layouts::app')
@section('title', __('global.create').' '.__('cruds.project.title'))

@section('custom_css')
<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin-assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('main-content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
        {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
        </h4>
    </div>
    <div class="card-body">
        <form method="POST" id="projectForm" data-url="{{route('projects.store')}}" enctype="multipart/form-data">
            @csrf
            @include('Project::_form')     
        </form>
    </div>
</div>
@endsection

@section('custom_js')
@parent

@include('Project::partials.scripts')

<script type="text/javascript">
</script>
@endsection