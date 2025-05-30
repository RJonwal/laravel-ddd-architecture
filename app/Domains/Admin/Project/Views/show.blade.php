@extends('Layouts::app')
@section('title', __('global.view').' '.__('cruds.project.title'))

@section('custom_css')
@endsection

@section('main-content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ task-detail ] start -->
            <div class="col-xl-4 col-lg-12 task-detail-right">
                @if($project->start_date && $project->end_date)
                    <div class="card">
                        <div class="card-block bg-c-blue">
                            <div class="counter text-center">
                                <h4 id="timer" class="text-white m-0"></h4>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>@lang('cruds.project.project_details')</h5>
                    </div>
                    <div class="card-block task-details">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td> <p class="details-heading">@lang('cruds.project.fields.name') :</p></td>
                                    <td class="text-right"><p class="details-value">{{ $project->name ?? '' }} </p></td>
                                </tr>
                                <tr>
                                    <td><p class="details-heading">@lang('cruds.project.fields.start_date') :</p></td>
                                    <td class="text-right"><p class="details-value">{{ (isset($project) && isset($project->start_date)) ? $project->start_date->format('d-M-Y') : '' }}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="details-heading">@lang('cruds.project.fields.end_date') :</p></td>
                                    <td class="text-right"><p class="details-value">{{ (isset($project) && isset($project->end_date)) ? $project->end_date->format('d-M-Y') : '' }}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="details-heading">@lang('cruds.project.fields.project_lead') :</p></td>
                                    <td class="text-right"><p class="details-value">{{(($project->projectLead != NULL) ? $project->projectLead->name : '')}}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="details-heading">@lang('cruds.project.fields.created_at') :</p></td>
                                    <td class="text-right"><p class="details-value">{{ $project->created_at->format(config('constant.date_format.date_time')) ?? '' }}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="details-heading">@lang('cruds.project.fields.created_by') :</p></td>
                                    <td class="text-right"><p class="details-value">{{(($project->createdBy != NULL) ? $project->createdBy->name : '')}}</p></td>
                                </tr>
                                <tr>
                                    <td> <p class="details-heading">@lang('cruds.project.fields.project_status') :</p></td>
                                    <td class="text-right"><p class="details-value">{{ config('constant.project_status')[$project->project_status] ?? '' }}</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-12 task-detail-right">
                <div class="row">
                    <div class="col-xl-6 col-lg-12 task-detail-right">
                        <div class="card">
                            <div class="card-header">
                                <h5>@lang('cruds.project.fields.assign_developers')</h5>
                            </div>
                            <div class="card-block">
                                <div class="taskboard-right-revision user-box mt-3 ms-3 assign-user">
                                    @if($project && $project->assignDevelopers->count() > 0)
                                        @foreach($project->assignDevelopers as $assignDeveloper)
                                            <div class="media mb-2">
                                                <div class="media-left media-middle mr-3">
                                                    @if($assignDeveloper->profile_image_url)
                                                    <img src="{{ $assignDeveloper->profile_image_url }}" alt="user-image" width="32" class="rounded-circle user-profile-img">
                                                    @else
                                                    <img src="{{ asset(config('constant.default.user_icon')) }}" alt="user-image" width="32" class="rounded-circle user-profile-img">
                                                    @endif
                                                </div>
                                                <div class="media-body ms-2">
                                                    <h6 class="m-0 h6">{{ ucfirst($assignDeveloper->name ?? '') }}</h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12 task-detail-right">
                        <div class="card">
                            <div class="card-header">
                                <h5>@lang('cruds.project.fields.technology') </h5>
                            </div>
                            <div class="card-block">
                                <div class="taskboard-right-revision user-box mt-3 ms-3">
                                    @if($project && $project->technologies->count() > 0)
                                        @foreach($project->technologies as $technology)
                                            <div class="media align-items-center mb-3 ">
                                                <div class="media-left">
                                                    <a class="btn btn-outline-primary btn-icon me-2" role="button">
                                                        <i class="fas fa-keyboard"></i></i>
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="h6">{{ ucfirst($technology->name) ?? '' }}</h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 task-detail-right">
                        <div class="card">
                            <div class="card-header d-flex">
                                <div class="col-md-6">
                                    <h5>@lang('cruds.project.fields.attachment')</h5>
                                </div>
                                @if(isset($project->project_document_url) && !empty($project->project_document_url))
                                    <div class="col-md-6 text-end">
                                        <a title="@lang('cruds.project.download_all_attachment') }}" class="btn btn-info btn-sm createZipDownload" href="javascript:void(0)" data-href="{{ route('projects.projectAttachmentZip', $project->uuid) }}">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            @php  
                                $imageFileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                                $excelFileExtensions = ['xls','xlsx', 'xml', 'csv', 'xlsm', 'xlw', 'xlr'];
                                $wordFileExtensions = ['doc', 'docm', 'docx', 'dot'];
                                $pdfFileExtensions = ['pdf'];
                                $zipFileExtensions = ['zip','rar'];
                            @endphp

                            <div class="card-block task-attachment">
                                <ul class="media-list p-0">
                                    @if(isset($project->project_document_url) && !empty($project->project_document_url))
                                        @foreach($project->uploads as $key => $projectDocument)
                                            <li class="media d-flex m-b-15 align-items-center">
                                                <div class="file-attach col-md-2 text-center">
                                                    @if(in_array($projectDocument->extension, $imageFileExtensions))
                                                        <i class="far fa-file-alt f-28" aria-hidden="true"></i>
                                                    @elseif(in_array($projectDocument->extension, $excelFileExtensions))
                                                        <i class="far fa-file-excel f-28"></i>
                                                    @elseif(in_array($projectDocument->extension, $wordFileExtensions))
                                                        <i class="far fa-file-word f-28"></i>
                                                    @elseif(in_array($projectDocument->extension, $pdfFileExtensions))
                                                        <i class="far fa-file-pdf f-28"></i>
                                                    @elseif(in_array($projectDocument->extension, $zipFileExtensions))
                                                        <i class="fa fa-file-zip-o fa-2x" aria-hidden="true"></i>
                                                    @else
                                                        <i class="far fa-file-alt f-28" aria-hidden="true"></i>
                                                    @endif
                                                </div>
                                                <div class="media-body col-md-8">
                                                    @php 
                                                        $fileNameArray = explode('/', $projectDocument->file_path);
                                                        $fileName = end($fileNameArray);
                                                    @endphp
                                                    <a target="_blank" href="{{ asset('storage/'.$projectDocument->file_path) ?? '' }}" class="m-b-5 d-block text-secondary">{{ $fileName ?? '' }}</a>
                                                </div>
                                                <div class="float-right text-muted col-md-2 text-center">
                                                    <a class="" download="{{ $fileName ?? '' }}" href="{{ asset('storage/'.$projectDocument->file_path) ?? '' }}"><i class="fas fa-download f-18"></i></a>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <span>@lang('cruds.project.no_attachment') </span>
                                    @endif
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-3"> @lang('cruds.project.project_overview')  </h5>
                    </div>
                    <div class="card-block ps-2 pt-3">
                        <div class="m-b-30">
                            <h5 class="h5">@lang('cruds.project.fields.description')</h5>
                            <hr>
                            {!! $project->description ?? '' !!}
                            <hr>
                        </div>
                        <div class="m-b-30">
                            <h5 class="h5">@lang('cruds.project.fields.refrence_details')</h5>
                            <hr>
                            {!! $project->refrence_details ?? '' !!}
                            <hr>
                        </div>
                        <div class="m-b-30">
                            <h5 class="h5">@lang('cruds.project.fields.credentials') </h5>
                            <hr>
                            {!! $project->credentials ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    @if($project && $project->milestones->count() > 0)
                        <div class="card-block bg-c-blue">
                            <div class="counter text-center">
                                <h3 class="text-white m-0">@lang('cruds.milestone.title') </h3>
                            </div>
                        </div>
                        @foreach($project->milestones as $milestone)
                            <div class="card-header">
                                <h4>{{$milestone->name}} 
                                    @php 
                                    $milestoneStatusKey = $milestone->status;
                                    $milestoneStatusLabel = config('constant.milestone_status')[$milestoneStatusKey] ?? 'Unknown';
                                    if($milestoneStatusKey){
                                        $milestoneBadgeClass = match($milestoneStatusKey) {
                                            'initial' => 'badge bg-danger',
                                            'in_progress' => 'badge bg-warning text-dark',
                                            'completed' => 'badge bg-success',
                                            'not_started' => 'badge bg-secondary',
                                            'hold'        => 'badge bg-primary',
                                        };
                                    }
                                    @endphp
                                    
                                    @if(isset($milestoneBadgeClass))
                                        <span class="ms-2 badge {{ $milestoneBadgeClass }}">{{ $milestoneStatusLabel }}</span>
                                    @endif
                                </h4>
                                <p class="mb-0"><small>
                                   Start Date: {{$milestone->start_date->format(config('constant.date_format.date'))}} <br />
                                   End Date: {{$milestone->end_date->format(config('constant.date_format.date'))}}
                                </small></p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('cruds.task.fields.name') </th>
                                            <th>@lang('cruds.task.fields.assigned_to')</th>
                                            <th>@lang('cruds.task.fields.estimated_time') </th>
                                            <th>@lang('cruds.task.fields.priority') </th>
                                            <th>@lang('cruds.task.fields.status') </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($milestone->tasks->count() > 0)
                                        @foreach($milestone->tasks as $task)
                                            <tr>
                                                <td>{!! $task->name ?? '' !!}</td>
                                                <td>{!! $task->user->name ?? '' !!}</td>
                                                <td>{!! $task->estimated_time ?? '' !!}</td>
                                                <td>{!! config('constant.task_priority')[$task->priority] ?? '' !!}</td>
                                                @php 
                                                    $taskStatusKey = $task->status;
                                                    $taskStatusLabel = config('constant.task_status')[$taskStatusKey] ?? 'Unknown';
                                                    if($milestoneStatusLabel){
                                                        $taskBadgeClass = match($taskStatusKey) {
                                                            'initial' => 'badge bg-danger',
                                                            'in_progress' => 'badge bg-warning text-dark',
                                                            'completed' => 'badge bg-success',
                                                            default => 'badge bg-secondary',
                                                        };
                                                    }
                                                @endphp
                                                
                                                <td>
                                                    @if(isset($taskBadgeClass))
                                                    <span class="badge {{ $taskBadgeClass }}">{{ $taskStatusLabel }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr><td colspan="5">No tasks under this milestone.</td></tr>
                                        @endif    
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- [ task-detail ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

@section('custom_js')
@parent
<script>
    // donload all attachment
    $(document).on("click",".createZipDownload", function() {
        pageLoader('show');
        var url = $(this).data('href');
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                $('#pageloader').css('display', 'none');
                if(response.success) {
                    window.open(response.zipPath);
                }else{
                    toasterAlert('Error',response.message);
                }
            },
            error: function (response) {
                toasterAlert('Error',response.responseJSON.error);
            },
            complete: function(xhr){
                pageLoader('hide');
            }
        });
    });


    // Set the date we're counting down to
    var d = new Date();
    var endDate = "{{ (isset($project) && isset($project->end_date)) ? date('d-M-Y', strtotime($project->end_date)) : ''}}";
    var countDownDate = new Date(endDate).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("timer").innerHTML = "<b>"+days + "</b>days : <b>" +  hours + "</b>h : <b>" +
            minutes + "</b>m : <b>" + seconds + "</b>s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "Project Delivered";
        }
    }, 1000);
</script>
@endsection