<?php

namespace App\Domains\Admin\User\DataTables;

use App\Domains\Admin\User\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Support\Str;

class UserDataTable extends DataTable
{
    public $customPageLength = 10;
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('users.*')))
            ->addIndexColumn()

            ->editColumn('created_at', function($record) {
                return $record->created_at->format(config('constant.date_format.date_time'));
            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })


            ->editColumn('status', function($record){
                $checkedStatus = '';
                if($record->status == 'active'){
                    $checkedStatus = 'checked';
                }
                return '<div class="checkbox switch">
                    <label>
                        <input type="checkbox" class="switch-control user_status_cb" '.$checkedStatus.' data-user_id="'.($record->uuid).'" />
                        <span class="switch-label"></span>
                    </label>
                </div>';
            })
            
            ->addColumn('action', function($record){
                $actionHtml = '';
               if (Gate::check('user_view')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('users.show',$record->uuid).'" class="btn btn-outline-info btn-sm btnViewUser" title="Show"> <i class="ri-eye-line"></i> </a>';
                }

                if (Gate::check('user_edit')) {
                    $actionHtml .= '<a href="javascript:void(0);" data-href="'.route('users.edit',$record->uuid).'" class="btn btn-outline-success btn-sm btnEditUser" title="Edit"> <i class="ri-edit-2-line"></i> </a>';
                }
                
                if (Gate::check('user_delete')) {
                    $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deleteUserBtn" data-href="'.route('users.destroy', $record->uuid).'" title="Delete"><i class="ri-delete-bin-line"></i></a>';
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
    public function query(User $model): QueryBuilder
    {         
        return $model->whereHas('roles', function($q) {
            $q->where('id', config('constant.roles.user'));
        })->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 4;        
        $pagination = PaginationSettings('user_pagination');
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
      
        $columns[] = Column::make('name')->title(trans('cruds.user.fields.name'));
        $columns[] = Column::make('email')->title(trans('cruds.user.fields.type'));
        $columns[] = Column::make('status')->title(trans('cruds.user.fields.status'));
        $columns[] = Column::make('created_at')->title(trans('cruds.user.fields.created_at'))->addClass('dt-created_at');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
