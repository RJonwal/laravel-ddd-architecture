<div class="card-body">
    <div class="form-group">
        <label for="project_id">{{ trans('cruds.milestone.fields.project_id') }} <span class="text-danger">*</span></label>
        <select name="project_id" id="project_id" class="form-control select2" required>
            <option value="">Select {{ trans('cruds.milestone.fields.project_id') }}</option>
            @if(isset($projects))
                @foreach ($projects as $project)
                    <option value="{{$project->uuid}}" {{ isset($milestone) && $milestone->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                @endforeach
            @endif
        </select>        
    </div>

    <div class="form-group">
        <label for="name">{{ trans('cruds.milestone.fields.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($milestone) ? $milestone->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="start_date">{{ trans('cruds.milestone.fields.start_date') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="start_date" name="start_date" value="{{ isset($milestone) ? $milestone->start_date->format(config('constant.date_format.date')) : '' }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">{{ trans('cruds.milestone.fields.end_date') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="end_date" name="end_date" value="{{ isset($milestone) ? $milestone->end_date->format(config('constant.date_format.date')) : '' }}" required>
    </div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">{{ trans('global.save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
</div>