@extends('main.app')
@section('title')
Forms | Quiz App
@endsection

@section('css')
{{-- @vite(['Modules/GoogleFormsModule/resources/src/main.js']) --}}
<style>
iframe {
    display:block;
    width:100%;
    height:100%;
  }
  </style>
@endsection

@section('content')

<section class="table-sec pt-3">
    <div class="container px-2 px-md-5">
        <div class="align-items-start border-bottom flex-column">
            <x-googleformsmodule::first-head label="Form table" icon="table" />
            <x-googleformsmodule::createModal modalId="exampleModal" formMethod="POST" modalTitle="Create Form">
                <iframe src=" {{url('/googleformsmodule/admin/')}}/{{$id}}" frameborder="0" id="modalFrame">
                </iframe>
            </x-googleformsmodule::createModal>

            <div class="d-flex align-items-center">
                <button class="btn-primary btn border me-3" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Create</button>

                @if(empty(implode(',', $formsId)))

                @else
                <form action="{{ route('forms.export', ['ids' => implode(',', $formsId)]) }}" method="GET" class="me-3">
                    <button class="btn btn-success" type="submit" data-bs-dismiss="modal">Export All</button>

                </form>
                    @endif
                <div class="btn btn-success exportSelected rounded-1 hide" data-bs-toggle="modal" id="excelModalBtn" name="export" data-exportFormat="excel" data-bs-target="#exportModal">Excel Selected <span id="count">0</span> </div>
            </div>
            <br>
        </div>
        <div class="card">
            <div class="container">
                <div class="card-body">

                    {{-- @foreach ($teachers as $teacher) --}}
                    {{-- <x-googleformsmodule::modal modalId="editModal{{ $teacher->id }}" formAction="{{ route('teacher.update', ['id' => $teacher->id]) }}" formMethod="POST" modalTitle="Edit Name">
                        @method('PUT')
                        <div class="modal-body">
                            <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">Email</label>
                            <input class="form-control" id="email" type="text" name="email" value="{{ $teacher->email }}" />
                            <input type="hidden" class="form-control" name="id" value="{{ $teacher->id }}">
                            <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">Name</label>
                            <input class="form-control" id="adminTitle" name="name" type="text" value="{{ $teacher->name }}" />
                            <br>
                        </div>
                    </x-googleformsmodule::modal>--}}
                    {{-- <x-googleformsmodule::modal modalId="deleteModal{{ $teacher->id }}" formAction="{{ route('teacher.delete', $teacher->id) }}" formMethod="POST" modalTitle="Delete {{ $teacher->name }}">
                        @method('DELETE')
                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">Are You Sure?</label>
                    </x-googleformsmodule::modal> --}}
                    {{-- @endforeach --}}
                    {{ $dataTable->table(['class' => 'table  table-striped table-bordered table-sm fs--1 mb-0']) }}
                </div>
            </div>
        </div>
                        <!-- modal for export-->
                        <div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title " id="exampleModalLabel">Export Selected Data</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="exportModalForm"  method="GET" action="{{ route('forms.selectedExport') }}">
                                        @csrf
                                        {{-- <div class="modal-body export-modal row justify-content-around"> --}}
                                            <!-- Hidden input fields for additional data -->
                                            <input type="hidden" id="exportFormatInput" name="exportFormat">
                                            <input type="hidden" id="selectedColumnsInput" name="selectedColumns">
                                            <input type="hidden" id="SelectedRows" name="SelectedRows">

                                        {{-- </div> --}}
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal"
                                                id="sendRequestBtn">Export</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end modal -->
</section>
<script>
    $(document).ready(function() {
        $('#userAccessTable').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": true,
            "info": true,
            "autoWidth": false,
            "searching": true,
            "ordering": true
        });
    });
</script>
    <script>
        $(document).on('click', '.editForm', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/reference/' + id + '/edit',
                method: 'GET',
                success: function(response) {
                    // Populate the modal fields with the response data
                    $('#code' + id).val(response.code);
                    $('#adminTitle' + id).val(response.name);
                    $('#editModal' + id).modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection

@section('js')

<script>
    setTimeout(() => {
        const modalFrame = document.getElementById('modalFrame')
        const iframeDoc = modalFrame.contentDocument || modalFrame.contentWindow.document;
        const buttons = iframeDoc.querySelectorAll('button')
        const sendBtn = iframeDoc.querySelector('button')
        sendBtn.addEventListener("click", () => {
            window.location.reload();
        });
    }, 3000);
</script>

<script>
var columnTitleArr = window.columnTitleArr = [];

window.createExportModalElements = function() {
    const exportModal = document.querySelector('.export-modal');

    columnTitleArr.forEach(element => {
        const div = document.createElement('div');
        div.classList.add('form-check');
        div.classList.add('col-5');

        const input = document.createElement('input');
        input.classList.add('form-check-input');
        input.type = 'checkbox';
        input.id = element;
        input.value = element;

        const label = document.createElement('label');
        label.classList.add('form-check-label');
        label.setAttribute('for', element);
        label.textContent = element;

        div.appendChild(input);
        div.appendChild(label);

        exportModal.appendChild(div);
    });
}
$('#forms_table').on('page.dt', function() {
    $('.selected-item').text(window.LaravelDataTables['forms_table'].rows({
        selected: true
    }).count());
    $('.selected-badge').text(window.LaravelDataTables['forms_table'].rows({
        selected: true
    }).count());
});

var arrOfFilterBtn = [];
var searchValues = [];


// Select all th elements inside the thead of the table and skip the first two
$('.useDataTable thead tr th').slice(1, -1).each(function(index) {
    var id = 'checkbox_' + index;
    // Get the inner text of the th element and push it to thTextArray
    arrOfFilterBtn.push({
        text: () => {
            return `<div class="d-flex align-items-center"> <input class="me-2" id="${id}" type="checkbox">
    <label for=""${id}"">  ${$(this).text()}  <label>

    </div>`
        },
        action: function(e, dt, node, config, cb) {
            var buttonElement = $(this.node());
            $('#' + id).prop('checked', function(_, oldProp) {
                if (oldProp) {
                    window.LaravelDataTables['forms_table'].columns(index +
                        2).search(
                        "").draw();
                    searchValues = searchValues.filter(item => item.Column_No !==
                        index + 2);
                }
                return !oldProp;
            });
        }
    });
});
function getCheckedCheckboxes() {
        const exportModal = document.querySelector('.export-modal');
        const checkboxes = exportModal.querySelectorAll('.form-check-input');
        const checkedCheckboxes = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedCheckboxes.push(checkbox.value);
            }
        });
        return checkedCheckboxes;
    }

    let exportFormat;
    $(document).on("click", "#excelModalBtn", function() {
        exportFormat = $(this).data("exportformat");
    });

    $(document).on("click", "#pdfModalBtn", function() {
        exportFormat = $(this).data("exportformat");
    });

    $(document).on("click", "#csvModalBtn", function() {
        exportFormat = $(this).data("exportformat");
    });

    $(document).on('click','.exportSelected',function() {
        let SelectedRows = JSON.parse(localStorage.getItem('forms_checkBoxIdsArray'));
        $("#SelectedRows").val(SelectedRows);
    });
    $(document).on("click", "#sendRequestBtn", function() {
        let selectedColumns = getCheckedCheckboxes();
        $("#exportFormatInput").val(exportFormat);
        $("#selectedColumnsInput").val(selectedColumns);
        $("#exportModalForm").submit();
    });


    $(document).on('click','.dt-select-checkbox',()=>{
        const selectAllCheckbox = $('#select-all');
        const countEl = $('#count')
        const btnEl = $('#excelModalBtn')

        const SelectedRowsLength = JSON.parse(localStorage.getItem('forms_checkBoxIdsArray')).length;
        countEl.text(SelectedRowsLength)
               // handling visbility of export btn
            if (SelectedRowsLength>0) {
            btnEl.removeClass('hide')
        } else {
            btnEl.addClass('hide')

        }

        if (SelectedRowsLength < window.LaravelDataTables['forms_table'].rows({ search: 'applied' }).nodes().length) {
            selectAllCheckbox.prop('checked', false);
        } else if(SelectedRowsLength == window.LaravelDataTables['forms_table'].rows({ search: 'applied' }).nodes().length){
            selectAllCheckbox.prop('checked', true);
        }
    });


    $(document).on('click','.dt-select-all-checkbox',()=>{
        const countEl = $('#count')
        const btnEl = $('#excelModalBtn')
        const SelectedRowsLength = JSON.parse(localStorage.getItem('forms_checkBoxIdsArray')).length;
        countEl.text(SelectedRowsLength)
                  // handling visbility of export btn
                if (SelectedRowsLength>0) {
            btnEl.removeClass('hide')
        } else {
            btnEl.addClass('hide')

        }
    });
</script>




{!! str_replace(
'"DataTable.render.select()"',
'DataTable.render.select()',
$dataTable->scripts(attributes: ['type' => 'module']),
) !!}

{{-- Generating Link Request --}}
@endsection
