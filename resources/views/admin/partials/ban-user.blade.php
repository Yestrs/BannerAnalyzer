<x-modal name="ban-user-{{ $user->id }}" :show="false" focusable>
    <div class="p-6">
        <form method="post" action="{{ route('admin.users.ban') }}" class="p-6">
            @csrf
            @method('patch')

            @if ($user->is_banned)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Do you really want to unban this user?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Unban user to restore their connection to our service') }}
                </p>

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Unban Account') }}
                    </x-primary-button>
                </div>
            @else
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Do you really want to ban this user?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is banned, user will not be able use his account or access the analyzer with it.') }}
                </p>

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3">
                        {{ __('Ban Account') }}
                    </x-danger-button>
                </div>
            @endif


        </form>
    </div>
</x-modal>
