<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



    <!-- Scripts -->
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex px-4 py-3 text-white bg-gray-900 my-8 mx-16 flex-col items-center rounded-xl">
                <h1 class="m-4 text-5xl text-gray-300">Results of DOMAIN</h1>
                <p class="m-2 text-lg text-gray-300">desc of what kind of results are showed</p>
                <p class="m-2 text-lg text-gray-300"><pre><?php echo print_r($obj); ?></pre></p>
            </div>
        </div>








        @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
