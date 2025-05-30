<?php

namespace App\Domains\Admin\Sprint\Controllers;

use App\Domains\Admin\Sprint\DataTables\SprintDataTable;
use App\Domains\Admin\Sprint\Models\Sprint;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Sprint\Requests\SprintStoreRequest;
use App\Domains\Admin\Sprint\Requests\SprintUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SprintDataTable $dataTable)
    {
        abort_if(Gate::denies('sprint_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('Sprint::index');
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('sprint_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $projects = Project::select('id', 'name', 'uuid')->with('milestones')->get();
            $viewHTML = view('Sprint::create',compact('projects'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(SprintStoreRequest $request)
    {
        abort_if(Gate::denies('sprint_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'description', 'project_id', 'milestone_id', 'start_date', 'end_date','status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
            if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            Sprint::create($input);

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
        abort_if(Gate::denies('sprint_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $sprint = Sprint::with('project','milestone')->where('uuid', $id)->first();
                $viewHTML = view('Sprint::show', compact('sprint'))->render();
                return response()->json(array('success' => true, 'htmlView'=>$viewHTML));
            }
            catch (\Exception $e) {
                dd($e);
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('sprint_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $sprint = Sprint::where('uuid', $id)->first();
            $projects = Project::select('name', 'id', 'uuid')->get();
            $viewHTML = view('Sprint::edit', compact('sprint','projects'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(SprintUpdateRequest $request, Sprint $sprint)
    {
        abort_if(Gate::denies('sprint_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'project_id', 'milestone_id', 'description', 'start_date', 'end_date','status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
             if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            $sprint->update($input);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        abort_if(Gate::denies('sprint_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $sprint = Sprint::where('uuid', $id)->first();
                if ($sprint->tasks()->exists()) {
                    return response()->json([
                        'success' => false,
                        'error_type' => 'has_tasks',
                        'error' => trans('messages.has_tasks_error'),
                    ], 400);
                }
                $sprint->delete();
                
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => trans('messages.crud.delete_record'),
                ];
                return response()->json($response);
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:sprints,id',
            'new_milestone_id' => 'required|exists:milestones,id',
        ]);

        $sprint = Sprint::findOrFail($request->item_id);
        $sprint->milestone_id = $request->new_milestone_id;
        $sprint->save();

        return response()->json(['success' => true]);
    }
}
