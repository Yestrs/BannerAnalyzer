<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-modal name="confirm-user-deletion" :show="false" focusable>
        
    </x-modal>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}</x-danger-button>
    <a id="confirm-user-deletion" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        href="" class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>

  
</section>
