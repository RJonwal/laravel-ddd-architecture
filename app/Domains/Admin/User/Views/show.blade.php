<div class="modal fade show" id="ViewUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> {{ trans('cruds.user.fields.name') }} </th>
                                    <td> {{ $user->name ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> {{ trans('cruds.user.fields.email') }} </th>
                                    <td> {{ $user->email ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> {{ trans('cruds.user.fields.phone') }} </th>
                                    <td> {{ $user->phone ?? 'N/A' }} </td>
                                </tr>
                                
                                <tr>
                                    <th> {{ trans('cruds.user.fields.status') }} </th>
                                    <td> {{ $user->status ? config('constant.user_status')[$user->status] : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> {{ trans('cruds.user.fields.created_at') }} </th>
                                    <td> {{ $user->created_at->format(config('constant.date_format.date_time')) }} </td>
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
