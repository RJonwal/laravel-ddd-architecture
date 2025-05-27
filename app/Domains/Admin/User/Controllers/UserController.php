<?php

namespace App\Domains\Admin\User\Controllers;

use App\Domains\Admin\User\DataTables\UserDataTable;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\User\Requests\UserStoreRequest;
use App\Domains\Admin\User\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('User::index');
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $viewHTML = view('User::create')->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(UserStoreRequest $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'email', 'phone', 'password');

            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);

            $user->roles()->sync(config('constant.roles.user'));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.add_record'),
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        abort_if(Gate::denies('user_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $user = User::where('uuid', $id)->first();
             
                $viewHTML = view('User::show', compact('user'))->render();
                return response()->json(array('success' => true, 'htmlView'=>$viewHTML));
            }
            catch (\Exception $e) {
                
                // dd($e);

                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $user = User::where('uuid', $id)->first();
            $viewHTML = view('User::edit', compact('user'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $user = User::where('uuid', $id)->first();
            $input = $request->only('name', 'email', 'phone');

            $user->update($input);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.update_record'),
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user = User::where('uuid', $id)->first();
            DB::beginTransaction();
            try {
                if ($user->profile_image_url) {
                    $uploadImageId = $user->profileImage->id;
                    deleteFile($uploadImageId);
                }
                $user->delete();
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => trans('messages.crud.delete_record'),
                ];
                return response()->json($response);
            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e);
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function changeStatus(Request $request){
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'     => [
                    'required',
                    'exists:users,uuid',
                ],
            ]);
            if (!$validator->passes()) {
                return response()->json(['success'=>false,'errors'=>$validator->getMessageBag()->toArray(),'message'=>'Error Occured!'],400);
            }else{
                DB::beginTransaction();
                try{
                    $user = User::where('uuid', $request->id)->first();
                    if($user->status == 'inactive'){
                        $status = 'active';
                    } else {
                        $status = 'inactive';
                    }
                    $user->update(['status' => $status]);

                    DB::commit();
                    $response = [
                        'status'    => 'true',
                        'message'   => trans('cruds.user.title_singular').' '.trans('messages.crud.status_update'),
                    ];
                    return response()->json($response);
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e);
                    return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
                }
            }
        }
    }
}
