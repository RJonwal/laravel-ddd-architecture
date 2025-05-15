@extends('Layouts::app')
@section('title', __('cruds.project.title'))

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">
@endsection

@section('main-content')

<div class="row">
    <div class="col-12 d-flex justify-content-between">
        <div class="page-title-box">
            <h4 class="page-title">@lang('cruds.project.title')</h4>
        </div>
        <div class="my-3">
            <a href="{{ route('projects.create') }}"  class="btn btn-primary">@lang('global.create')</a>
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
@parent
{!! $dataTable->scripts() !!}

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>


<script type="text/javascript">
$(document).ready( function(){    
    $(document).on("click",".createZipDownload", function() {
        $('#pageloader').css('display', 'flex');
        var url = $(this).data('href');
        $('.loader-div').show();
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                $('.loader-div').hide();
                if(response.success) {
                    window.open(response.zipPath);
                }else{
                    toasterAlert('Error',response.message);
                }
            },
            error: function(response){
                $('.loader-div').hide();
                toasterAlert('Error', response.responseJSON.error);
            },
            complete: function(response){
                $('.loader-div').hide();
            }
        });
    });
    
    // delete project
    $(document).on("click",".deleteProjectBtn", function() {
        
        var url = $(this).data('href');
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: "{{ trans('global.areYouSure') }}",
            text: "{{ trans('global.onceClickedRecordDeleted') }}",
            icon: "warning",
            // showDenyButton: true,  
            showCancelButton: true,  
            confirmButtonText: `Yes, I am sure`,  
            denyButtonText: `'No, cancel it!`,
        })
        .then(function(result) {
            if (result.isConfirmed) {  
                $('.loader-div').show();
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data: { _token: csrf_token },
                    success: function (response) {
                        $('.loader-div').hide();
                        if(response.success) {
                            toasterAlert('Success',response.message);

                            $('#project-table').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function(response){
                        $('.loader-div').hide();
                        toasterAlert('Error',response.responseJSON.error);
                    }
                });
            }
        });
    });
});
</script>
@endsection