<?php

namespace App\Domains\Admin\Milestone\Controllers;

use App\Domains\Admin\Milestone\DataTables\MilestoneDataTable;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Milestone\Requests\MilestoneStoreRequest;
use App\Domains\Admin\Milestone\Requests\MilestoneUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MilestoneDataTable $dataTable)
    {
        abort_if(Gate::denies('milestone_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('Milestone::index');
        } catch (\Exception $e) {
             Log::error('Milestone Index Error: '.$e->getMessage(), [
                'exception' => $e
            ]);
            abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('milestone_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $viewHTML = view('Milestone::create')->render();
            $projects = Project::select('id', 'name', 'uuid')->get();
            return response()->json(['success' => true, 'htmlView' => $viewHTML, 'projects' => $projects]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(MilestoneStoreRequest $request)
    {
        abort_if(Gate::denies('milestone_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'project_id', 'start_date', 'end_date');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                if (!$project) {
                    throw new \Exception('Project not found for given UUID.');
                }

                $input['project_id'] = $project->id;
            }
            Milestone::create($input);

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
    public function show(Request $request, $id)
    {
        abort_if(Gate::denies('milestone_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $milestone = Milestone::where('uuid', $id)->first();
                if ($milestone->project_id) {
                    $project = Project::find($milestone->project_id);
                    $projectName = $project ? $project->name : 'N/A';
                }
                $viewHTML = view('Milestone::show', compact('milestone','projectName'))->render();
                return response()->json(array('success' => true, 'htmlView'=>$viewHTML));
            }
            catch (\Exception $e) {
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('milestone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $milestone = Milestone::where('uuid', $id)->first();
            $projects = Project::select('name', 'id', 'uuid')->get();
            $viewHTML = view('Milestone::edit', compact('milestone','projects'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(MilestoneUpdateRequest $request, Milestone $milestone)
    {
        abort_if(Gate::denies('milestone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'project_id', 'start_date', 'end_date');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                if (!$project) {
                    throw new \Exception('Project not found for given UUID.');
                }

                $input['project_id'] = $project->id;
            }
            $milestone->update($input);
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
        abort_if(Gate::denies('milestone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $milestone = Milestone::where('uuid', $id)->first();
                if ($milestone->tasks()->exists()) {
                    return response()->json([
                        'success' => false,
                        'error_type' => 'has_tasks',
                        'error' => 'Cannot delete this milestone because it has associated tasks.',
                    ], 400);
                }
                $milestone->delete();
                
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => trans('messages.crud.delete_record'),
                ];
                return response()->json($response);
            } catch (\Exception $e) {
                dd($e);
                DB::rollBack();
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }
}
