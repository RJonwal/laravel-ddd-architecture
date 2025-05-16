<div class="modal fade show" id="ViewMilestone" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{ trans('global.show') }} {{ trans('cruds.milestone.title_singular') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> {{ trans('cruds.milestone.fields.name') }} </th>
                                    <td> {{ $milestone->name ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> {{ trans('cruds.milestone.fields.project_id') }} </th>
                                    <td> {{ $milestone->project_id ? $milestone->project->name : 'N/A' }} </td>
                                     
                                </tr>
                                <tr>
                                    <th> {{ trans('cruds.milestone.fields.start_date') }} </th>
                                    <td> {!! $milestone->start_date->format(config('constant.date_format.date')) ?? 'N/A' !!} </td>
                                </tr>
                                 <tr>
                                    <th> {{ trans('cruds.milestone.fields.end_date') }} </th>
                                    <td> {!! $milestone->end_date->format(config('constant.date_format.date')) ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> {{ trans('cruds.milestone.fields.created_at') }} </th>
                                    <td> {{ $milestone->created_at->format(config('constant.date_format.date_time')) }} </td>
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
