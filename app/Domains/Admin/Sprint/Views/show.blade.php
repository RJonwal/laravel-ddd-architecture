<div class="modal fade show" id="ViewSprint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.show') @lang('cruds.sprint.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.sprint.fields.name')</th>
                                    <td> {{ $sprint->name ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.sprint.fields.description')</th>
                                    <td> {{ $sprint->description ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.sprint.fields.project_id')  </th>
                                    <td> {{ $sprint->project_id ? $sprint->project->name : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.sprint.fields.milestone_id')  </th>
                                    <td> {{ $sprint->milestone_id ? $sprint->milestone->name : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.sprint.fields.start_date')</th>
                                    <td> {!! $sprint->start_date->format(config('constant.date_format.date')) ?? 'N/A' !!} </td>
                                </tr>
                                 <tr>
                                    <th> @lang('cruds.sprint.fields.end_date')</th>
                                    <td> {!! $sprint->end_date->format(config('constant.date_format.date')) ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.sprint.fields.status')</th>
                                    <td> {{ config('constant.sprint_status.' . $sprint->status, 'N/A') }} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.sprint.fields.created_at')</th>
                                    <td> {{ $sprint->created_at->format(config('constant.date_format.date_time')) }} </td>
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
