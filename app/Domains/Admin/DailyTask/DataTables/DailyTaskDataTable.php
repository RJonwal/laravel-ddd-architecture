<?php

namespace App\Domains\Admin\DailyTask\DataTables;

use App\Domains\Admin\DailyTask\Models\DailyTask;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Str;

class DailyTaskDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('daily_tasks.*')->with(['milestone', 'user','project'])))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));

            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })

            ->editColumn('project.name', function($record){
                return $record->project_id ? $record->project->name : '-';
            })

            ->editColumn('milestone.name', function($record){
                return $record->milestone ? $record->milestone->name : '-';
            })

            ->editColumn('user.name', function($record){
                return $record->user ? $record->user->name : '-';
            })

            ->editColumn('estimated_time', function($record){
                return $record->estimated_time ? ucwords($record->estimated_time) : '';
            })

            ->editColumn('priority', function($record){
                return $record->priority ? ucwords($record->priority) : '';
            })

            ->editColumn('status', function($record) {
                $status = $record->status;
                $statusText = $status ? config('constant.daily_task_status.' . $status, '') : '';

                $colorClass = match($status) {
                    'initial'    => 'badge bg-danger',
                    'completed'  => 'badge bg-success',
                    'in_progress' => 'badge bg-warning text-dark',
                    default      => 'badge bg-secondary',
                };

                return '<span class="' . $colorClass . '">' . $statusText . '</span>';
            })

            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('daily_task_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('daily-tasks.show',$record->uuid).'" class="btn btn-outline-info btn-sm btnViewDailyTask" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('daily_task_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('daily-tasks.edit',$record->uuid).'" class="btn btn-outline-success btn-sm btnEditDailyTask" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('daily_task_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteDailyTaskBtn" data-href="'.route('daily-tasks.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                }
                return $actionHtml;
            })
            ->setRowId('id')

            ->filterColumn('created_at', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date_time');
                $query->whereRaw("DATE_FORMAT(created_at,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DailyTask $model): QueryBuilder
    {         
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 8;        
        return $this->builder()
                    ->setTableId('daily-task-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy($orderByColumn)                    
                    ->selectStyleSingle()
                    ->lengthMenu([
                        [10, 25, 50, 100, /*-1*/],
                        [10, 25, 50, 100, /*'All'*/]
                    ])->parameters([
                        'responsive'=> true,
                        'pagingType' => 'simple_numbers',
                        'drawCallback' => 'function(settings) {
                            var api = this.api();
                            var rows = api.rows({ page: "current" }).count();
                            var pageLength = api.page.len();
                            var recordsTotal = api.page.info().recordsTotal;
                            if (recordsTotal > pageLength) {
                                $(this).closest(".dt-container").find(".dt-paging.paging_simple_numbers").show();
                            } else {
                                $(this).closest(".dt-container").find(".dt-paging.paging_simple_numbers").hide();
                            }
                        }'
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [];

        $columns[] = Column::make('DT_RowIndex')->title(trans('global.sno'))->orderable(false)->searchable(false)->addClass('dt-sno');
      
        $columns[] = Column::make('name')->title(trans('cruds.dailyTask.fields.name'));
        $columns[] = Column::make('project.name')->title(trans('cruds.dailyTask.fields.project_id'));
        $columns[] = Column::make('milestone.name')->title(trans('cruds.dailyTask.fields.milestone_id'));
        $columns[] = Column::make('user.name')->title(trans('cruds.dailyTask.fields.assigned_to'));
        $columns[] = Column::make('estimated_time')->title(trans('cruds.dailyTask.fields.estimated_time'));
        $columns[] = Column::make('priority')->title(trans('cruds.dailyTask.fields.priority'));
        $columns[] = Column::make('status')->title(trans('cruds.dailyTask.fields.status'));
        $columns[] = Column::make('created_at')->title(trans('cruds.dailyTask.fields.created_at'))->addClass('dt-created_at');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DailyTasks' . date('YmdHis');
    }
}
