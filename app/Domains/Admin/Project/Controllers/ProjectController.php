<?php

namespace App\Domains\Admin\Project\Controllers;

use App\Domains\Admin\Project\DataTables\ProjectDataTable;
use App\Domains\Admin\Project\Models\Project;
use App\Domains\Admin\Project\Requests\ProjectStoreRequest;
use App\Domains\Admin\Project\Requests\ProjectUpdateRequest;
use App\Domains\Admin\Technology\Models\Technology;
use App\Domains\Admin\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;
use Throwable;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectDataTable $dataTable)
    {
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('Project::index');
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function create()
    {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $technolgies = Technology::pluck('name', 'id');
            $users = User::whereHas('roles', function($q){
                $q->where('role_id', '<>', config('constant.roles.super_admin'));
            })->select('id', 'uuid', 'name')->get();

            return view('Project::create', compact('users', 'technolgies'));
        } catch (\Exception $e) {
            // dd($e);
            return abort(500);
        }
    }

    public function store(ProjectStoreRequest $request)
    {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $inputs = $request->all();

            $inputs['start_date'] = (empty($request->start_date)) ? null : date('Y-m-d',strtotime($request->start_date));
            $inputs['end_date'] = (empty($request->end_date)) ? null : date('Y-m-d',strtotime($request->end_date));

            if(!empty($request->project_lead)){
                $projectLead = User::where('uuid', $request->project_lead)->first();
                if($projectLead){
                    $inputs['project_lead'] = $projectLead->id;
                }
            }
            
            $project = Project::create($inputs);
            if($project){
                if ($request->hasFile('attachment')) { 
                    foreach($request->file('attachment') as $file)
                    {
                        uploadImage($project, $file,'projects/attachments', 'projectDocument');
                    }
                }
                        
                if($request->technology){
                    $project->technologies()->sync($request->technology);
                }

                if($request->assign_developers){
                    $userIds = User::whereIn('uuid', $request->assign_developers)->pluck('id')->toArray();
                    $project->assignDevelopers()->sync($userIds);
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.add_record'),
                'redirectUrl' => route('projects.index')
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
        abort_if(Gate::denies('project_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $project = Project::where('uuid', $id)->first();
            return view('Project::show', compact('project'))->render();
        }
        catch (\Exception $e) {
            dd($e);
            return abort(500);
        }
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $project = Project::where('uuid', $id)->first();
            $technolgies = Technology::pluck('name', 'id');
            $users = User::whereHas('roles', function($q){
                $q->where('role_id', '<>', config('constant.roles.super_admin'));
            })->select('id', 'uuid', 'name')->get();

            return view('Project::edit', compact('project', 'technolgies', 'users'))->render();
        } catch (\Exception $e) {
            // dd($e);
            return abort(500);
        }
    }

    public function update(ProjectUpdateRequest $request, $id)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $project = Project::where('uuid', $id)->first();

            $inputs = $request->all();
            $inputs['start_date'] = (empty($request->start_date)) ? null : date('Y-m-d',strtotime($request->start_date));
            $inputs['end_date'] = (empty($request->end_date)) ? null : date('Y-m-d',strtotime($request->end_date));

            if(!empty($request->project_lead)){
                $projectLead = User::where('uuid', $request->project_lead)->first();
                if($projectLead){
                    $inputs['project_lead'] = $projectLead->id;
                }
            }

            $project->update($inputs);

            if($project){
                if ($request->hasFile('attachment')) { 
                    foreach($request->file('attachment') as $file)
                    {
                        uploadImage($project, $file,'projects/attachments', 'projectDocument'); 
                    }
                }
                if(isset($request->projectDocIds)){
                    $documentIds = explode(',', $request->projectDocIds);
                    foreach($documentIds as $documentId){
                        deleteFile($documentId);
                    }
                }

                if($request->technology){
                    $project->technologies()->sync($request->technology);
                }

                if($request->assign_developers){
                    $userIds = User::whereIn('uuid', $request->assign_developers)->pluck('id')->toArray();
                    $project->assignDevelopers()->sync($userIds);
                }
            }
                
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.update_record'),
                'redirectUrl' => route('projects.index')
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $project = Project::where('uuid', $id)->first();
                if ($project->project_document_url) {
                    foreach($project->uploads as $projectUploaded){
                        deleteFile($projectUploaded->id);
                    }
                }

                $project->technologies()->sync([]);

                $project->assignDevelopers()->sync([]);

                $project->delete();
                
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

    public function projectAttachmentZip($id){
        try {
            $zip = new ZipArchive;
            $project = Project::where('uuid', $id)->first();
            if($project){
                $zip_upload_dir = 'projects/attachments-zip';
                if(!Storage::disk('public')->exists($zip_upload_dir)){
                    Storage::disk('public')->makeDirectory($zip_upload_dir);
                }
                
                $zipName = 'storage/projects/attachments-zip/'.Str::slug($project->name).'-'.date('d-m-y-h-i-s').'.zip';
                
                if ($zip->open(public_path($zipName), ZipArchive::CREATE) === TRUE)
                {
                    foreach($project->uploads as $attachment){
                        $fileNameArray = explode('/', $attachment->file_path);
                        $fileName = end($fileNameArray);
                        $zip->addFile(public_path('storage/'.$attachment->file_path), $fileName);
                    }
                    $zip->close();
                    
                    $response = [
                        'success'    => true,
                        'zipPath'   => asset($zipName),
                        'message'   => 'Zip created successfully!',
                    ];
                }else{
                    $response = [
                        'success'    => false,
                        'zipPath'   => "",
                        'message'   => trans('messages.error_message'),
                    ];
                } 
            }else{
                $response = [
                    'success'    => false,
                    'zipPath'   => "",
                    'message'   => trans('messages.error_message'),
                ];
            }
            return response()->json($response);
        } catch(Throwable $th){
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );

        }
    }
}
