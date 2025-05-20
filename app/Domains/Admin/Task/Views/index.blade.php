@extends('Layouts::app')
@section('title', __('cruds.task.title'))

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@lang('cruds.task.title')</h4>
            </div>
            <div class="my-3">
                <a href="javascript:void(0);"  class="btn btn-primary btnAddTask">Create</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                       
                        {{$dataTable->table(['class' => 'table mb-0', 'style' => 'width:100%;'])}}
                           
                    </div> 
                </div>
            </div> 
        </div> 
    </div>
   


@endsection

@section('custom_js')

@include('Task::partials.script')

@endsection