@extends('Layouts::app')
@section('title', __('global.edit').' '.__('cruds.project.title'))

@section('custom_css')
<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('admin-assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">@lang('global.edit') @lang('cruds.project.title_singular')</h4>
    </div>
    <div class="card-body">
        <form method="POST" id="projectEditForm" data-url="{{ route('projects.update', [$project->uuid]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf           
            @include('Project::partials.form')
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