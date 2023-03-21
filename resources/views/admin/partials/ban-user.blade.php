<x-modal name="show-user-data-{{ $user->id }}" :show="false" focusable>
    <form method="post" action="{{ }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Do you really want to ban this user?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is banned, user will not be able use his account or access the analyzer with it.') }}
        </p>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Ban Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
