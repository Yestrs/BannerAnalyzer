<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="pb-6 text-center">
                        {{ __("Analyzed websites") }}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Domain</th>
                                <th scope="col" class="px-6 py-3">Times Searched</th>
                                <th scope="col" class="px-6 py-3">Last Searched By</th>
                                <th scope="col" class="px-6 py-3">Time</th>
                                <th scope="col" class="px-6 py-3">Data</th>
                            </thead>
                            <tbody>
                                @foreach ($websites as $website)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $website->id }}</th>
                                        <td class="px-6 py-4">{{ $website->name }}</td>
                                        <td class="px-6 py-4">{{ $website->domain }}</td>
                                        <td class="px-6 py-4">{{ $website->search_times }}</td>
                                        <td class="px-6 py-4">{{ $website->last_searched_by }}</td>
                                        <td class="px-6 py-4">{{ $website->updated_at }}</td>
                                        <td class="px-6 py-4">
                                            @if ($website->data)
                                                <a id="showWesbiteResultsFromId"  href="{{ route('p_results', ['id' => $website->id]) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-panel-layout>