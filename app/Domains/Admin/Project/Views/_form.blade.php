<div class="row">
    <input type="hidden" name="projectDocIds" id="projectDocIds">
    <div class="form-group col-md-12">
        <label for="name">{{ trans('cruds.project.fields.name') }}<span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ isset($project) ? $project->name : null }}" required>
    </div>    
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="">{{ trans('cruds.project.fields.project_lead') }}<span class="text-danger">*</span></label>
        <select name="project_lead" id="project_lead" class="form-control select2" required>
            <option value="">Select {{ trans('cruds.project.fields.project_lead') }}</option>
            @foreach ($users as $user)
                <option value="{{$user->uuid}}" {{ isset($project) && $project->project_lead == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
            @endforeach
        </select>        
    </div>
    <div class="form-group col-md-4">
        <label for="">{{ trans('cruds.project.fields.assign_developers') }}<span class="text-danger">*</span></label>
        <select name="assign_developers[]" id="assign_developers" class="form-control select2" multiple required>
            @foreach ($users as $user)
                <option value="{{$user->uuid}}" {{ isset($project) && $project->assignDevelopers->contains($user->id) ? 'selected' : '' }}>{{$user->name}}</option>
            @endforeach
        </select>        
    </div>
    <div class="form-group col-md-4">
        <label for="technology">{{ trans('cruds.project.fields.technology') }}</label>
        <select name="technology[]" id="technology" class="form-control select2" multiple>
            @foreach ($technolgies as $technologyKey => $technology)
                <option value="{{$technologyKey}}" {{ isset($project) && $project->technologies->contains($technologyKey) ? 'selected' : '' }}>{{$technology}}</option>
            @endforeach
        </select>   
    </div>
</div>

<div class="form-row"> 
    <div class="form-group col-md-12">
        <label for="live_url">{{ trans('cruds.project.fields.live_url') }}</label>
        <input type="url" class="form-control" name="live_url" id="live_url" placeholder="Live URL" value="{{ isset($project->live_url) ? $project->live_url : '' }}" >
    </div>
</div>
<div class="row">  
    @php
        if(isset($project) && isset($project->start_date)){
            $projectStartDate = date('d-m-Y', strtotime($project->start_date));
        }
    @endphp  
    <div class="form-group col-md-4">
        <label for="start_date">{{ trans('cruds.project.fields.start_date') }}</label>
        <input type="text" class="form-control datepicker readonly" name="start_date" id="start_date" value="{{ isset($project->start_date) ? $projectStartDate: '' }}" placeholder="dd-mm-yyyy" readonly >
    </div>     
    @php
        if(isset($project) && isset($project->end_date)){
            $projectDeliveryate = date('d-m-Y', strtotime($project->end_date));
        }
    @endphp                  
    <div class="form-group col-md-4">
        <label for="end_date">{{ trans('cruds.project.fields.end_date') }}</label>
        <input type="text" class="form-control datepicker readonly" name="end_date" id="end_date" value="{{ isset($project->end_date) ? $projectDeliveryate: '' }}" placeholder="dd-mm-yyyy" readonly >
    </div>
    <div class="form-group col-md-4">
        <label for="">{{ trans('cruds.project.fields.project_status') }}</label>
        <select name="project_status" id="project_status" class="form-control select2">
            <option value="">Select {{ trans('cruds.project.fields.project_status') }}</option>
            @foreach (config('constant.project_status') as $projectStatuskey => $projectStatus)
                <option value="{{$projectStatuskey}}" {{ isset($project) && $project->project_status == $projectStatuskey ? 'selected' : '' }}>{{$projectStatus}}</option>
            @endforeach
        </select>    
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="attachment">{{ trans('cruds.project.fields.attachment') }}</label>
        <div id="attachments" class="dropzone">
            <div class="dz-default dz-message">Drag & Drop files</div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="description">{{ trans('cruds.project.fields.description') }}</label>
        <textarea class="form-control ckeditor" name="description" id="description" placeholder="Description" >{{ isset($project->description) ? $project->description : '' }}</textarea>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="refrence_details">{{ trans('cruds.project.fields.refrence_details') }}</label>
        <textarea class="form-control ckeditor" name="refrence_details" id="refrence_details" placeholder="Refrence Details" >{{ isset($project->refrence_details) ? $project->refrence_details : '' }}</textarea>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="credentials">{{ trans('cruds.project.fields.credentials') }}</label>
        <textarea class="form-control ckeditor" name="credentials" id="credentials" placeholder="Credentials" >{{ isset($project->credentials) ? $project->credentials : '' }}</textarea>
    </div>
</div>



<div class="text-right">
    <button type="submit" id="sendBtn" class="btn btn-primary">Save</button>
</div>