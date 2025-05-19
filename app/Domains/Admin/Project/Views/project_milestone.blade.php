@extends('Layouts::app')
@section('title', __('global.view').' '.__('cruds.project.title').' '.__('cruds.milestone.title'))

@section('custom_css')
@endsection

@section('main-content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    @if($project && $project->milestones->count() > 0)
                        <div class="card-block bg-c-blue">
                            <div class="counter text-center">
                                <h3 class="text-white m-0">{{ $project->name ?? '' }}'s {{ trans('cruds.milestone.title') }}</h3>
                            </div>
                        </div>
                        @foreach($project->milestones as $milestone)
                            <div class="card-header">
                                <h4>{{$milestone->name}} 
                                    @php 
                                    $milestoneStatusKey = $milestone->status;
                                    $milestoneStatusLabel = config('constant.milestone_status')[$milestoneStatusKey] ?? 'Unknown';
                                    $milestoneBadgeClass = match($milestoneStatusKey) {
                                        'initial' => 'badge bg-danger',
                                        'in_progress' => 'badge bg-warning text-dark',
                                        'completed' => 'badge bg-success',
                                        'not_started' => 'badge bg-secondary',
                                    }; @endphp
                                    <span class="ms-2 badge {{ $milestoneBadgeClass }}">{{ $milestoneStatusLabel }}</span>
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
                                            <th>{{ trans('cruds.task.fields.name') }}</th>
                                            <th>{{ trans('cruds.task.fields.assigned_to') }}</th>
                                            <th>{{ trans('cruds.task.fields.estimated_time') }}</th>
                                            <th>{{ trans('cruds.task.fields.priority') }}</th>
                                            <th>{{ trans('cruds.task.fields.status') }}</th>
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
                                                    $taskBadgeClass = match($taskStatusKey) {
                                                        'initial' => 'badge bg-danger',
                                                        'in_progress' => 'badge bg-warning text-dark',
                                                        'completed' => 'badge bg-success',
                                                    }; 
                                                @endphp
                                                <td><span class="badge {{ $taskBadgeClass }}">{{ $taskStatusLabel }}</span></td>
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
        </div>
    </div>
</div>

@endsection

@section('custom_js')
@parent

@endsection