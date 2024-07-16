    @extends('main.app')
    @section('title')
    Home | Quiz App
    @endsection

    @section('css')
    @endsection

    @section('content')
    <div class="staff-management">
        <section class="sortContainer row justify-content-around g-" id="sortable-list">
        <div class="list-item col-6">
            <div class="item-content bg-white  row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20"
                viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9" />
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9" />
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9" />
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9" />
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9" />
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9" />
            </svg>

            <div class="py-5">
                <span class="order">Teachers :</span>

                <span class="order">{{$teachers}}</span>
            </div>
            </div>
        </div>

        <div class="list-item col-6">
            <div class="item-content bg-white  row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20"
                viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9" />
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9" />
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9" />
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9" />
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9" />
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9" />
            </svg>
            <div class="py-5">
                <span class="order">Students :</span>

                <span class="order">{{$students}}</span>
            </div>
            </div>
        </div>


        <div class="list-item col-6">
            <div class="item-content bg-white  row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20"
                viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9" />
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9" />
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9" />
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9" />
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9" />
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9" />
            </svg>
            <div class="py-5">
                <span class="order">Forms :</span>

                <span class="order">{{$forms}}</span>
            </div>
            </div>
        </div>


        </section>
    </div>
    @endsection
