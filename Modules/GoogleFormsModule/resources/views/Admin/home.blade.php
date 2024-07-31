    @extends('main.app')
    @section('title')
    Home | Quiz App
    @endsection

    @section('css')
    @endsection

    @section('content')
    <div class="staff-management">
        <section class="sortContainer row justify-content-around g-" id="sortable-list">
            <div class="col-lg-4">
                <x-googleformsmodule::tap-card href="{{ route('teachers') }}" title="{{ __('Teachers') }}"
                    description=" Admins can view, edit, create, and delete teacher profiles. Review quizzes created by each teacher and the students assigned to them.">
                    <i class="fa-solid fa-chalkboard-teacher fa-xl"></i>
                    <span class="d-block text-900 fw-normal mb-0 fs-1">{{ $teachers }}</span>

                </x-googleformsmodule::tap-card>
            </div>

            <div class="col-lg-4">
                <x-googleformsmodule::tap-card href="{{ route('students') }}" title="{{ __('Students') }}"
                    description="View all quizzes created by teachers. Admins can see which students answered each quiz and delete quizzes as needed.">
                    <i class="fa-solid fa-user fa-xl"></i>
                    <span class="d-block text-900 fw-normal mb-0 fs-1">{{ $students }}</span>
                </x-googleformsmodule::tap-card>
            </div>


            <div class="col-lg-4">
                <x-googleformsmodule::tap-card href="#" title="{{ __('Forms') }}"
                    description="View all quizzes created by teachers. Admins can see which students answered each quiz and delete quizzes as needed.">
                    <i class="fa-solid fa-file-alt fa-xl"></i>
                    <span class="d-block text-900 fw-normal mb-0 fs-1">{{ $forms }}</span>

                </x-googleformsmodule::tap-card>
            </div>


        </section>
    </div>
    @endsection
