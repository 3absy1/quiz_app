@extends('main.app')
@section('title')
    Students | Quiz App
@endsection

@section('css')
@endsection

@section('content')
    <section class="table-sec pt-3">
        <div class="container px-2 px-md-5">
            <div class="align-items-start border-bottom flex-column">
                <x-googleformsmodule::first-head label="Student table" icon="table" />
                {{-- <button class="btn-primary btn  border"
            type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Create</button>
            <x-googleformsmodule::modal modalId="exampleModal" formAction="{{ route('teacher.create') }}"
                formMethod="POST" modalTitle="Create Teacher">
                <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="code"> Email </label>
                <input class="form-control" id="email" type="email" name="email" placeholder="admin@gmail.com" required />
                <br>
                <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle"> Name </label>
                <input class="form-control" id="adminTitle" name="name" type="text" placeholder="Ahmed"
                    required />
                <br>
                <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="password"> Password </label>
                <input class="form-control" id="password" name="password" type="password" placeholder=""
                    required />
                <br>
            </x-googleformsmodule::modal> --}}
                <div class="d-flex align-items-center">
                    <form action="{{ route('students.export') }}" method="GET" class="me-3">
                        <button class="btn btn-success" type="submit" data-bs-dismiss="modal">Export All</button>
                    </form>
                    <div class="btn btn-success exportSelected rounded-1" data-bs-toggle="modal" id="excelModalBtn"
                        name="export" data-exportFormat="excel" data-bs-target="#exportModal">Excel Selected <span
                            id="count">0</span> </div>
                </div>

                <br>
            </div>
            <div class="card">
                <div class="container">
                    <div class="card-body">

                        @foreach ($students as $student)
                            {{-- <x-googleformsmodule::modal  modalId="editModal{{ $student->id }}"
                        formAction="{{ route('student.update', ['id' => $student->id]) }}" formMethod="POST" modalTitle="Edit Name">
                        @method('PUT')
                        <div class="modal-body">
                            <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">
                                Email </label>
                            <input class="form-control" id="email" type="text" name="email"
                                value="{{ $student->email }}" />
                            <input type="hidden" class="form-control" name="id" value="{{ $student->id }}">

                            <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">
                                Name </label>
                            <input class="form-control" id="adminTitle" name="name" type="text"
                                value="{{ $student->name }}" />
                            <br>
                        </div>
                    </x-googleformsmodule::modal> --}}
                            <x-googleformsmodule::modal modalId="deleteModal{{ $student->id }}"
                                formAction="{{ route('student.delete', $student->id) }}" formMethod="POST"
                                modalTitle="Delete {{ $student->name }}">
                                @method('DELETE')
                                <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">
                                    Are
                                    You Sure ? </label>
                            </x-googleformsmodule::modal>
                        @endforeach
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
                        <form id="exportModalForm" method="GET" action="{{ route('students.selectedExport') }}">
                            @csrf
                            {{-- <div class="modal-body export-modal row justify-content-around"> --}}
                            <!-- Hidden input fields for additional data -->
                            <input type="hidden" id="exportFormatInput" name="exportFormat">
                            <input type="hidden" id="selectedColumnsInput" name="selectedColumns">
                            <input type="hidden" id="SelectedRows" name="SelectedRows">

                            {{-- </div> --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Close</button>
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
        $(document).on('click', '.editStudent', function() {
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
        $('#user_answers_table').on('page.dt', function() {
            $('.selected-item').text(window.LaravelDataTables['user_answers_table'].rows({
                selected: true
            }).count());
            $('.selected-badge').text(window.LaravelDataTables['user_answers_table'].rows({
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
                            window.LaravelDataTables['user_answers_table'].columns(index +
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

        $(document).on('click', '.exportSelected', function() {
            let SelectedRows = JSON.parse(localStorage.getItem('user_answers_checkBoxIdsArray'));
            $("#SelectedRows").val(SelectedRows);
        });
        $(document).on("click", "#sendRequestBtn", function() {
            let selectedColumns = getCheckedCheckboxes();
            $("#exportFormatInput").val(exportFormat);
            $("#selectedColumnsInput").val(selectedColumns);
            $("#exportModalForm").submit();
        });

        $(document).on('click','.dt-select-checkbox',()=>{
        const countEl = $('#count')
        const SelectedRowsLength = JSON.parse(localStorage.getItem('user_answers_checkBoxIdsArray')).length;
        countEl.text(SelectedRowsLength)
    })
    </script>
    {!! str_replace(
        '"DataTable.render.select()"',
        'DataTable.render.select()',
        $dataTable->scripts(attributes: ['type' => 'module']),
    ) !!}

    {{-- Generating Link Request --}}
@endsection
