<?php

namespace App\Domains\Admin\DailyActivityLog\Controllers;

use App\Domains\Admin\DailyActivityLog\DataTables\DailyActivityLogDataTable;
use App\Domains\Admin\DailyActivityLog\Models\DailyActivityLog;
use App\Domains\Admin\DailyActivityLog\Models\DailyActivityTaskLog;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\DailyActivityLog\Requests\DailyActivityLogStoreRequest;
use App\Domains\Admin\DailyActivityLog\Requests\DailyActivityLogUpdateRequest;
use App\Domains\Admin\Task\Models\Task;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DailyActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyActivityLogDataTable $dataTable)
    {
        abort_if(Gate::none(['daily_activity_log_access','admin_daily_activity_log_access']), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('DailyActivityLog::index');
        } catch (\Exception $e) {
             Log::error('DailyActivityLog Index Error: '.$e->getMessage(), [
                'exception' => $e
            ]);
            abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('daily_activity_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $projects = Project::select('id', 'name', 'uuid')->get();

            return view('DailyActivityLog::create', compact('projects'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(DailyActivityLogStoreRequest $request)
    {
        abort_if(Gate::denies('daily_activity_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            // dd($request->all());
            if (!empty($request->project_id)) {
                $project = Project::where('uuid', $request->project_id)->select('id')->first();
            }
            if (!empty($request->milestone_id)) {
                $milestone = Milestone::where('uuid', $request->milestone_id)->select('id')->first();
            }
            $dailyActivityLog = DailyActivityLog::create([
                'project_id' => $project->id,
                'milestone_id' => $milestone->id,
                'report_date' =>  Carbon::parse($request->report_date)->format('Y-m-d') //date('Y-m-d', strtotime($request->report_date)),
            ]);

            if($dailyActivityLog){
                $dailyActivityLogTasks = $request->daily_activity;
                foreach ($dailyActivityLogTasks as $key => $dailyActivityLogTask) {
                    if (!empty($dailyActivityLogTask['task_id'])) {
                        $task = Task::where('uuid', $dailyActivityLogTask['task_id'])->select('id')->first();
                    }
                    if (!empty($dailyActivityLogTask['sub_task_id'])) {
                        $subTask = Task::where('uuid', $dailyActivityLogTask['sub_task_id'])->select('id')->first();
                    }
                    DailyActivityTaskLog::create([
                        'daily_activity_log_id' => $dailyActivityLog->id,
                        'task_id'     => $task->id,
                        'sub_task_id' => $subTask?->id,
                        'description' => $dailyActivityLogTask['description'],
                        'task_type'   => $dailyActivityLogTask['task_type'],
                        'work_time'   => $dailyActivityLogTask['work_time'],
                        'status'      => $dailyActivityLogTask['status'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'redirectUrl' => route('daily-activity-logs.index'),
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
    public function show(Request $request, $id)
    {
        abort_if(Gate::denies('daily_activity_log_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $parentName = null;
                $dailyActivityLog = DailyActivityLog::where('uuid',$id)->first();
                if ($dailyActivityLog->parent_daily_task_id) {
                    $parent = DailyActivityLog::find($dailyActivityLog->parent_daily_task_id);
                }
                $viewHTML = view('DailyActivityLog::show', compact('dailyActivityLog'))->render();
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
        abort_if(Gate::denies('daily_activity_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $dailyActivityLog = DailyActivityLog::with(['milestone', 'user', 'project'])->where('uuid',$id)->first();
            $milestones = Milestone::where('project_id', $dailyActivityLog->project_id)->select('name', 'id', 'uuid')->get();
            $users = User::where('id', '!=', 1)->select('name', 'id', 'uuid')->get();
            $projects = Project::select('name', 'id', 'uuid')->get();
            $parentDailyActivityLogs = DailyActivityLog::where('parent_daily_task_id', null)
            ->where('project_id', $dailyActivityLog->project_id)
            ->where('id', '!=', $dailyActivityLog->id)
            ->select('name', 'id', 'uuid')->get();
            $viewHTML = view('DailyActivityLog::edit', compact('dailyActivityLog', 'milestones', 'users', 'projects', 'parentDailyActivityLogs'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(DailyActivityLogUpdateRequest $request, DailyActivityLog $dailyActivityLog)
    {
        abort_if(Gate::denies('daily_activity_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
                $ParentDailyActivityLog = DailyActivityLog::where('uuid', $input['parent_daily_task_id'])->first();
                $input['parent_daily_task_id'] = $ParentDailyActivityLog->id;
            }
            $dailyActivityLog->update($input);
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
        abort_if(Gate::denies('daily_activity_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $dailyActivityLog = DailyActivityLog::where('uuid',$id)->first();
                $dailyActivityLog->delete();
                
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

    public function getMilestones(Request $request){
        try {
            $projectUuid = $request->input('project_id');
            if (!empty($projectUuid)) {
                $project = Project::with(['milestones'])->where('uuid', $projectUuid)->first();
                if (!$project) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Project not found.'
                    ], 404);
                }
            }
            $milestones = $project->milestones()->select('id', 'uuid', 'name')->orderBy('name')->get()->toArray();

            $response = [
                'success'    => true,
                'milestones'    => $milestones,
            ];
            return response()->json($response);
            
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function getTaskHtml(Request $request){
        $milestoneUuid = $request->input('milestone_id');
        $tasks = [];
        if($milestoneUuid != 0){
            $milestone = Milestone::where('uuid', $milestoneUuid)->first();
            if (!$milestone) {
                return response()->json([ 'success' => false,
                    'message' => 'Milestone not found for given UUID.'
                ], 404);
            }
            $tasks = $milestone->tasks()->where('parent_task_id' ,NULL)->select('id', 'uuid', 'name')->orderBy('name')->get();
        }
        
        $taskCount = 0;
        if(isset($request->task_count)){
            $taskCount = $request->task_count;
        }

        $viewHTML = view('DailyActivityLog::partials.task_activity', compact('tasks', 'taskCount'))->render();

        return response()->json(['success' => true, 'htmlView' => $viewHTML]);
    }

    public function getSubTasks(Request $request){
        try {
            $taskUuid = $request->input('task_id');
            if (!empty($taskUuid)) {
                $task = Task::where('uuid', $taskUuid)->first();
                if (!$task) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Task not found.'
                    ], 404);
                }
            }
            $subTasks = $task->subTasks()->select('id', 'uuid', 'name')->orderBy('name')->get()->toArray();

            $response = [
                'success'    => true,
                'subTasks'    => $subTasks
            ];
            return response()->json($response);
            
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }
}
