@extends('layouts.master')

@section('body-content')
    <div id="app" class="main-container bg-gray-200">
        @include('layouts.sidebar')

        <div class="main-content">
            @include('layouts.navbar')

            <main class="inner-container h-full">
                @yield('content')

                
            </main>
        </div>

    </div>
@endsection
