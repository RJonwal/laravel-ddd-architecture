<?php

namespace App\Domains\Admin\Setting\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Admin\Setting\Models\Setting;
use App\Domains\Admin\Setting\Requests\UpdateRequest;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{ 
    public function getSettingData() //get
    {
        $siteSettings = Setting::where('group','web')->get();
        $supportSettings = Setting::where('group','support')->get();
        return view('Setting::index', compact('siteSettings','supportSettings'));
    }

    public function updateSiteSetting(UpdateRequest $request, Setting $setting)
    {
        $data=$request->all();
        try {
            DB::beginTransaction();
            foreach ($data as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                $setting_value = $value;
                if ($setting) {
                    if ($setting->type === 'image') {
                        if ($value) {
                            $uploadId = $setting->image ? $setting->image->id : null;
                            if($uploadId){
                                uploadImage($setting, $value, 'settings/images/',"setting-image", 'original', 'update', $uploadId);
                            }else{
                                uploadImage($setting, $value, 'settings/images/',"setting-image", 'original', 'save', null);
                            }
                        }
                        $setting_value = null;
                    }
                    else {
                        // Handle other fields
                        $setting->value = $setting_value;
                    }
                    $setting->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.update_record'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }
}
