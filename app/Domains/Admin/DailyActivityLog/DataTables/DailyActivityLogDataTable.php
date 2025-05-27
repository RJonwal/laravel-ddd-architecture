<?php

namespace App\Domains\Admin\DailyActivityLog\DataTables;

use App\Domains\Admin\DailyActivityLog\Models\DailyActivityLog;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class DailyActivityLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('daily_activity_logs.*')->with(['project'])))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));

            })

            ->editColumn('project.name', function($record){
                return $record->project_id ? $record->project->name : '-';
            })

            ->editColumn('report_date', function($record){
                return $record->report_date ? $record->report_date->format(config('constant.date_format.date')) : '-';
            })


            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('daily_activity_log_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('daily-activity-logs.show',$record->uuid).'" class="btn btn-outline-info btn-sm btnViewDailyActivityLog" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('daily_activity_log_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('daily-activity-logs.edit',$record->uuid).'" class="btn btn-outline-success btn-sm btnEditDailyActivityLog" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('daily_activity_log_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteDailyActivityLogBtn" data-href="'.route('daily-activity-logs.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
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
    public function query(DailyActivityLog $model): QueryBuilder
    {         
        return $model->where('created_by', auth('web')->user()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 8;        
        return $this->builder()
                    ->setTableId('daily_activity_log-table')
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
      
        $columns[] = Column::make('project.name')->title(trans('cruds.daily_activity_log.fields.project_id'));
        $columns[] = Column::make('report_date')->title(trans('cruds.daily_activity_log.fields.report_date'));
        // $columns[] = Column::make('work_time')->title(trans('cruds.daily_activity_log.fields.work_time'));
        $columns[] = Column::make('created_at')->title(trans('cruds.daily_activity_log.fields.created_at'))->addClass('dt-created_at');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DailyActivityLogs' . date('YmdHis');
    }
}
