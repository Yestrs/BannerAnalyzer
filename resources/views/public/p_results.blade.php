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
    @include('layouts.navigation')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 mt-6 flex flex-col items-center mt-6">

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex px-4 py-3 text-white bg-gray-900 my-8 mx-16 flex-col items-center rounded-xl">
                <h1 class="m-4 text-5xl text-gray-300">Results of DOMAIN</h1>
                <p class="m-2 text-lg text-gray-300">desc of what kind of results are showed</p>
                <p class="m-2 text-lg text-gray-300"><pre><?php echo print_r($obj); ?></pre></p>
            </div>
        </div>

        <section class="w-1/2 my-4 flex flex-col items-center">
            <h1 class="m-4 text-3xl text-gray-300">Write your review</h1>
            <p class="m-2 text-lg text-gray-300 text-center w-2/3 mb-6">Write review about the results, for others to see</p>
            <form method="post" action="{{ route('comment.add') }}" class="mt-6 space-y-6 w-full flex flex-col items-center">
                @csrf
                @method('patch')
                <input type="hidden" name="url" value="<?= $obj->url ?>">
                <label for="stars" class="text-white">Rate from 1 to 5</label>
                <select name="stars" id="stars" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>
                
                <textarea required id="comment" name="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave your results review here ..."></textarea>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                
            </form>
        </section>
        





    </div>
        @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
