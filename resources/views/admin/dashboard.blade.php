<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body>
    <h1 class="text-3xl font-bold underline text-red-700">
        Hello world!
    </h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
            Logout
        </button>

        <div class="items-center grid grid-cols-3 p-2">

            <div class="bg-primary px-2 py-3 m-4">
                <p>ini card 1</p>
            </div>
            <div class="bg-secondary m-4">
                <p>ini card 1</p>
            </div>
            <div class="bg-tertiary m-4">
                <p>ini card 1</p>
            </div>
        </div>
    </form>

</body>

</html>
