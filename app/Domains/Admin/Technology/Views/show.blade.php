<div class="modal fade show" id="ViewTechnology" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('global.show') @lang('cruds.technology.title_singular')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="mb-2 normal_width_table">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.technology.fields.name')</th>
                                    <td> {{ $technology->name ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th style="width:150px;"> @lang('cruds.technology.fields.technology_type')</th>
                                    <td> {{ $technology->technology_type ? config('constant.technology_types')[$technology->technology_type] : 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.technology.fields.description')</th>
                                    <td> {!! $technology->description ?? 'N/A' !!} </td>
                                </tr>
                                <tr>
                                    <th> @lang('cruds.technology.fields.created_at')</th>
                                    <td> {{ $technology->created_at->format(config('constant.date_format.date_time')) }} </td>
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
