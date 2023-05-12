<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analyzed websites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="pb-6 text-center">
                        {{ __('Analyzed websites') }}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Points</th>
                                <th scope="col" class="px-6 py-3">Times Searched</th>
                                <th scope="col" class="px-6 py-3">Last Searched By</th>
                                <th scope="col" class="px-6 py-3">Time</th>
                                <th scope="col" class="px-6 py-3">Data</th>
                            </thead>
                            <tbody>
                                @foreach ($websites as $website)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        @php
                                            $user = App\Models\User::find($website->last_searched_by);
                                        @endphp
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $website->id }}</th>
                                        <td class="px-6 py-4">{{ $website->name }}</td>
                                        {{-- <td class="px-6 py-4 max-w-xs overflow-x-auto">{{ $website->domain }}</td> --}}
                                        <td class="px-6 py-4">{{ $website->points }}</td>
                                        <td class="px-6 py-4">{{ $website->search_times }}</td>
                                        <td class="px-6 py-4">
                                            @isset($user->username)
                                                {{ $user->username }}
                                            @else
                                                {{ __('Not Registered') }}
                                            @endisset
                                        </td>
                                        <td class="px-6 py-4">{{ $website->updated_at }}</td>
                                        <td class="px-6 py-4 flex flex-row">
                                            <div>
                                                @if ($website->data)
                                                    <a id="showWesbiteResultsFromId"
                                                        href="{{ route('p_results', ['id' => $website->id]) }}"
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>
                                                @endif
                                            </div>
                                            <div>
                                                <a id="remove-website-btn" x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'remove-website-{{ $website->id }}')"
                                                    href=""
                                                    class="font-medium text-red-600 dark:text-red-500 hover:underline pl-3">Delete</a>
                                            </div>
                                        </td>

                                    </tr>
                                    @include('admin.partials.remove-website')
                                @endforeach
                            </tbody>
                        </table>
                        <div class="place-self-center p-6">
                            {!! $websites->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-panel-layout>
