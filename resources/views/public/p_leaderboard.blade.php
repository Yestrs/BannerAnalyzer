<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Banner Analyzer - About</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



    <!-- Scripts -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center mt-6 ml-16 mr-16 text-white">
        <h1 class="m-4 text-5xl text-center text-gray-300">TOP 3</h1>
        <p class="m-2 text-lg text-center text-gray-300 text-center w-2/3">
        Top 3 currently rated website performance
        </p>

        
        <div class="py-12">
         
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4">
                
                <a href="#" class="block text-center -translate-y-4 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TOP 2</h5>
                    <h6 class="mb-2 text-1xl font-bold tracking-tight text-gray-800 dark:text-white">Points - {{ $obj->top_3[1]['data']->points }}</h6>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ $obj->top_3[1]['data']->name }}</p>
                </a>
                <a href="#" class="block text-center -translate-y-8 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TOP 1</h5>
                    <h6 class="mb-2 text-1xl font-bold tracking-tight text-gray-800 dark:text-white">Points - {{ $obj->top_3[0]['data']->points }}</h6>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ $obj->top_3[0]['data']->name }}</p>
                </a>
                <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TOP 3</h5>
                    <h6 class="mb-2 text-1xl font-bold tracking-tight text-gray-800 dark:text-white">Points - {{ $obj->top_3[2]['data']->points }}</h6>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ $obj->top_3[2]['data']->name }}</p>
                </a>
            </div>
        </div>



        <h2 class="m-4 text-5xl text-center text-gray-300">TOP 10</h1>
        <p class="m-2 text-lg text-center text-gray-300 text-center w-2/3">
        Top 10 currently rated website performance
        </p>

        <div class="relative w-2/3 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Url</th>
                    <th scope="col" class="px-6 py-3">Times Searched</th>
                    <th scope="col" class="px-6 py-3">Points</th>
                </thead>
                <tbody>
                    @foreach ($obj->top as $website['data'])
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $website['data']->name }}</td>
                            <td class="px-6 py-4">{{ $website['data']->domain }}</td>
                            <td class="px-6 py-4">{{ $website['data']->search_times }}</td>
                            <td class="px-6 py-4">{{ $website['data']->points }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="place-self-center p-6">
                {!! $obj->top->links() !!}
            </div>
        </div>



        {{-- <pre class="text-white"> {{ print_r($obj->top_3[0]['data']) }}</pre> --}}

        

    </div>
    @include('layouts.footer')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
