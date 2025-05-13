<?php

namespace App\Domains\Admin\Technology\DataTables;

use App\Domains\Admin\Technology\Models\Technology;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Str;

class TechnologyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('technologies.*')))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));
            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })

            ->editColumn('technology_type', function($record){
                return $record->technology_type ? config('constant.technology_types')[$record->technology_type] : '';
            })

            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('technology_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('technologies.show',$record->id).'" class="btn btn-outline-info btn-sm btnViewTechnology" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('technology_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('technologies.edit',$record->id).'" class="btn btn-outline-success btn-sm btnEditTechnology" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('technology_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteTechnologyBtn" data-href="'.route('technologies.destroy', $record->id).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                }
                return $actionHtml;
            })
            ->setRowId('id')

            ->filterColumn('created_at', function ($query, $keyword) {
                $searchDateFormat = config('constant.search_date_format.date_time');
                $query->whereRaw("DATE_FORMAT(created_at,'$searchDateFormat') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('status', function ($query, $keyword) {
                $statusSearch  = null;
                if (Str::contains('active', strtolower($keyword))) {
                        $statusSearch = 1;
                } else if (Str::contains('inactive', strtolower($keyword))) {
                        $statusSearch = 0;
                }
                $query->where('status', $statusSearch); 
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Technology $model): QueryBuilder
    {         
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 4;        
        return $this->builder()
                    ->setTableId('technology-table')
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
      
        $columns[] = Column::make('name')->title(trans('cruds.technology.fields.name'));
        $columns[] = Column::make('technology_type')->title(trans('cruds.technology.fields.technology_type'));
        $columns[] = Column::make('description')->title(trans('cruds.technology.fields.description'));
        $columns[] = Column::make('created_at')->title(trans('cruds.technology.fields.created_at'))->addClass('dt-created_at');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

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
