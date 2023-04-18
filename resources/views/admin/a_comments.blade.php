<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comment list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="pb-6 text-center">
                        {{ __('Comment list') }}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Created by</th>
                                <th scope="col" class="px-6 py-3">Created at</th>
                                <th scope="col" class="px-6 py-3">Show Comment</th>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $comment->id }}</th>
                                        @php
                                            $user = App\Models\User::find($comment->user_id);
                                            $website = App\Models\Searched_websites::find($comment->website_id);
                                        @endphp
                                        <td class="px-6 py-4">{{ $user->username }}</td>
                                        <td class="px-6 py-4">{{ $comment->created_at }}</td>
                                        <td class="px-6 py-4"><a id="ban-user-btn" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'show-comment-{{ $comment->id }}')"
                                            href=""
                                            class="font-medium text-green-600 dark:text-green-500 hover:underline pl-3">Show
                                            comment</a>
                                        </td>
                                        @include('admin.partials.show-comment')

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
