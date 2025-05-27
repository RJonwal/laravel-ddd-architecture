<div class="modal fade show" id="ViewDailyActivityLog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.show') @lang('cruds.daily_activity_log.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.daily_activity_log.fields.name')</th>
                                    <td> {{ $dailyActivityLog->name ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.daily_activity_log.fields.technology_type')</th>
                                    <td> {{ $dailyActivityLog->dailyActivityLog ? config('constant.technology_types')[$dailyActivityLog->technology_type] : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.daily_activity_log.fields.description')</th>
                                    <td> {!! $dailyActivityLog->description ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.daily_activity_log.fields.created_at')</th>
                                    <td> {{ $dailyActivityLog->created_at->format(config('constant.date_format.date_time')) }} </td>
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
