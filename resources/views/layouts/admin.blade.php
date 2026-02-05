<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-900 overflow-x-hidden h-screen flex">

    <aside
        class="fixed inset-y-0 left-0 z-50 shadow-xl transition-all duration-300 xl:translate-x-0 -translate-x-full"
        id="sidebar">
        @include('components.AdminSidebar')
    </aside>

    <div class="flex-1 flex flex-col min-w-0 xl:ml-68 transition-all duration-300">

        <div class="absolute top-0 left-0 right-0 min-h-72 bg-primary"></div>

        <div class="sticky top-0 z-40 w-full px-2 pt-4">
            @include('components.AdminNavbar')
        </div>

        <main class="w-full px-6 py-6 relative">
            <div id="tw" class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <footer class="p-6 text-center text-sm text-slate-400">
            © 2026 **ARSA System**
        </footer>
    </div>

</body>

</html>
