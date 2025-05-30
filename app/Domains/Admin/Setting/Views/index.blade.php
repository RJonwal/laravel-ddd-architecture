@extends('Layouts::app')
@section('title', __('cruds.setting.title'))

@section('custom_css')
    <link href="{{ asset('admin-assets/vendor/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .tab-container .tab-content .tab-item.hide{
            display: none;
        }
        .form-group{
            margin: 0px;
        }
        .card-footer {
            border-top: 1px solid #f5f5f5;
            background-color: transparent;
        }
        label .btn  {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0px;
        }
    </style>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">@lang('cruds.setting.title')</h4>
                </div>
                <div class="tab-container">
                    <nav class="tab-nav">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><button class="nav-link setting-tab active" id="site-setting">@lang('cruds.setting.site')</button></li>
                            <li class="nav-item"><button class="nav-link setting-tab" id="support-setting">@lang('cruds.setting.support')</button></li>
                        </ul>
                    </nav>
                    <div class="tab-content p-sm-4 p-3">
                        <div class="tab-item" data-id="site-setting">
                            <h3>@lang('cruds.setting.site_setting')</h3>
                            <form class="msg-form" id="siteSettingform" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="setting_type" value="site">
                                <div class="card-body px-0 pb-0">
                                    <div class="row">
                                        @foreach($siteSettings as $key => $siteSetting)
                                            @if($siteSetting->type == 'text')
                                            <div class="mb-3 col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{ $siteSetting->display_name}} <span class="required">*</span></label>
                                                    <input type="text" class="form-control" value="{{$siteSetting->value}}" name="{{$siteSetting->key}}" required/>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($siteSetting->type == 'image')
                                                <div class="mb-3 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ $siteSetting->display_name}} </label>
                                                        <input name="{{$siteSetting->key}}" type="file" class="dropify" id="image-input-{{$siteSetting->key}}" data-default-file=" {{ $siteSetting->image_url ? $siteSetting->image_url : asset(config('constant.default.logo')) }}"  data-show-loader="true" data-errors-position="outside" data-allowed-file-extensions="jpeg png jpg PNG JPG" accept="image/jpeg, image/png, image/jpg, image/PNG, image/JPG" />
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer rounded-0 px-0 pb-0">
                                    <div class="form-label justify-content-center m-0 text-end">
                                        <button type="submit" class="btn btn-success submitBtn">@lang('global.update')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-item hide" data-id="support-setting">
                            <h3>@lang('cruds.setting.support_setting')</h3>
                            <form class="msg-form" id="supportSettingform" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="setting_type" value="support">
                                <div class="card-body px-0 pb-0">
                                    <div class="row">
                                        @foreach($supportSettings as $key => $supportSetting)                                
                                            @if($supportSetting->type == 'text')
                                                <div class="mb-3 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ $supportSetting->display_name}} <span class="required">*</span></label>
                                                        <input type="text" class="form-control" value="{{$supportSetting->value}}" name="{{$supportSetting->key}}" required/>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach                                         
                                    </div>
                                </div>
                                <div class="card-footer rounded-0 px-0 pb-0">
                                    <div class="form-label justify-content-center m-0 text-end">
                                        <button type="submit" class="btn btn-success submitBtn">@lang('global.update')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   


@endsection

@section('custom_js')

@include('Setting::partials.script')

@endsection