<div class="modal fade edit_modal" id="editTask" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.edit') @lang('cruds.task.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" data-href="{{route('tasks.update', $task->id)}}">
                    @csrf
                    @method('PUT')
                    @include('Task::partials.form')
                </form>
            </div>
        </div>
    </div>
</div>