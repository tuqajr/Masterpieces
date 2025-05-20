<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('styles')
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        {{-- Navigation --}}
        {{-- @include('layouts.navigation') --}}
        
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            <div class="max-w-7xl mx-auto py-2 px-4">
                @if(session('success'))
                    <script>
                        Swal.fire({
                            title: "{{ session('success') }}",
                            icon: "success",
                            draggable: true,
                            confirmButtonColor: '#3085d6'
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        Swal.fire({
                            title: "{{ session('error') }}",
                            icon: "error",
                            draggable: true,
                            confirmButtonColor: '#d33'
                        });
                    </script>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>