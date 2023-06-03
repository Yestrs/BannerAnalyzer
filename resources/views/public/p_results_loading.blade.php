<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Banner Analyzer - Results</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 mt-6 flex flex-col items-center mt-6">

        {{-- <pre class="text-white">{{ print_r($obj->image_urls_test) }}</pre> --}}
        <div id="responseContainer" class="text-white"></div>


        <div class="absolute top-1/2 left-1/2 -mt-4 -ml-2 h-8 w-4 text-indigo-700">
            <div class="absolute z-10 -ml-2 h-8 w-8 animate-bounce">
              <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin" fill="currentColor" stroke="currentColor" stroke-width="0" viewBox="0 0 16 16">
                <path d="M8 0c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zM8 4c2.209 0 4 1.791 4 4s-1.791 4-4 4-4-1.791-4-4 1.791-4 4-4zM12.773 12.773c-1.275 1.275-2.97 1.977-4.773 1.977s-3.498-0.702-4.773-1.977-1.977-2.97-1.977-4.773c0-1.803 0.702-3.498 1.977-4.773l1.061 1.061c0 0 0 0 0 0-2.047 2.047-2.047 5.378 0 7.425 0.992 0.992 2.31 1.538 3.712 1.538s2.721-0.546 3.712-1.538c2.047-2.047 2.047-5.378 0-7.425l1.061-1.061c1.275 1.275 1.977 2.97 1.977 4.773s-0.702 3.498-1.977 4.773z"></path>
              </svg>
            </div>
            <div class="absolute top-4 h-5 w-4 animate-bounce border-l-2 border-gray-200" style="rotate: -90deg"></div>
            <div class="absolute top-4 h-5 w-4 animate-bounce border-r-2 border-gray-200" style="rotate: 90deg"></div>
          </div>


        <div id="form_submited">
            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Analyzing your website:</h2>
            <ul class="max-w-md space-y-2 text-gray-500 list-inside dark:text-gray-400">
                <li class="flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Getting website headers
                </li>
                <li class="flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Getting all images and banners
                </li>
                <li class="flex items-center">
                    <div role="status">
                        <svg aria-hidden="true"
                            class="w-5 h-5 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    Analyzing images and banners, could take a while if there are a lot of images and banners
                </li>
            </ul>
        </div>





        <script>
            function executeController() {
                var queryString = window.location.search;

                // Create a URLSearchParams object from the query string
                var searchParams = new URLSearchParams(queryString);

                // Get the value of the 'url' parameter
                var encodedUrl = searchParams.get('url');

                // Decode the URL parameter
                var decodedUrl = decodeURIComponent(encodedUrl);

                var domain = decodedUrl;
                $.ajax({
                    url: '/results_waiting_website',
                    type: 'GET',
                    data: {
                        domain: domain
                    }, // Pass the 'domain' value as a query parameter
                    success: function(response) {
                        window.location.href = '/results/' + response;
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }

            setInterval(executeController, 1000);
        </script>






    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
