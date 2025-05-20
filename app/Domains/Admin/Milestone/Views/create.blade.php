<div class="modal fade edit_modal" id="AddMilestone" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.create') @lang('cruds.milestone.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddMilestoneForm">
                    @csrf
                    @include('Milestone::partials.form')
                </form>
            </div>
        </div>
    </div>
</div>