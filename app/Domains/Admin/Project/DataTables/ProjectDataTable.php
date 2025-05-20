<?php

namespace App\Domains\Admin\Project\DataTables;

use App\Domains\Admin\Project\Models\Project;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class ProjectDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->with(['projectLead'])->select('projects.*')))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));
            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })

            ->editColumn('projectLead.name', function($record){
                return $record->project_lead && $record->projectLead ? ucwords($record->projectLead->name)  : '';
            })

            ->editColumn('start_date', function($record) {
                return $record->start_date ? $record->start_date->format(config('constant.date_format.date')) : '';
            })

            ->editColumn('end_date', function($record) {
                return $record->end_date ? $record->end_date->format(config('constant.date_format.date')) : '';
            })

            ->editColumn('project_status', function($record) {
                $status = $record->project_status;
                $statusText = $status ? config('constant.project_status')[$record->project_status] : '';
                if($statusText){
                    $colorClass = match($status) {
                        'start'    => 'badge bg-danger',
                        'complete'  => 'badge bg-success',
                        'progress' => 'badge bg-warning text-dark',
                        'hold'      => 'badge bg-secondary',
                    };
                    return '<span class="' . $colorClass . '">' . $statusText . '</span>';
                } else {
                    return '';
                }
            })
            
            ->addColumn('action', function($record){
                $actionHtml = '';
                if (Gate::check('project_view')) {
                    $actionHtml .= '<a href="'.route('projects.show',$record->uuid).'" class="btn btn-outline-info btn-sm" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('project_edit')) {
                    $actionHtml .= '<a href="'.route('projects.edit',$record->uuid).'" class="btn btn-outline-success btn-sm" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('project_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteProjectBtn" data-href="'.route('projects.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                }

                if (Gate::check('project_view')) {
                    $actionHtml .= '<a href="'.route('projects.milestones.tasks',$record->uuid).'" class="btn btn-outline-info btn-sm" title="Show"> <i class=" ri-calendar-check-line"></i> </a>';
                }
                return $actionHtml;
            })
            ->setRowId('id')

            ->filterColumn('created_at', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date_time');
                $query->whereRaw("DATE_FORMAT(created_at,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })

            ->filterColumn('start_date', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date');
                $query->whereRaw("DATE_FORMAT(start_date,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })

            ->filterColumn('end_date', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date');
                $query->whereRaw("DATE_FORMAT(end_date,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            
            ->rawColumns(['action','project_status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Project $model): QueryBuilder
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
                    ->setTableId('project-table')
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
      
        $columns[] = Column::make('name')->title(trans('cruds.project.fields.name'));
        $columns[] = Column::make('projectLead.name')->title(trans('cruds.project.fields.project_lead'));
        $columns[] = Column::make('start_date')->title(trans('cruds.project.fields.start_date'));
        $columns[] = Column::make('end_date')->title(trans('cruds.project.fields.end_date'));
        $columns[] = Column::make('project_status')->title(trans('cruds.project.fields.project_status'));
        $columns[] = Column::make('created_at')->title(trans('cruds.project.fields.created_at'))->addClass('dt-created_at');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(200)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Technologies' . date('YmdHis');
    }
}
