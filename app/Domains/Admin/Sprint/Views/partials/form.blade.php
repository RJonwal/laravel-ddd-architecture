<div class="card-body">
    <div class="form-group">
        <label for="project_id">@lang('cruds.sprint.fields.project_id') <span class="text-danger">*</span></label>
        <select name="project_id" id="project_id" class="form-control select2" required>
            <option value="">Select @lang('cruds.sprint.fields.project_id')</option>
            @if(isset($projects))
                @foreach ($projects as $project)
                    <option value="{{$project->uuid}}" {{ isset($sprint) && $sprint->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                @endforeach
            @endif
        </select>        
    </div>

    <div class="form-group">
        <label for="milestone_id">@lang('cruds.sprint.fields.milestone_id') <span class="text-danger">*</span></label>
        <select name="milestone_id" id="milestone_id" class="form-control select2" required>
            <option value="">Select @lang('cruds.sprint.fields.milestone_id')</option>
            @if(isset($projects) && $projects->count())
                @foreach ($projects as $project)
                    @if($project->milestones && $project->milestones->count())
                        @foreach ($project->milestones as $milestone)
                            <option value="{{ $milestone->uuid }}" 
                                {{ isset($sprint) && $sprint->milestone_id == $milestone->id ? 'selected' : '' }}>
                                {{ $milestone->name }}
                            </option>
                        @endforeach
                    @endif
                @endforeach
            @else
                <option disabled>No milestones available</option>
            @endif
        </select>        
    </div>

    <div class="form-group">
        <label for="name">@lang('cruds.sprint.fields.name') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($sprint) ? $sprint->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="description">@lang('cruds.sprint.fields.description') <span class="text-danger">*</span></label>
        <textarea class="form-control" id="description" name="description" required cols="30" rows="10">{{ isset($sprint) ? $sprint->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="start_date">@lang('cruds.sprint.fields.start_date') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="start_date" name="start_date" value="{{ isset($sprint) ? $sprint->start_date->format(config('constant.date_format.date')) : '' }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">@lang('cruds.sprint.fields.end_date') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="end_date" name="end_date" value="{{ isset($sprint) ? $sprint->end_date->format(config('constant.date_format.date')) : '' }}" required>
    </div>

    <div class="form-group">
        <label for="status">@lang('cruds.sprint.fields.status')  <span class="text-danger">*</span></label>
         <select name="status" id="status" class="form-control select2" >
            <option value="">Select @lang('cruds.sprint.fields.status')</option>
            @foreach (config('constant.sprint_status') as $key => $status)
                <option value="{{$key}}" {{ isset($sprint) && $sprint->status == $key ? 'selected' : '' }}>{{$status}}</option>
            @endforeach
        </select> 
    </div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">@lang('global.save')</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.close')</button>
</div>