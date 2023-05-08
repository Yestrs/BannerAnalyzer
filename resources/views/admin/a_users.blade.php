<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="pb-6 text-center">
                        {{ __('User list') }}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Username</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Verified</th>
                                <th scope="col" class="px-6 py-3">Created time</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    {{-- @include('admin.partials.ban-user') --}}
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->id }}</th>
                                        <td class="px-6 py-4">{{ $user->username }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if ($user->email_verified_at)
                                                {{ $user->email_verified_at }}
                                            @else
                                                <span class="text-red-600">Not verified</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at }}</td>
                                        <td class="px-6 py-4 flex flex-row">
                                            <div>
                                                @if ($user->name || $user->surname || $user->bio != null)
                                                    <a id="edit-user-btn" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'show-user-data-{{ $user->id }}')"
                                                        href=""
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>
                                                @endif
                                            </div>
                                            <div>
                                                @if ($user->is_banned == false)
                                                    <a id="ban-user-btn" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'ban-user-{{ $user->id }}')"
                                                        href=""
                                                        class="font-medium text-red-600 dark:text-red-500 hover:underline pl-3">Ban</a>
                                                @else
                                                    <a id="ban-user-btn" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'ban-user-{{ $user->id }}')"
                                                        href=""
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline pl-3">Unban</a>
                                                @endif
                                            </div>
                                            <div>
                                                @if ($user->is_admin == false)
                                                    <a id="ban-user-btn" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'set-admin-user-{{ $user->id }}')"
                                                        href=""
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline pl-3">Set
                                                        admin</a>
                                                @else
                                                    <a id="ban-user-btn" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'set-admin-user-{{ $user->id }}')"
                                                        href=""
                                                        class="font-medium text-red-600 dark:text-red-500 hover:underline pl-3">Remove
                                                        admin</a>
                                                @endif
                                            </div>



                                        </td>
                                    </tr>
                                    @include('admin.partials.ban-user')


                                    @include('admin.partials.set-admin-user')


                                    @include('admin.partials.show-user-data')
                                @endforeach
                            </tbody>
                        </table>
                        <div class="place-self-center p-6">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-panel-layout>
