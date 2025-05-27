<div class="task_activity_inner task_activity_inner_{{$taskCount}}">
    <div class="col-md-12 text-end p-2">
        @if($taskCount == 0)
            <button type="button" class="btn btn-sm btn-success addTaskBtn" data-task_count="{{$taskCount}}"><i class="fa fa-plus"></i></button>
        @else 
            <button type="button" class="btn btn-sm btn-danger removeTaskBtn"><i class="fa fa-minus"></i></button>
        @endif
    </div>
    <div class="row">
        @if(!empty($tasks))
            <div class="form-group col-md-6">
                <label for="task_id">@lang('cruds.daily_activity_log.fields.task_id') <span class="text-danger">*</span></label>
                <select name="daily_activity[{{$taskCount}}][task_id]" class="form-control select2 task_id" >
                    <option value="">Select @lang('cruds.daily_activity_log.fields.task_id')</option>
                    @if(isset($tasks)) 
                        @foreach($tasks as $task)
                            <option value="{{ $task->uuid }}">{{ $task->name }}</option>
                        @endforeach
                    @endif    
                </select>        
            </div>

            <div class="form-group col-md-6">
                <label for="sub_task_id">@lang('cruds.daily_activity_log.fields.sub_task_id')</label>
                <select name="daily_activity[{{$taskCount}}][sub_task_id]" class="form-control select2 sub_task_id" >
                    <option value="">Select @lang('cruds.daily_activity_log.fields.sub_task_id')</option>
                </select> 
            </div>
        @endif

        <div class="form-group col-md-12">
            <label for="description">@lang('cruds.daily_activity_log.fields.description') <span class="text-danger">*</span></label>
            <textarea name="daily_activity[{{$taskCount}}][description]" class="form-control" cols="30" rows="5" ></textarea>
        </div>

        <div class="form-group col-md-4">
            <label for="work_time">@lang('cruds.daily_activity_log.fields.work_time') <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="daily_activity[{{$taskCount}}][work_time]" >
        </div>

        <div class="form-group col-md-4">
            <label for="task_type">@lang('cruds.daily_activity_log.fields.task_type') <span class="text-danger">*</span></label>
                <select name="daily_activity[{{$taskCount}}][task_type]" class="form-control select2" >
                <option value="">Select @lang('cruds.daily_activity_log.fields.task_type')</option>
                @foreach (config('constant.task_types') as $taskTypeKey => $taskType)
                    <option value="{{$taskTypeKey}}" >{{$taskType}}</option>
                @endforeach
            </select> 
        </div>

        <div class="form-group col-md-4">
            <label for="status">@lang('cruds.daily_activity_log.fields.status') <span class="text-danger">*</span></label>
                <select name="daily_activity[{{$taskCount}}][status]" class="form-control select2" >
                <option value="">Select @lang('cruds.daily_activity_log.fields.status')</option>
                @foreach (config('constant.activity_status') as $statuskey => $status)
                    <option value="{{$statuskey}}">{{$status}}</option>
                @endforeach
            </select> 
        </div>
    </div>
</div>