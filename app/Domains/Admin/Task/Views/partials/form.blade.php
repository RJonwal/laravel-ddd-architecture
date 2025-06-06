<div class="card-body">
    <div class="form-group">
        <label for="project_id">@lang('cruds.task.fields.project_id') <span class="text-danger">*</span></label>
        <select name="project_id" id="project_id" class="form-control select2" >
            <option value="">Select @lang('cruds.task.fields.project_id')</option>
            @if(isset($projects))
                @foreach ($projects as $project)
                    <option value="{{$project->uuid}}" {{ isset($task) && $task->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                @endforeach
            @endif
        </select>        
    </div>

    <div class="form-group">
        <label for="milestone_id">@lang('cruds.task.fields.milestone_id') <span class="text-danger">*</span></label>
        <select name="milestone_id" id="milestone_id" class="form-control select2" >
            <option value="">Select @lang('cruds.task.fields.milestone_id')</option>
            <!-- milestones will show here dynamically -->
            @if(isset($milestones)) 
                @foreach($milestones as $milestone)
                    <option value="{{ $milestone->uuid }}" {{ isset($task) && $task->milestone_id == $milestone->id ? 'selected' : '' }}>
                        {{ $milestone->name }}
                    </option>
                @endforeach
            @endif    
        </select>        
    </div>

    <div class="form-group">
        <label for="sprint_id">@lang('cruds.task.fields.sprint_id') <span class="text-danger">*</span></label>
        <select name="sprint_id" id="sprint_id" class="form-control select2" >
            <option value="">Select @lang('cruds.task.fields.sprint_id')</option>
            <!-- milestones will show here dynamically -->
            @if(isset($sprints)) 
                @foreach($sprints as $sprint)
                    <option value="{{ $sprint->uuid }}" {{ isset($task) && $task->sprint_id == $sprint->id ? 'selected' : '' }}>
                        {{ $sprint->name }}
                    </option>
                @endforeach
            @endif    
        </select>        
    </div>

    @if(!isset($task) || (isset($task) && $task->parent_task_id !== null))
    <div class="form-group">
        <label for="parent_task_id">@lang('cruds.task.title')</label>
        <select name="parent_task_id" id="parent_task_id" class="form-control select2" >
            <option value="">Select @lang('cruds.task.title')</option>
            <!-- tasks will show here dynamically -->
            @if(isset($parentTasks)) 
                @foreach($parentTasks as $parentTask)
                    <option value="{{ $parentTask->uuid }}" {{ isset($task) && $task->parent_task_id == $parentTask->id ? 'selected' : '' }}>
                        {{ $parentTask->name }}
                    </option>
                @endforeach
            @endif    
        </select>        
    </div>
    @endif

    <div class="form-group">
        <label for="assigned_to">@lang('cruds.task.fields.assigned_to') <span class="text-danger">*</span></label>
        <select name="user_id" id="assigned_to" class="form-control select2" >
            <!-- users will show here dynamically -->
            @if(isset($users)) 
                @foreach($users as $user)
                    <option value="{{ $user->uuid }}" {{ isset($task) && $task->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            @endif    
        </select>        
    </div>
    
    <div class="form-group">
        <label for="name">@lang('cruds.task.fields.name') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($task) ? $task->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="description">@lang('cruds.task.fields.description')</label>
        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ isset($task) ? $task->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="estimated_time">@lang('cruds.task.fields.estimated_time') <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{{ isset($task) ? $task->estimated_time : '' }}" required>
    </div>

    <div class="form-group">
        <label for="priority">@lang('cruds.task.fields.priority') <span class="text-danger">*</span></label>
         <select name="priority" id="priority" class="form-control select2" >
            <option value="">Select @lang('cruds.task.fields.priority')</option>
            @foreach (config('constant.task_priority') as $key => $priority)
                <option value="{{$key}}" {{ isset($task) && $task->priority == $key ? 'selected' : '' }}>{{$priority}}</option>
            @endforeach
        </select> 
    </div>

    <div class="form-group">
        <label for="status">@lang('cruds.task.fields.status') <span class="text-danger">*</span></label>
         <select name="status" id="status" class="form-control select2" >
            <option value="">Select @lang('cruds.task.fields.status')</option>
            @foreach (config('constant.task_status') as $key => $status)
                <option value="{{$key}}" {{ isset($task) && $task->status == $key ? 'selected' : '' }}>{{$status}}</option>
            @endforeach
        </select> 
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">@lang('global.save')</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.close')</button>
</div>