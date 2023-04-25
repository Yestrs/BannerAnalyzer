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
                <p class="m-2 text-lg text-gray-300">
                    <pre><?php //echo print_r($obj); ?></pre>
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto mt-8 text-white">
            <h1 class="text-3xl font-bold mb-4">{{ $obj->name }} website statistics</h1>
            <p class="mb-4">URL: {{ $obj->url }}</p>
            <p class="mb-4">Image count: {{ $obj->image_count }}</p>
          
            
          
            <h2 class="text-2xl font-bold mb-4">Image loading speeds:</h2>
            <p class="mb-4">Avarage image loading speed: {{ $obj->avg_image_loading_speed }}</p>
            <ul class="list-disc pl-4 mb-8">
              @foreach ($obj->image_loading_speed as $url => $speed)
                <li>{{ $url }} - {{ $speed }} seconds</li>
              @endforeach
            </ul>
          
            <h2 class="text-2xl font-bold mb-4">Page loading speed:</h2>
            <p class="mb-8">Load time: {{ $obj->page_load_time }} seconds</p>
            <ul class="list-disc pl-4 mb-8">
                @foreach ($obj->page_each_load_time as $ext => $speed)
                    <li>{{ $ext }} - {{ $speed }} seconds</li>
                @endforeach
            </ul>
            
          
          </div>



        <section class="flex flex-col items-center">
            <h2 class="mb-2 text-3xl font-semibold text-gray-900 text-center dark:text-white">Advice for making your
                website faster
            </h2>

            <br>




            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Improving image extensions:</h2>
            <p class="mb-2 text-l text-gray-900 dark:text-white text-center pb-6">Currently recomended image
                formats</p>
            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
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
                    <strong>SVG (Scalable Vector Graphics):</strong> SVG is a vector-based image format, which means that it can be
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
            <p class="mb-2 text-l text-gray-900 dark:text-white text-center pt-6 w-1/2">Overall, the best image format for your website depends on the type of image and the level of detail required. In general, JPEG is great for photographs, PNG is good for graphics with transparency, GIF is best for simple animations, and SVG is best for vector-based graphics. Overall, WebP can be a great option for websites that prioritize fast loading times and want to reduce their bandwidth usage.</p>



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
