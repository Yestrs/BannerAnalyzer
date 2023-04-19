<x-modal name="remove-comment-{{ $comment->id }}" :show="false" focusable>
    <div class="p-6">
        <form method="post" action="{{ route('admin.comment.remove') }}" class="p-6">
            @csrf
            @method('delete')


            <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this comment') }}
            </h2>

            <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">
                {{ __('Comment from - ' . $user->username . ' for ' . $website->name) }}
            </h2>
    
    
            <div class="p-6">
                <p class="mt-1 text-sm text-justified text-gray-600 dark:text-gray-400 pb-4">
                    @if ($comment->comment)
                        {{ $comment->comment }}
                    @else
                        {{ __('No comment') }}
                    @endif
    
                </p>
            </div>

            <input type="hidden" name="id" value="{{ $comment->id }}">

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete comment') }}
                </x-danger-button>
            </div>



        </form>
    </div>
</x-modal>
