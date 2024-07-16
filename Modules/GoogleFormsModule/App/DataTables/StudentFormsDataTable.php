<?php

namespace Modules\GoogleFormsModule\App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\GoogleFormsModule\App\Models\UserAnswer;

class StudentFormsDataTable extends DataTable
{
    protected $userAnswers;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($model) {
                $html = '<div class="font-sans-serif btn-reveal-trigger position-static">
        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
        type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
            <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
        </button>
         <div class="dropdown-menu dropdown-menu-end py-2">';
        //  $html .= '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal' . $model->id . '" data-id="' . $model->id . '" class="dropdown-item editStudent">Edit</a>';
         $html .= '<a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' . $model->id . '" data-id="' . $model->id . '" class="dropdown-item deleteStudent">Delete</a>';
                //         /$html .= '<a href="#" data-bs-toggle="modal" data-bs-target="#generateLinkModal" data-id="' . $model->id . '" class="dropdown-item generateLink">Generate Link</a>';
                //         $html .= '<div class="dropdown-divider"></div><a href="#" class="dropdown-item text-danger delete-this-potential_account" data-id="' . $model->id . '" data-url="' . route('potential_account.destroy', ['potential_account' => $model]) . '">Delete</a></div></div>';
                $html .= '</div>';

                return $html;
            })

            ->editColumn('name', function ($model) {
                return $model->user_name ? $model->user_name : 'N/A';
            })
            ->editColumn('user_email', function ($model) {
                return $model->user_email ;
            })
            ->editColumn('degree', function ($model) {
                return $model->degree ? $model->degree : 'N/A';
            })
            ->editColumn('start_time', function ($model) {
                return $model->start_time ? $model->start_time : 'N/A';
            })
            ->editColumn('end_time', function ($model) {
                return $model->end_time ? $model->end_time : 'N/A';
            })
            ->editColumn('questions_count', function ($model) {
                return $model->questions_count ? $model->questions_count : 'N/A';
            })
            ->editColumn('right_answers_count', function ($model) {
                return $model->right_answers_count ? $model->right_answers_count : 'N/A';
            })
            ->editColumn('wrong_answers_count', function ($model) {
                return $model->wrong_answers_count ? $model->wrong_answers_count : 'N/A';
            })

            ->addColumn('', function ($model) {
                return;
            })

            ->rawColumns(['name','email','action'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserAnswer $model): QueryBuilder
    {
        $userAnswers = $this->userAnswers ? $this->userAnswers : $model->newQuery();
        return $model->newQuery()->whereIn('id', $userAnswers->pluck('id'));
    }

    /**
     * Accept the userAnswers data from the controller.
     */
    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                if ($k === 'userAnswers') {
                    $this->userAnswers = $v;
                }
            }
        } else {
            if ($key === 'userAnswers') {
                $this->userAnswers = $value;
            }
        }

        return $this;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $initCompleteFunction = "function() {
                        var checkBoxIds = new Set();
            window.LaravelDataTables['user_answers_table'].columns.adjust().draw();
            window.LaravelDataTables['user_answers_table'].on('select deselect',function(){
            var count = window.LaravelDataTables['user_answers_table'].rows({ selected: true }).count();
            $('.selected-item').text(count);
            $('.selected-badge').text(count);
            window.LaravelDataTables['user_answers_table'].button('copy:name').enable(count > 0);
            window.LaravelDataTables['user_answers_table'].button(2).enable(count > 0);
            window.LaravelDataTables['user_answers_table'].button('export:name').enable(count > 0);


            // Clear the set before updating
            checkBoxIds.clear();
            // Iterate over each selected row
            window.LaravelDataTables['user_answers_table'].rows({ selected: true }).every(function(rowIdx) {
                // Get the corresponding checkbox and check it
                var checkbox = $(this.node()).find('td:eq(0) input[type=\"checkbox\"]');
                checkbox.prop('checked', true);
                var checkBoxId = checkbox.prevObject[0].getAttribute('id');
                checkBoxIds.add(checkBoxId);
            });

            window.LaravelDataTables['user_answers_table'].rows({ selected: false }).every(function(rowIdx) {
                // Get the corresponding checkbox and check it
                var checkbox = $(this.node()).find('td:eq(0) input[type=\"checkbox\"]');
                checkbox.prop('checked', false);
                var checkBoxId = checkbox.prevObject[0].getAttribute('id');
                checkBoxIds.delete(checkBoxId);
            });
            var checkBoxIdsArray = Array.from(checkBoxIds); // Convert Set to array
            localStorage.setItem('user_answers_checkBoxIdsArray', JSON.stringify(checkBoxIdsArray))

                })
                // Iterate over each column in the table
                this.api().columns().every(function(colIdx) {
                    if (colIdx >= 1) {
                        var column = this;
                        // Get the title of each column and push it to columnTitleArr
                        window.columnTitleArr.push($(column.header()).text());
                    }
                });
                window.createExportModalElements();
        }";
        $arrOfFilterBtn = <<<'JS'
            function(){
                var arrOfFilterBtn = [];
                var searchValues = [];
                // Select all th elements inside the thead of the table and skip the first two
                    $('.useDataTable thead tr th').slice(1, -1).each(function (index) {
                        var id = 'checkbox_' + index;
                        // Get the inner text of the th element and push it to thTextArray
                        arrOfFilterBtn.push({
                            text: () => {
                                return `<div class="d-flex align-items-center"> <input class="me-2" id="${id}" type="checkbox">
                            <label for="${id}">${$(this).text()}</label></div>`;
                            },
                            action: function (e, dt, node, config, cb) {
                                var buttonElement = $(this.node());
                                $('#' + id).prop('checked', function (_, oldProp) {
                                    if (oldProp) {
            window.LaravelDataTables['user_answers_table'].columns(index + 1).search("").draw();
          searchValues = searchValues.filter(item=> item.Column_No !== index+1);
        }
                                    return !oldProp;
                                });
                            }
                        });
                    });

                // Add the button to console checked values
                arrOfFilterBtn.push({
                    text: function() {
                        return '<button class="btn btn-primary w-100 filterBtn" data-bs-toggle="modal" data-bs-target="#filterModal" >Filters</button>';
                    },
                    action: function(e, dt, node, config, cb) {
                        var checkedValues = [];
                        var columnIndex = [];
                        // Iterate over each checkbox and log its ID and checked state
                        $('.dt-bootstrap5 .row .col-md-auto.ms-auto .dt-buttons .btn-group:nth-child(2) .dropdown-menu .dt-button.dropdown-item span input[type="checkbox"]')
                            .each(function() {
                                checkedValues.push({
                                    id: $(this).attr('id'),
                                    checked: $(this).prop('checked')
                                });
                            });

                        const filterModal = document.querySelector('.filter-modal');
                        filterModal.innerHTML = '';
                        checkedValues.forEach((element, i) => {
                            if (element.checked) {
                                columnIndex.push(i + 1);
                                const div = document.createElement('div');
                                div.classList.add('filter-search');
                                div.classList.add('col-10');

                                const label = document.createElement('label');
                                label.classList.add('form-check-label', 'pt-2', 'pb-1');
                                label.setAttribute('for', columnTitleArr[i].toString().trim());
                                label.textContent = columnTitleArr[i].toString().trim();

                                const searchInput = document.createElement('input');
                                searchInput.classList.add('form-control');
                                searchInput.setAttribute('id', columnTitleArr[i].toString().trim());
                                searchInput.setAttribute('type', 'text');
                                searchInput.setAttribute('placeholder', columnTitleArr[i] + ' filter ');

                                div.appendChild(label);
                                div.appendChild(searchInput);

                                filterModal.appendChild(div);
                            } else {
                                // Handle else case if needed
                            }
                        });

                        $('.filter-modal input[type="text"]').on('input', function() {
                            // Get the column index from the input's id
                            const columnId = $(this).attr('id');
                            let filterIndex;
                            columnTitleArr.map((item, index) => {
                                if (item.toString().trim() === columnId) {
                                    filterIndex = index + 1;
                                }
                            });
                            // Get the search value from the input
                            const searchValue = $(this).val();
                            // Apply the filter to the datatable
                            window.LaravelDataTables['user_answers_table'].columns(filterIndex).search(searchValue).draw();
                        });
                    }
                });

                // Return arrOfFilterBtn
                return arrOfFilterBtn;
        }
        JS;



        return $this->builder()
            ->setTableId('user_answers_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength(100)
            //->dom('Bfrtip')
            ->orderBy(1, 'des')
            ->selectStyleSingle()
            /* ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]) */
            ->parameters([
                'initComplete' => $initCompleteFunction,
                "responsive" => [
                    'orderable' => false,
                    'details' => [
                        'target' => 0
                    ]
                ],
                "layout" => [
                    "top2Start" => [
                        "buttons" => [
                            // [
                            //     "extend" => 'collection',
                            //     "text" => 'Export All',
                            //     "name" => 'exportAll',
                            //     "className" => 'ms-1 exportAll rounded-1 mt-2',
                            //     "popoverTitle" => '<h5> Export All </h5>',
                            //     "buttons" => [
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"excelModalBtn\" data-exportFormat=\"excel\" data-bs-target=\"#exportModal\"> Excel</div>'
                            //                         }"
                            //         ],
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"pdfModalBtn\" data-exportFormat=\"pdf\" data-bs-target=\"#exportModal\">PDF</div>'
                            //                         }"
                            //         ],
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"csvModalBtn\" data-exportFormat=\"csv\" data-bs-target=\"#exportModal\"> CSV</div>'
                            //                         }"
                            //         ]
                            //     ]
                            // ],
                            // [
                            //     "extend" => 'copyHtml5',
                            //     "name" => 'copy',
                            //     "enabled" => false,
                            //     "text" => "function() {
                            //                     return '<span>Copy <span style=\"background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;  \" class=\"badge badge-primary  ms-3 selected-badge\">' +
                            //                         0 + '</span></span>';
                            //                 }",
                            //     "exportOptions" => [
                            //         "columns" => ':nth-child(n+3):not(:last-child):visible',
                            //         "modifier" => [
                            //             "selected" => true
                            //         ]
                            //     ],
                            //     "className" => 'ms-1  rounded-1 mt-2 '
                            // ],
                            // [
                            //     "extend" => 'print',
                            //     "name" => 'print',
                            //     "enabled" => false,
                            //     "text" => "function() {
                            //                     return '<span>Print <span style=\"background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;\"  class=\"badge badge-primary text-black ms-3 selected-badge\">' +
                            //                         0 + '</span></span>';
                            //                 }",
                            //     "exportOptions" => [
                            //         "columns" => ':nth-child(n+3):not(:last-child):visible',
                            //         "modifier" => [
                            //             "selected" => true
                            //         ]
                            //     ],
                            //     "className" => 'ms-1  rounded-1 mt-2'
                            // ],
                            // [
                            //     "text" => '<i class="fa fa-refresh " aria-hidden="true"></i>',
                            //     "action" => "function(e, dt, node, config) {
                            //                     window.LaravelDataTables['lead-account-table'].rows().deselect();
                            //                     window.LaravelDataTables['lead-account-table'].column(1).nodes().to$().find('input[type=\"checkbox\"]').prop('checked',
                            //                         false);

                            //                     dt.ajax.reload();
                            //                     window.LaravelDataTables['lead-account-table'].draw();
                            //                     window.location.reload();
                            //                 }",
                            //     "className" => 'ms-1  rounded-1 mt-2'
                            // ],
                            [
                                "extend" => 'colvis',
                                "popoverTitle" => '<h5> Column visibility </h5>',
                                "className" => 'ms-1  rounded-1 mt-2'
                            ]
                        ]
                    ],
                    "top2End" => [
                        "buttons" => [
                            // [
                            //     "extend" => 'collection',
                            //     "text" => 'Export Selected',
                            //     "name" => 'export',
                            //     "popoverTitle" => '<h5> Export Selected </h5>',
                            //     "className" => 'ms-1 exportSelected  rounded-1 mt-2',
                            //     "enabled" => false,
                            //     "buttons" => [
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"excelModalBtn\" data-exportFormat=\"excel\" data-bs-target=\"#exportModal\"> Excel</div>'
                            //                         }"
                            //         ],
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"pdfModalBtn\" data-exportFormat=\"pdf\" data-bs-target=\"#exportModal\">PDF</div>'
                            //                         }"
                            //         ],
                            //         [
                            //             "text" => "function() {
                            //                             return '<div data-bs-toggle=\"modal\" id=\"csvModalBtn\" data-exportFormat=\"csv\" data-bs-target=\"#exportModal\"> CSV</div>'
                            //                         }"
                            //         ]
                            //     ]
                            // ],
                            // [
                            //     "extend" => 'collection',
                            //     "text" => ' Filter',
                            //     "popoverTitle" => '<h5> Column Filter </h5>',
                            //     "className" => 'ms-1  rounded-1 mt-2  d-block ',
                            //     "buttons" => $arrOfFilterBtn
                            // ]
                        ]
                    ]
                ],
                "language" => [
                    "lengthMenu" => "Show _MENU_ ",
                    "searchPlaceholder" => "Users Search"
                ],
                "columnDefs" => [
                    [
                        "orderable" => false,
                        "render" => "DataTable.render.select()",
                        "targets" => 0,
                        "className" => 'select-checkbox',
                    ],
                    [
                        "orderable" => false,
                        "targets" => 0,
                    ]
                ],
                "select" => [
                    "style" => 'multi',
                    "selector" => 'input[type="checkbox"]',
                ],
                "stateSave" => true,
                "stateSaveParams" => "function(settings, data) {
                                                data.columns.map(item => {
                                                    item.search = '';
                                                });
                                                data.search.search = '';
                                            }",


                "fnDrawCallback" => "function( oSettings ) {
      $('.selected-item').text(window.LaravelDataTables['user_answers_table'].rows({ selected: true }).count());
      $('.selected-badge').text(window.LaravelDataTables['user_answers_table'].rows({ selected: true }).count());
    },lengthMenu: [
        [100,200],
        [100,200]
    ]",

            ]);;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('')->content('')->addClass('text-center')->searchable(false)->orderable(false),

            Column::make('id')->addClass('text-center'),
            Column::make('name')->addClass('text-center'),
            Column::make('user_email')->addClass('text-center'),
            Column::make('degree')->addClass('text-center'),
            Column::make('start_time')->addClass('text-center'),
            Column::make('end_time')->addClass('text-center'),
            Column::make('questions_count')->addClass('text-center'),
            Column::make('right_answers_count')->addClass('text-center'),
            Column::make('wrong_answers_count')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Students_' . date('YmdHis');
    }
}
