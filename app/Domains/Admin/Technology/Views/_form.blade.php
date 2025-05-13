<div class="card-body">
    <div class="form-group">
        <label for="technology_type">{{ trans('cruds.technology.fields.technology_type') }} <span class="text-danger">*</span></label>
        <select name="technology_type" id="technology_type" class="form-control select2" >
            <option value="">Select {{ trans('cruds.technology.fields.technology_type') }}</option>
            @foreach (config('constant.technology_types') as $key => $technologyType)
                <option value="{{$key}}" {{ isset($technology) && $technology->technology_type == $key ? 'selected' : '' }}>{{$technologyType}}</option>
            @endforeach
        </select>        
    </div>

    <div class="form-group">
        <label for="name">{{ trans('cruds.technology.fields.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($technology) ? $technology->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="description">{{ trans('cruds.technology.fields.description') }}</label>
        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{!! isset($technology) ? $technology->description : '' !!}</textarea>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">{{ trans('global.save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
</div>