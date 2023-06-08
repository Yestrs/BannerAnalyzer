<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Banner Analyzer - Privacy Policy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



    <!-- Scripts -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900  flex flex-col items-center mt-6 ml-16 mr-16">


        <section class="flex flex-col items-center">
            <h1 class="m-4 text-3xl text-gray-300">Demonstration</h1>
        </section>

        <video controls class="w-75" type="video/mkv" src="{{ url('/img/demo.mkv') }}"></video>





    </div>
    @include('layouts.footer')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
