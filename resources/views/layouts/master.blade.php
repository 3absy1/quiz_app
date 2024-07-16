<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body>

    

        @include('layouts.side-overlay')

        @include('layouts.sidebar')

        @include('layouts.header')

        {{-- start of content --}}

        @yield('content')

        {{-- start of content --}}




        @include('layouts.footer')


    @include('layouts.scripts')
</body>

</html>
