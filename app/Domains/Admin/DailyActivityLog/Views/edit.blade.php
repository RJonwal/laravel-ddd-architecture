<div class="modal fade edit_modal" id="editDailyActivityLog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.edit') @lang('cruds.daily_activity_log.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDailyActivityLogForm" data-href="{{route('technologies.update', $dailyActivityLog->uuid)}}">
                    @csrf
                    @method('PUT')
                    @include('DailyActivityLog::partials.form')
                </form>
            </div>
        </div>
    </div>
</div>