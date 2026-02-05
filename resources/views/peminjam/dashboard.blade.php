<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body>
    <h1 class="text-3xl font-bold underline text-red-700">
        ini halaman dashboar peminjam
    </h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
            Logout
        </button>
    </form>

</body>

</html>
