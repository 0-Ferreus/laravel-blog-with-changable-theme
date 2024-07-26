<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  


    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css"> --}}
    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.sidebar')
        <div class="flex-grow bg-gray-100">
            @include('layouts.navigation')
        

        <!-- Page Heading -->

        <header class="bg-white border-t-4">
            <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl text-black">
                @yield('header')
            </div>
        </header>


        <!-- Page Content -->
        <main>
            <div class=" mx-auto py-6 sm:px-6">
                <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">




                        <div class="p-6 text-gray-900">
                            @yield('content')

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>
    @yield('scripts')
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@yield('scripts')

</html>
