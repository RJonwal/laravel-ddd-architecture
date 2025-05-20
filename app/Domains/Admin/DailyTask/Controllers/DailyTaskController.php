<?php

namespace App\Domains\Admin\DailyTask\Controllers;

use App\Domains\Admin\DailyTask\DataTables\DailyTaskDataTable;
use App\Domains\Admin\DailyTask\Models\DailyTask;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\DailyTask\Requests\DailyTaskStoreRequest;
use App\Domains\Admin\DailyTask\Requests\DailyTaskUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DailyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyTaskDataTable $dataTable)
    {
        abort_if(Gate::denies('daily_task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('DailyTask::index');
        } catch (\Exception $e) {
             Log::error('DailyTask Index Error: '.$e->getMessage(), [
                'exception' => $e
            ]);
            abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('daily_task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $users = User::where('id', '!=', 1)->select('id', 'name', 'uuid')->get();
            $projects = Project::select('id', 'name', 'uuid')->get();
            $viewHTML = view('DailyTask::create',compact('users','projects'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(DailyTaskStoreRequest $request)
    {
        abort_if(Gate::denies('daily_task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'description', 'project_id', 'parent_daily_task_id', 'milestone_id', 'user_id', 'estimated_time', 'priority', 'status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
            if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            if (!empty($input['user_id'])) {
                $user = User::where('uuid', $input['user_id'])->first();
                $input['user_id'] = $user->id;
            }
            if (!empty($input['parent_daily_task_id'])) {
                $dailyTask = DailyTask::where('uuid', $input['parent_daily_task_id'])->first();
                $input['parent_daily_task_id'] = $dailyTask->id;
            }
            DailyTask::create($input);

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
        abort_if(Gate::denies('daily_task_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $parentName = null;
                $dailyTask = DailyTask::where('uuid',$id)->first();
                if ($dailyTask->parent_daily_task_id) {
                    $parent = DailyTask::find($dailyTask->parent_daily_task_id);
                    $parentName = $parent ? $parent->name : 'N/A';
                }
                $viewHTML = view('DailyTask::show', compact('dailyTask','parentName'))->render();
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
        abort_if(Gate::denies('daily_task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $dailyTask = DailyTask::with(['milestone', 'user', 'project'])->where('uuid',$id)->first();
            $milestones = Milestone::where('project_id', $dailyTask->project_id)->select('name', 'id', 'uuid')->get();
            $users = User::where('id', '!=', 1)->select('name', 'id', 'uuid')->get();
            $projects = Project::select('name', 'id', 'uuid')->get();
            $parentDailyTasks = DailyTask::where('parent_daily_task_id', null)
            ->where('project_id', $dailyTask->project_id)
            ->where('id', '!=', $dailyTask->id)
            ->select('name', 'id', 'uuid')->get();
            $viewHTML = view('DailyTask::edit', compact('dailyTask', 'milestones', 'users', 'projects', 'parentDailyTasks'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(DailyTaskUpdateRequest $request, DailyTask $dailyTask)
    {
        abort_if(Gate::denies('daily_task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name','description', 'project_id', 'parent_daily_task_id', 'milestone_id', 'user_id', 'estimated_time', 'priority', 'status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
            if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            if (!empty($input['user_id'])) {
                $user = User::where('uuid', $input['user_id'])->first();
                $input['user_id'] = $user->id;
            }
            if (!empty($input['parent_daily_task_id'])) {
                $ParentDailyTask = DailyTask::where('uuid', $input['parent_daily_task_id'])->first();
                $input['parent_daily_task_id'] = $ParentDailyTask->id;
            }
            $dailyTask->update($input);
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
        abort_if(Gate::denies('daily_task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $dailyTask = DailyTask::where('uuid',$id)->first();
                $dailyTask->delete();
                
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

    public function getMilestonesByProject(Request $request){
        $projectUuid = $request->input('project_id');
        if (!empty($projectUuid)) {
            $project = Project::where('uuid', $projectUuid)->first();
            if (!$project) {
                return response()->json([
                'success' => false,
                'message' => 'Project not found for given UUID.'
            ], 404);
            }
            $projectId = $project->id;
        }
        if (!$projectId) {
            return response()->json([]);
        }

        $milestones = Milestone::where('project_id', $projectId)
            ->select('id', 'uuid', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
        return response()->json($milestones);
    }

    public function getDailyTaskByMilestone(Request $request){
        $milestoneUuid = $request->input('milestone_id');
        $milestone = Milestone::where('uuid', $milestoneUuid)->first();
        if (!$milestone) {
            return response()->json([ 'success' => false,
                'message' => 'Milestone not found for given UUID.'
            ], 404);
        }
        $dailyTasks = dailyTask::where('milestone_id', $milestone->id)->where('parent_daily_task_id' ,NULL)
            ->select('id', 'uuid', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
        return response()->json($dailyTasks);
    }
}
