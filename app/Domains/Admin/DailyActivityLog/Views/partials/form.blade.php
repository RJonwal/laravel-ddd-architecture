<div class="card-body">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="report_date">@lang('cruds.daily_activity_log.fields.report_date') <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="report_date" name="report_date" value="{{ isset($dailyActivityLog) ? $dailyActivityLog->report_date->format(config('constant.date_format.date')) : '' }}"  readonly>
        </div>

        <div class="form-group col-md-4">
            <label for="project_id">@lang('cruds.daily_activity_log.fields.project_id') <span class="text-danger">*</span></label>
            <select name="project_id" id="project_id" class="form-control select2" >
                <option value="">Select @lang('cruds.daily_activity_log.fields.project_id')</option>
                @if(isset($projects))
                    @foreach ($projects as $project)
                        <option value="{{$project->uuid}}" {{ isset($dailyActivityLog) && $dailyActivityLog->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                    @endforeach
                @endif
            </select>        
        </div>

        <div class="form-group col-md-4">
            <label for="milestone_id">@lang('cruds.task.fields.milestone_id') <span class="text-danger">*</span></label>
            <select name="milestone_id" id="milestone_id" class="form-control select2" >
                <option value="">Select @lang('cruds.task.fields.milestone_id')</option>
                @if(isset($milestones)) 
                    @foreach($milestones as $milestone)
                        <option value="{{ $milestone->uuid }}" {{ isset($dailyActivityLog) && $dailyActivityLog->milestone_id == $milestone->id ? 'selected' : '' }}>
                            {{ $milestone->name }}
                        </option>
                    @endforeach
                @endif
            </select>        
        </div>
    </div>
    
    <div class="task_activity_main d-none"></div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">@lang('global.save')</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.close')</button>
</div>