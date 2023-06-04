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
            <h1 class="m-4 text-3xl text-gray-300">Privacy Policy</h1>
        </section>

        <div class="text-white">
            <h2>Effective Date: 04/06/2023</h2>

            <p>Thank you for using [www.banneranalyzer.com] ("we," "us," or "our"). This Privacy Policy explains how we
                collect, use, disclose, and safeguard your information when you use our website and the services
                provided through it.</p>

            <p>By using our website and services, you consent to the practices described in this Privacy Policy. If you
                do not agree with the terms of this Privacy Policy, please do not access the website or use our
                services.</p>

            <h3>1. Information We Collect</h3>
            <p>We may collect personal and non-personal information from you when you use our website and services. The
                types of information we collect may include:</p>

            <h4>1.1. Personal Information:</h4>
            <ul>
                <li>Name</li>
                <li>Email address</li>
                <li>Username and password (if you create an account)</li>
                <li>Any other information you voluntarily provide to us</li>
            </ul>

            <h4>1.2. Non-Personal Information:</h4>
            <ul>
                <li>Log data (e.g., IP address, browser type, referring/exit pages, and operating system)</li>
                <li>Device information (e.g., device type, unique device identifier, and mobile network information)
                </li>
                <li>Aggregate information about website usage and performance results</li>
            </ul>

            <h3>2. Use of Information</h3>
            <p>We may use the information we collect for various purposes, including but not limited to:</p>

            <h4>2.1. Providing and Improving our Services:</h4>
            <ul>
                <li>Analyzing website images and generating performance results</li>
                <li>Enhancing and personalizing user experience</li>
                <li>Developing new features and functionality</li>
                <li>Troubleshooting technical issues</li>
                <li>Monitoring and analyzing trends</li>
            </ul>

            <h4>2.2. Communication:</h4>
            <ul>
                <li>Sending administrative notifications, updates, and information about our services</li>
                <li>Responding to user inquiries, comments, or feedback</li>
            </ul>

            <h4>2.3. Protecting Rights and Interests:</h4>
            <ul>
                <li>Enforcing our terms of service and other applicable policies</li>
                <li>Investigating and preventing fraudulent or unauthorized activities</li>
                <li>Complying with legal obligations</li>
            </ul>
        </div>





    </div>
    @include('layouts.footer')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>

</html>
