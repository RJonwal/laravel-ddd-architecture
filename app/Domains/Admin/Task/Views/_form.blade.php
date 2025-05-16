<div class="card-body">
    <div class="form-group">
        <label for="project_id">{{ trans('cruds.task.fields.project_id') }} <span class="text-danger">*</span></label>
        <select name="project_id" id="project_id" class="form-control select2" >
            <option value="">Select {{ trans('cruds.task.fields.project_id') }}</option>
            @if(isset($projects))
                @foreach ($projects as $project)
                    <option value="{{$project->uuid}}" {{ isset($task) && $task->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                @endforeach
            @endif
        </select>        
    </div>

    <div class="form-group">
        <label for="milestone_id">{{ trans('cruds.task.fields.milestone_id') }} <span class="text-danger">*</span></label>
        <select name="milestone_id" id="milestone_id" class="form-control select2" >
            <option value="">Select {{ trans('cruds.task.fields.milestone_id') }}</option>
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

    @if(!isset($task) || (isset($task) && $task->parent_task_id !== null))
    <div class="form-group">
        <label for="parent_task_id">{{ trans('cruds.task.title') }} <span class="text-danger">*</span></label>
        <select name="parent_task_id" id="parent_task_id" class="form-control select2" >
            <option value="">Select {{ trans('cruds.task.title') }}</option>
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
        <label for="assigned_to">{{ trans('cruds.task.fields.assigned_to') }} <span class="text-danger">*</span></label>
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
        <label for="name">{{ trans('cruds.task.fields.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($task) ? $task->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="description">{{ trans('cruds.task.fields.description') }} <span class="text-danger">*</span></label>
        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ isset($task) ? $task->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="estimated_time">{{ trans('cruds.task.fields.estimated_time') }} <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{{ isset($task) ? $task->estimated_time : '' }}" required>
    </div>

    <div class="form-group">
        <label for="priority">{{ trans('cruds.task.fields.priority') }} <span class="text-danger">*</span></label>
         <select name="priority" id="priority" class="form-control select2" >
            <option value="">Select {{ trans('cruds.task.fields.priority') }}</option>
            @foreach (config('constant.task_priority') as $key => $priority)
                <option value="{{$key}}" {{ isset($task) && $task->priority == $key ? 'selected' : '' }}>{{$priority}}</option>
            @endforeach
        </select> 
    </div>

    <div class="form-group">
        <label for="status">{{ trans('cruds.task.fields.status') }} <span class="text-danger">*</span></label>
         <select name="status" id="status" class="form-control select2" >
            <option value="">Select {{ trans('cruds.task.fields.status') }}</option>
            @foreach (config('constant.task_status') as $key => $status)
                <option value="{{$key}}" {{ isset($task) && $task->status == $key ? 'selected' : '' }}>{{$status}}</option>
            @endforeach
        </select> 
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">{{ trans('global.save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
</div>