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

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center mt-6 ml-16 mr-16">

        
        <section class="flex flex-col items-center">
            <h1 class="m-4 text-3xl text-gray-300">About BannerAnalyzer</h1>
            <div id="accordion-open" data-accordion="open" class="w-3/4">
                <h2 id="accordion-open-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                        aria-controls="accordion-open-body-1">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>What is Banner Analyzer?</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Banner Analyzer for production is a useful tool
                            for developers that allows them
                            to measure the performance of a website when a URL is provided.
                            This tool helps developers to evaluate how well a website is performing in terms of its
                            speed,
                            page load times, and other performance metrics.
                        </p>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Banner Analyzer for production is a useful tool
                            for developers that allows them to measure the performance of a website when a URL is
                            provided. This tool helps developers
                            to evaluate how well a website is performing in terms of its speed, page load times, and
                            other performance metrics.
                            Banner Analyzer for production typically works by analyzing the HTTP requests made by a
                            website when a user visits it.
                            It then provides developers with detailed information about the various components that make
                            up the website, including images, scripts,
                            and other resources. This information can be used to identify performance bottlenecks and to
                            optimize the website for better performance.
                        </p>
                    </div>
                </div>
                <h2 id="accordion-open-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-open-body-2" aria-expanded="false"
                        aria-controls="accordion-open-body-2">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>How does Banner Analyzer work?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Banner Analyzer works by analyzing the various
                            components
                            of a website and providing detailed information about their performance.
                            When a user provides a URL to the tool,
                            it makes a request to the website's server and retrieves all of the resources that make up
                            the page,
                            including images, scripts, stylesheets, and other files.
                            The tool then analyzes each of these resources to determine their size,
                            load time, and other performance metrics. It also examines the HTTP response codes,
                            cache headers, and other network-related factors that can impact performance.</p>

                    </div>
                </div>
                <h2 id="accordion-open-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-open-body-3" aria-expanded="false"
                        aria-controls="accordion-open-body-3">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>What is the difference between SEO analyzers and Banner Analyzer?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-open-body-3" class="hidden" aria-labelledby="accordion-open-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">This is compleatly free software witch is
                            wrote for everyone,
                            but we specialy target developers that are coding websites to let them improve their website
                            loading speed and give them some advice</p>
                    </div>
                </div>
            </div>

        </section>


        <section class="p-12">
            <h2 class="m-4 text-3xl text-gray-300">Latest system updates</h2>
            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                <li class="mb-10 ml-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">May 09
                        2023</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">LeaderBoard
                    </h3>
                    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Added leaderboard for public user view, now they can see top 3 and overall max top 100 searched websites full url performance results of that site.</p>
                </li>
                <li class="mb-10 ml-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">May 05
                        2023</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Results page visual and backend fixes and improvements.
                    </h3>
                    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Added some visual changes to results page and brought more statistics and error handling for protected pages.</p>
                </li>
                <li class="mb-10 ml-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">April 10
                        2023</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Major admin panel and results
                        updates
                    </h3>
                    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Admins now have access to
                        give other users admin permissions, delete comments, ban, unban users and much more</p>
                </li>
                <li class="mb-10 ml-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">March
                        20</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Major client UI updates</h3>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Updated client UI from Bootsrap
                        to TailwindCSS for better development process</p>
                </li>
                <li class="ml-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">March
                        01</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Started working on this project
                    </h3>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Made Github, autorunner for main
                        server to automaticly push any commits straight to production <a
                            href="http://banneranalyzer.com">http://banneranalyzer.com</a></p>
                </li>
            </ol>

        </section>


        <section class="flex px-4 py-3 text-white bg-gray-900 my-8 mx-16 flex-col items-center rounded-xl">
            <h1 class="m-4 text-5xl text-gray-300">Top rated comments</h1>
            <p class="m-2 text-lg text-gray-300 text-center w-2/3 mb-12">See who is recomending our services</p>
            @foreach ($comments as $comment)
                <article class="bg-gray-800 p-6 rounded-xl mb-4 min-w-full">
                    <div class="flex items-center mb-4 space-x-4">
                        <div class="space-y-1 font-medium dark:text-white">
                            @php
                                $user = App\Models\User::find($comment->user_id);
                            @endphp

                            <p>{{ $user->username }} -> {{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-1">
                        @for ($i = 0; $i < $comment->stars; $i++)
                            <x-star-svg></x-star-svg>
                        @endfor


                    </div>
                    <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                        <p>Time posted - {{ $comment->created_at }}</p>
                    </footer>
                    <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $comment->comment }}</p>
                </article>
            @endforeach
        </section>







    </div>
    @include('layouts.footer')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
