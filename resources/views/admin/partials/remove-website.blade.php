<x-modal name="remove-website-{{ $website->id }}" :show="false" focusable>
    <div class="p-6">
        <form method="post" action="{{ route('admin.website.remove') }}" class="p-6">
            @csrf
            @method('delete')


            <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this analyzed websites results?') }}
            </h2>
            <br>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                Website name - {{ $website->name}}
                <br>
                Website url - {{ $website->domain}}
            </p>



            <input type="hidden" name="id" value="{{ $website->id }}">

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>



        </form>
    </div>
</x-modal>
