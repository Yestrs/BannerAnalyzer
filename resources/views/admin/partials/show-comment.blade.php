<x-modal name="show-comment-{{ $comment->id }}" :show="false" focusable>

    <div class="p-6">

        <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">
            {{ __('Comment from - ' . $user->username . ' for ' . $website->name) }}
        </h2>
        <div class="flex items-center justify-center">
            <p class="mt-1 text-sm text-justified text-gray-600 dark:text-gray-400 pb-4">
                {{ __('Commented on - ' . $comment->created_at) }}
            </p>
        </div>
        <h4 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">Results rated - </h4>
        <div class="flex items-center mb-1 justify-center">
            @for ($i = 0; $i < $comment->stars; $i++)
                <x-star-svg></x-star-svg>
            @endfor
        </div>
        
        <div class="p-6">
            <p class="mt-1 text-sm text-justified text-gray-600 dark:text-gray-400 pb-4">
                @if ($comment->comment)
                    {{ $comment->comment }}
                @else
                    {{ __('No comment') }}
                @endif

            </p>
        </div>


        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </div>

</x-modal>
