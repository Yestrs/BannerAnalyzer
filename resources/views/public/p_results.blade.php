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

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 mt-6 flex flex-col items-center mt-6">

        {{-- <pre class="text-white">{{ print_r($obj->image_urls_test) }}</pre> --}}



        <div class="bg-gray-100 dark:bg-gray-900">
            <div class="flex px-4 py-3 text-white bg-gray-900 my-8 mx-16 flex-col items-center rounded-xl">
                <h1 class="m-4 text-5xl text-gray-300">Results of {{ $obj->name }} - {{ $obj->points }}</h1>
                <p class="m-2 text-lg text-gray-300">You just tested this website total loading speed, image loading
                    speed and file loading speed.
                </p>

                @if ($obj->points < 500)
                    <p class="m-2 text-lg text-red-700">Your website analyzed with score lower than 500, that means:
                        <li>currently developed algorithm did not work properly on this website</li>
                        <li>The website is in development</li>
                        <li>The images and banners are stored in safe private storage and not accessable by external
                            algorithms</li>
                    </p>
                @endif
            </div>
        </div>
        <div class="max-w-2xl mx-auto mt-8 text-white">
            <p class="mb-4">URL: {{ $obj->url }}</p>


            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-4">
                    <a href="#image_loading_speeds"
                        class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $obj->image_count }}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Total valid image count</p>
                    </a>
                    <a href="#image_loading_speeds"
                        class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $obj->avg_image_loading_speed }} sec</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Avarage banner/image loading speed</p>
                    </a>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-4 pt-4">

                    <a href="#website_loading_speeds"
                        class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $obj->recieved_response_speed }} sec</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Websites handle response time</p>
                    </a>
                    <a href="#website_loading_speeds"
                        class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $obj->total_image_Loading_Speed }} sec</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Total banner/image loading speed</p>
                    </a>
                </div>
            </div>



            <h2 id="image_loading_speeds" class="text-2xl font-bold mb-4">See your detailed websites performance down
                here</h2>

            <div id="accordion-flush" data-accordion="collapse"
                data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                data-inactive-classes="text-gray-500 dark:text-gray-400">
                <h2 id="accordion-flush-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">
                        <span>Found image extensions and count</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <ul class="text-gray-500 dark:text-gray-400 list-disc pl-4 mb-8">
                            @foreach ($obj->image_extensions as $ext => $exte)
                                <li>{{ $ext }} - {{ $exte }} extensions</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <h2 id="accordion-flush-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                        aria-controls="accordion-flush-body-2">
                        <span>Each image loading speeds</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-white">If you don't see all the images here from the list, that is because those
                            images ar protected from external access.</p>
                        <ul class="text-gray-500 dark:text-gray-400 list-disc pl-4 mb-8">
                            @foreach ($obj->image_loading_speed as $url => $speed)
                                <li>{{ $url }} - {{ $speed }} seconds</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <h2 id="accordion-flush-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
                        aria-controls="accordion-flush-body-3">
                        <span>All found image links</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-white">If some of the images are not working that is because they are protected
                            from extraction. This is comonlly used for large paid image storages so no one could steal
                            them without water marks.</p>
                        <ul class="text-gray-500 dark:text-gray-400 list-disc pl-4 mb-8">
                            @foreach ($obj->image_urls as $id => $url)
                                <li><a target="_blank" class="hover:bg-gray-600"
                                        href="{{ $url }}">{{ $id }} - {{ $url }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <h2 id="accordion-flush-heading-4">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-4" aria-expanded="false"
                        aria-controls="accordion-flush-body-4">
                        <span>Point system and what it means</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <ul class="list-disc pl-4 mb-8">
                            
                        
                                <h3 class="text-white text-xl">You got {{ $obj->points }} points</h3>
                                <p class="text-white">What it means and why is that?</p>

                                <ul class="text-gray-500 dark:text-gray-400 list-disc pl-4 mb-8">
                                    <li>Less than 200 - That means that this website is under development and mostly empty or it could be our algorithm problem</li>
                                    <li>Less than 500 - That means that this website is small and images are optimized </li>
                                    <li>Less than 1000 - That means that this website is normal size website with good server side optimization and good image optimizations </li>
                                    <li>More than 2000 - This website is probably internet shop or some large image storage or the website could just be not optimized </li>
                                </ul>
                                
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <section class="flex flex-col items-center pt-6">
            <h2 class="mb-2 text-3xl font-semibold text-gray-900 text-center dark:text-white">Advice for making your
                website faster
            </h2>
            <br>
            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Improving image extensions:</h2>
            <p class="mb-2 text-l text-gray-900 dark:text-white text-center pb-6">Currently recomended image
                formats</p>
            <ul class="max-w-2xl space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                <li>
                    JPEG (Joint Photographic Experts Group): This format is great for photographs and complex images
                    with lots of color and detail. JPEG files can be compressed to reduce their file size without losing
                    too much image quality.
                </li>
                <li>
                    PNG (Portable Network Graphics): PNG is a lossless image format, which means that it doesn't lose
                    any image quality when compressed. It's best for images with simple graphics and transparency.
                </li>
                <li>
                    GIF (Graphics Interchange Format): GIFs are best for simple animated images, such as logos or icons,
                    that require only a few colors. They have a low file size, but the animation quality is limited.
                </li>
                <li>
                    <strong>SVG (Scalable Vector Graphics):</strong> SVG is a vector-based image format, which means
                    that it can be
                    scaled to any size without losing image quality. It's best for logos, icons, and other simple
                    graphics.
                </li>
                <li>
                    <strong>WebP (Web Picture)</strong>: WebP newer image format developed by Google.
                    It uses advanced compression techniques to reduce image file size without compromising quality.
                    WebP can produce smaller file sizes than JPEG or PNG for the same quality image.
                    This can help websites load faster and reduce bandwidth usage.
                    However, not all web browsers support WebP natively, so alternative formats may be needed.
                </li>
            </ul>
            <p class="mb-2 text-l text-gray-900 dark:text-white text-center pt-6 w-1/2">Overall, the best image format
                for your website depends on the type of image and the level of detail required. In general, JPEG is
                great for photographs, PNG is good for graphics with transparency, GIF is best for simple animations,
                and SVG is best for vector-based graphics. Overall, WebP can be a great option for websites that
                prioritize fast loading times and want to reduce their bandwidth usage.</p>
        </section>

        <section class="w-1/2 my-4 flex flex-col items-center">
            <h1 class="m-4 text-3xl text-gray-300">Write your review</h1>
            <p class="m-2 text-lg text-gray-300 text-center w-2/3 mb-6">Write review about the results, for others to
                see</p>
            <form method="post" action="{{ route('comment.add') }}"
                class="mt-6 space-y-6 w-full flex flex-col items-center">
                @csrf
                @method('patch')
                <input type="hidden" name="url" value="<?= $obj->url ?>">
                <label for="stars" class="text-white">Rate from 1 to 5</label>
                <select name="stars" id="stars"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>

                <textarea required id="comment" name="comment" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Leave your results review here ..."></textarea>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
            </form>
        </section>









    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
