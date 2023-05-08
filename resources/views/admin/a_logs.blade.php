<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="pb-6 text-center">
                        {{ __('User action list') }}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                                <th scope="col" class="px-6 py-3">Changes Made By</th>
                                <th scope="col" class="px-6 py-3">Changes Made To</th>
                                <th scope="col" class="px-6 py-3">Time</th>
                                <th scope="col" class="px-6 py-3">Data</th>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $log->id }}</th>
                                        <td class="px-6 py-4">{{ $log->action }}</td>
                                        <td class="px-6 py-4">
                                            @if (isset($log->user_made_by) && $log->user_made_by->username)
                                                {{ $log->user_made_by->username }}
                                            @else
                                                Not registered
                                            @endif
                                        </td>
                                        @empty(!$log->user_made_to)
                                            <td class="px-6 py-4">{{ $log->user_made_to->username }}</td>
                                        @else
                                            <td class="px-6 py-4"> - </td>
                                        @endempty
                                        <td class="px-6 py-4">{{ $log->time }}</td>
                                        @empty($log->data)
                                            <td class="px-6 py-4"></td>
                                        @else
                                            <td class="px-6 py-4"><a href="#"
                                                    class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>
                                            </td>
                                        @endempty
                                        <!-- Jasafixo šis empty tā ka tas sataisīts a_users -->
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="place-self-center p-6">
                            {!! $logs->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-panel-layout>
