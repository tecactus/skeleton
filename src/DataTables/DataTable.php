<?php

namespace Tecactus\Skeleton\DataTables;

use Yajra\Datatables\Services\DataTable as YajraDataTable;
use Yajra\Datatables\Datatables;

class DataTable extends YajraDataTable
{
    protected $ajaxParameters = [];

    protected $lengthMenu = [10, 25, 50, 100];

    protected $pageLength = 10;

    protected $dom = 'Blfrtip';

    protected $order = [[0, 'desc']];

    protected $buttons = ['export', 'print', 'reset', 'reload', 'create'];

    protected $actionsView = 'skeleton::datatables.actions';

    protected $filename = 'archivo';

    protected $htmlParameters = [];

    protected $addColumns = [
        'action'
    ];

    protected $rawColumns = [];

    protected $editColumns = [];

    protected $modelClass;

    protected $jsAsyncApp = 'vueDataTableApp';

    protected $jsCreateButonAction = 'displayModal';

    protected $jsShowButonAction = 'loadRecord';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->setColumns( $this->datatables )->make(true);
    }

    /**
     * Set columns.
     * 
     * @param Datatables $datatables
     * @return Datatables
     */
    protected function setColumns(Datatables $datatables)
    {
        $datatables = $datatables
                        ->eloquent( $this->query() );
                        
        foreach ($this->addColumns as $column) {
            $fnName = 'add' . $this->parseColumnName($column) . 'Column';
            $ref = $this;
            $datatables = $datatables
                ->addColumn($column, function ($row) use ($fnName, $ref) { return call_user_func([$ref, $fnName], $row); });
        }

        foreach ($this->editColumns as $column) {
            $fnName = 'edit' . $this->parseColumnName($column) . 'Column';
            $ref = $this;
            $datatables = $datatables
                ->editColumn($column, function ($row) use ($fnName, $ref) { return call_user_func([$ref, $fnName], $row); });
        }

        $datatables = $datatables->rawColumns(array_merge(['action'], $this->rawColumns));

        return $datatables;
    }

    private function  parseColumnName($columnName)
    {
        $delimiter = '';

        \Log::info($columnName);

        if (str_contains($columnName, '.')) {
            $delimiter = '.';
        }
        if (str_contains($columnName, '_')) {
            $delimiter = '_';
        }

        if (empty($delimiter)) {
            return $columnName;
        }

        $words = explode($delimiter, $columnName);
        $words = array_map(function($word) { return ucwords($word); }, $words);
        return implode('', $words);
    }

    /**
     * Add Actions column.
     * 
     * @param Datatables $datatables
     * @return Datatables
     */
    public function addActionColumn($row)
    {
        if (! empty($this->jsCreateButonAction) && ! empty($this->jsAsyncApp)) {
            $jsShowButonAction = $this->getShowButonActionFunction();
            return (string) view($this->actionsView, compact('row', 'jsShowButonAction'));
        }
        return (string) view($this->actionsView, compact('row'));
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->getQuery();

        return $this->applyScopes($query);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function getQuery()
    {
        return $this->modelClass::select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        $builder = $this->builder()
                    ->columns($this->getColumns())
                    ->ajax($this->getAjaxParameters())
                    ->parameters($this->getHtmlParameters());

        if (! empty($this->jsCreateButonAction) && ! empty($this->jsAsyncApp)) {
            $builder->setTableAttribute(['data-js-create-function' => $this->getCreateButonActionFunction()]);
        }

        return $builder;
    }

    /**
     * Get jsAsyncApp.
     *
     * @return string
     */
    public function getJsAsyncApp()
    {
        return $this->jsAsyncApp;
    }

    /**
     * Get javascript object create function.
     *
     * @return string
     */
    protected function getCreateButonActionFunction()
    {
        return "window.{$this->jsAsyncApp}.{$this->jsCreateButonAction}";
    }

    /**
     * Get javascript object show function.
     *
     * @return string
     */
    protected function getShowButonActionFunction()
    {
        return "{$this->jsAsyncApp}.{$this->jsShowButonAction}";
    }

    /**
     * Get ajax parameters.
     *
     * @return array
     */
    protected function getAjaxParameters()
    {
        return array_merge(['url' => ''], $this->ajaxParameters);
    }

    /**
     * Get html parameters.
     *
     * @return array
     */
    protected function getHtmlParameters()
    {
        return array_merge([
            'dom'          => $this->dom,
            'order'        => $this->order,
            'buttons'      => $this->buttons,
            'lengthMenu'   => $this->lengthMenu,
            'pageLength'   => $this->pageLength,
            'initComplete' => "function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }",
        ], $this->htmlParameters);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (isset($this->displayColumns)) {
            return $this->displayColumns;
        } else {
            return [
                ['data' => 'id', 'name' => 'id', 'title' => 'id'],
                ['data' => 'name', 'name' => 'name', 'title' => 'nombre'],
                ['data' => 'action', 'name' => 'action', 'title' => 'acciones', 'orderable' => false, 'searchable' => false],
            ];
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return "{$this->filename}_" . time();
    }
}