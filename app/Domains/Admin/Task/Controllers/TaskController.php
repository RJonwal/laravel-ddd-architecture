<?php

namespace App\Domains\Admin\Task\Controllers;

use App\Domains\Admin\Task\DataTables\TaskDataTable;
use App\Domains\Admin\Task\Models\Task;
use App\Domains\Admin\Sprint\Models\Sprint;
use App\Domains\Admin\Milestone\Models\Milestone;
use App\Domains\Admin\User\Models\User;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Task\Requests\TaskStoreRequest;
use App\Domains\Admin\Task\Requests\TaskUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskDataTable $dataTable)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('Task::index');
        } catch (\Exception $e) {
             Log::error('Task Index Error: '.$e->getMessage(), [
                'exception' => $e
            ]);
            abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $users = User::where('id', '!=', 1)->select('id', 'name', 'uuid')->get();
            $projects = Project::select('id', 'name', 'uuid')->get();
            $viewHTML = view('Task::create',compact('users','projects'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function store(TaskStoreRequest $request)
    {
        abort_if(Gate::denies('task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'description', 'project_id', 'parent_task_id', 'milestone_id', 'sprint_id', 'user_id', 'estimated_time', 'priority', 'status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
            if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            if (!empty($input['sprint_id'])) {
                $sprint = Sprint::where('uuid', $input['sprint_id'])->first();
                $input['sprint_id'] = $sprint->id;
            }
            if (!empty($input['user_id'])) {
                $user = User::where('uuid', $input['user_id'])->first();
                $input['user_id'] = $user->id;
            }
            if (!empty($input['parent_task_id'])) {
                $task = Task::where('uuid', $input['parent_task_id'])->first();
                $input['parent_task_id'] = $task->id;
            }
            Task::create($input);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.add_record'),
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        abort_if(Gate::denies('task_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($request->ajax()) {
            try{
                $parentName = null;
                $task = Task::where('uuid',$id)->with('sprint')->first();
                // dd($task);
                if ($task->parent_task_id) {
                    $parent = Task::find($task->parent_task_id);
                    $parentName = $parent ? $parent->name : 'N/A';
                }
                $viewHTML = view('Task::show', compact('task','parentName'))->render();
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
        abort_if(Gate::denies('task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $task = Task::with(['sprint','milestone', 'user', 'project'])->where('uuid',$id)->first();
            $projects = Project::select('name', 'id', 'uuid')->get();
            $milestones = Milestone::where('project_id', $task->project_id)->select('name', 'id', 'uuid')->get();
            $sprints = Sprint::where('milestone_id', $task->milestone_id)->select('name','id','uuid')->get();
            $users = User::where('id', '!=', 1)->select('name', 'id', 'uuid')->get();
            $parentTasks = Task::where('parent_task_id', null)
            ->where('project_id', $task->project_id)
            ->where('id', '!=', $task->id)
            ->select('name', 'id', 'uuid')->get();
            $viewHTML = view('Task::edit', compact('task', 'milestones', 'sprints', 'users', 'projects', 'parentTasks'))->render();
            return response()->json(['success' => true, 'htmlView' => $viewHTML]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        abort_if(Gate::denies('task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $input = $request->only('name','description', 'project_id', 'parent_task_id', 'milestone_id', 'sprint_id', 'user_id', 'estimated_time', 'priority', 'status');
            if (!empty($input['project_id'])) {
                $project = Project::where('uuid', $input['project_id'])->first();
                $input['project_id'] = $project->id;
            }
            if (!empty($input['milestone_id'])) {
                $milestone = Milestone::where('uuid', $input['milestone_id'])->first();
                $input['milestone_id'] = $milestone->id;
            }
            if (!empty($input['sprint_id'])) {
                $sprint = Sprint::where('uuid', $input['sprint_id'])->first();
                $input['sprint_id'] = $sprint->id;
            }
            if (!empty($input['user_id'])) {
                $user = User::where('uuid', $input['user_id'])->first();
                $input['user_id'] = $user->id;
            }
            if (!empty($input['parent_task_id'])) {
                $ParentTask = Task::where('uuid', $input['parent_task_id'])->first();
                $input['parent_task_id'] = $ParentTask->id;
            }
            $task->update($input);
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
        abort_if(Gate::denies('task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $task = Task::where('uuid',$id)->first();
                $task->delete();
                
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

     public function getSprintsByMilestone(Request $request){
        $milestoneUuid = $request->input('milestone_id');
        if (!empty($milestoneUuid)) {
            $milestone = Milestone::where('uuid', $milestoneUuid)->first();
            if (!$milestone) {
                return response()->json([
                'success' => false,
                'message' => 'Milestone not found for given UUID.'
            ], 404);
            }
            $milestoneId = $milestone->id;
        }
        if (!$milestoneId) {
            return response()->json([]);
        }

        $sprints = Sprint::where('milestone_id', $milestoneId)
            ->select('id', 'uuid', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
        return response()->json($sprints);
    }

    public function getTaskBySprint(Request $request){
        $sprintUuid = $request->input('sprint_id');
        $sprint = Sprint::where('uuid', $sprintUuid)->first();
        if (!$sprint) {
            return response()->json([ 'success' => false,
                'message' => 'Sprint not found for given UUID.'
            ], 404);
        }
        $tasks = task::where('sprint_id', $sprint->id)
            ->select('id', 'uuid', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
        return response()->json($tasks);
    }

    public function reorder(Request $request){
        $request->validate([
            'item_id' => 'required|exists:tasks,id',
            'new_milestone_id' => 'required|exists:milestones,id',
            'new_sprint_id' => 'required|exists:sprints,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
        ]);

        $task = Task::findOrFail($request->item_id);

        $task->parent_task_id = $request->parent_task_id;
        $task->milestone_id = $request->new_milestone_id;
        $task->sprint_id = $request->new_sprint_id;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function updateMilestoneTaskSubtask(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:milestone,task,subtask,sprint',
            'name' => 'required|string|max:255'
        ]);

        $model = match ($request->type) {
            'milestone' => Milestone::find($request->id),
            'sprint'    => Sprint::find($request->id),
            'task', 'subtask' => Task::find($request->id),
        };

        if (!$model) return response()->json(['error' => 'Not found'], 404);

        $model->name = $request->name;
        $model->save();

        return response()->json(['success' => true]);
    }

    public function deleteMilestoneSprintTaskSubtask(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $type = $request->type;

        try {
            switch ($type) {
                case 'milestone':
                    $milestone = Milestone::findOrFail($id);
                    foreach ($milestone->sprints as $sprint) {
                        foreach ($sprint->tasks as $task) {
                            if ($task->parent_task_id === null) {
                                Task::where('parent_task_id', $task->id)->delete();
                            }
                            $task->delete();
                        }
                        $sprint->delete();
                    }
                    $milestone->delete();
                    break;

                case 'sprint':
                    $sprint = Sprint::findOrFail($id);
                    foreach ($sprint->tasks as $task) {
                        Task::where('sprint_id', $task->id)->delete();
                        $task->delete();
                    }
                    $sprint->delete();
                    break;

                case 'task':
                    $task = Task::findOrFail($id);
                    if ($task->parent_task_id === null) {
                        Task::where('parent_task_id', $task->id)->delete();
                    }
                    $task->delete();
                    break;

                default:
                    return response()->json(['message' => 'Invalid type'], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting item.', 'error' => $e->getMessage()], 500);
        }
    }
}
