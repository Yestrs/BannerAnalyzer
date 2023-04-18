<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4">
            
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_websites_analyzed }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Websites Analyzed</p>
            </a>
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_unique_websites_analyzed }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total unique websites analyzed</p>
            </a>
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_comments }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total writen comments</p>
            </a>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4 mt-6">
            
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_users }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Users Registered</p>
            </a>
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_logs }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total User action logs</p>
            </a>
            <a href="#" class="block text-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $home_obj->total_banned_users }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total banned users</p>
            </a>
        </div>
    </div>
</x-panel-layout>
