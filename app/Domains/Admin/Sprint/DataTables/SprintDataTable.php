<?php

namespace App\Domains\Admin\Sprint\DataTables;

use App\Domains\Admin\Sprint\Models\Sprint;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Str;

class SprintDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('sprints.*')->with(['project'])))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));
            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })

            ->editColumn('project.name', function($record){
                return $record->project ? $record->project->name : '-';
            })

            ->editColumn('milestone.name', function($record){
                return $record->milestone ? $record->milestone->name : '-';
            })

            ->editColumn('start_date', function($record){
                return $record->start_date->format(config('constant.date_format.date'));
            })

            ->editColumn('end_date', function($record){
                return $record->end_date->format(config('constant.date_format.date'));
            })
            ->editColumn('status', function($record) {
                $status = $record->status;
                $statusText = $status ? config('constant.sprint_status.' . $status, '') : '';
                if($statusText){
                    $colorClass = match($status) {
                        'initial'    => 'badge bg-danger',
                        'completed'  => 'badge bg-success',
                        'in_progress' => 'badge bg-warning text-dark',
                        'not_started' => 'badge bg-secondary',
                        'hold'        => 'badge bg-primary',
                    };
                    return '<span class="' . $colorClass . '">' . $statusText . '</span>';
                } else {
                    return '';
                }
            })

            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('sprint_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('sprints.show',$record->uuid).'" class="btn btn-outline-info btn-sm btnViewSprint" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('sprint_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('sprints.edit',$record->uuid).'" class="btn btn-outline-success btn-sm btnEditSprint" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('sprint_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteSprintBtn" data-href="'.route('sprints.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
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
    public function query(Sprint $model): QueryBuilder
    {         
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 7;
        $pagination = PaginationSettings('sprint_pagination');        
        return $this->builder()
                    ->setTableId('sprint-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
                    ->orderBy($orderByColumn)                    
                    ->selectStyleSingle()
                    ->lengthMenu($pagination['lengthMenu'])
                    ->parameters([
                        'pageLength' => $pagination['pageLength'],
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
      
        $columns[] = Column::make('name')->title(trans('cruds.sprint.fields.name'));
        $columns[] = Column::make('project.name')->title(trans('cruds.sprint.fields.project_id'));
        $columns[] = Column::make('milestone.name')->title(trans('cruds.sprint.fields.milestone_id'));
        $columns[] = Column::make('start_date')->title(trans('cruds.sprint.fields.start_date'));
        $columns[] = Column::make('end_date')->title(trans('cruds.sprint.fields.end_date'));
        $columns[] = Column::make('status')->title(trans('cruds.sprint.fields.status'));
        $columns[] = Column::make('created_at')->title(trans('cruds.sprint.fields.created_at'))->addClass('dt-created_at');
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sprints' . date('YmdHis');
    }
}
