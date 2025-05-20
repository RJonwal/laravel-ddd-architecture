<div class="modal fade edit_modal" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.edit') @lang('cruds.user.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" data-href="{{route('users.update', $user->uuid)}}">
                    @csrf
                    @method('PUT')
                    @include('User::partials.form')
                </form>
            </div>
        </div>
    </div>
</div>