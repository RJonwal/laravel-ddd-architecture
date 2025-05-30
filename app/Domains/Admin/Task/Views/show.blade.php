<div class="modal fade show" id="ViewTask" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.show') @lang('cruds.task.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.name') </th>
                                    <td> {{ $task->name ?? 'N/A' }} </td>
                                </tr>
                                 <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.description') </th>
                                    <td> {{ $task->description ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.project_id') </th>
                                    <td> {{ $task->project_id ? $task->project->name : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.milestone_id')  </th>
                                    <td> {{ $task->milestone_id ? $task->milestone->name : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.sprint_id')  </th>
                                    <td> {{ $task->sprint_id ? $task->sprint->name : 'N/A' }} </td>
                                </tr>
                                 <tr>
                                    <th style="width:150px;"> @lang('cruds.task.title_singular')  </th>
                                    <td> {{ $parentName ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.task.fields.assigned_to')  </th>
                                    <td> {{ $task->user_id ? $task->user->name : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.task.fields.estimated_time')  </th>
                                    <td> {!! $task->estimated_time ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.task.fields.priority')  </th>
                                    <td> {!! $task->priority ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.task.fields.status')  </th>
                                   <td>{{ config('constant.task_status.' . $task->status, 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.task.fields.created_at') </th>
                                    <td> {{ $task->created_at->format(config('constant.date_format.date_time')) }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
