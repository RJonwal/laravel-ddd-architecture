<?php

namespace App\Domains\Admin\Milestone\DataTables;

use App\Domains\Admin\Milestone\Models\Milestone;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Str;

class MilestoneDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('milestones.*')->with(['project'])))
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

            ->editColumn('start_date', function($record){
                return $record->start_date->format(config('constant.date_format.date'));
            })

            ->editColumn('end_date', function($record){
                return $record->end_date->format(config('constant.date_format.date'));
            })
            ->editColumn('status', function($record) {
                $status = $record->status;
                $statusText = $status ? config('constant.milestone_status.' . $status, '') : '';

                $colorClass = match($status) {
                    'initial'    => 'badge bg-danger',
                    'completed'  => 'badge bg-success',
                    'in_progress' => 'badge bg-warning text-dark',
                    'not_started' => 'badge bg-secondary',
                };
                return '<span class="' . $colorClass . '">' . $statusText . '</span>';
            })

            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('milestone_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('milestones.show',$record->uuid).'" class="btn btn-outline-info btn-sm btnViewMilestone" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('milestone_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('milestones.edit',$record->uuid).'" class="btn btn-outline-success btn-sm btnEditMilestone" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('milestone_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteMilestoneBtn" data-href="'.route('milestones.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                }
                return $actionHtml;
            })
            ->setRowId('id')
            ->filterColumn('start_date', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date');
                $query->whereRaw("DATE_FORMAT(start_date,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('end_date', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date');
                $query->whereRaw("DATE_FORMAT(end_date,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date_time');
                $query->whereRaw("DATE_FORMAT(created_at,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Milestone $model): QueryBuilder
    {         
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 6;        
        return $this->builder()
                    ->setTableId('milestone-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
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
      
        $columns[] = Column::make('name')->title(trans('cruds.milestone.fields.name'));
        $columns[] = Column::make('project.name')->title(trans('cruds.milestone.fields.project_id'));
        $columns[] = Column::make('start_date')->title(trans('cruds.milestone.fields.start_date'));
        $columns[] = Column::make('end_date')->title(trans('cruds.milestone.fields.end_date'));
        $columns[] = Column::make('status')->title(trans('cruds.milestone.fields.status'));
        $columns[] = Column::make('created_at')->title(trans('cruds.milestone.fields.created_at'))->addClass('dt-created_at');
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Milestones' . date('YmdHis');
    }
}
