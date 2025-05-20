<?php

namespace App\Domains\Admin\Technology\Controllers;

use App\Domains\Admin\Technology\DataTables\TechnologyDataTable;
use App\Domains\Admin\Technology\Models\Technology;
use App\Domains\Admin\Technology\Requests\TechnologyStoreRequest;
use App\Domains\Admin\Technology\Requests\TechnologyUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TechnologyDataTable $dataTable)
    {
        abort_if(Gate::denies('technology_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('Technology::index');
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('technology_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $viewHTML = view('Technology::create')->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(TechnologyStoreRequest $request)
    {
        abort_if(Gate::denies('technology_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'description', 'technology_type');
            Technology::create($input);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.add_record'),
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Technology $technology)
    {
        abort_if(Gate::denies('technology_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $viewHTML = view('Technology::show', compact('technology'))->render();
                return response()->json(array('success' => true, 'htmlView'=>$viewHTML));
            }
            catch (\Exception $e) {
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function edit(Request $request, Technology $technology)
    {
        abort_if(Gate::denies('technology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $viewHTML = view('Technology::edit', compact('technology'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(TechnologyUpdateRequest $request, Technology $technology)
    {
        abort_if(Gate::denies('technology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'description', 'technology_type');

            $technology->update($input);
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
    public function destroy(Request $request, Technology $technology)
    {
        abort_if(Gate::denies('technology_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                
                $technology->projects()->sync([]);
                $technology->delete();
                
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => trans('messages.crud.delete_record'),
                ];
                return response()->json($response);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }
}
