<x-modal name="show-user-data-{{ $user->id }}" :show="false" focusable>
    <form method="post" action="####" class="">
        @csrf
        @method('patch')
        <div class="p-6">
            <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100">
                {{ __('Text?') }}
            </h2>

            <p class="mt-1 text-sm text-center text-gray-600 dark:text-gray-400 pb-4">
                {{ __('Description') }}
            </p>

            <x-input-label for="name" value="{{ __('Name') }}" class="mt-2" />

            <x-text-input id="name" name="name" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Name') }}" value="{{ $user->name }}" disabled />

            <x-input-label for="surname" value="{{ __('Surname') }}" class="mt-2" />

            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Surname') }}" value="{{ $user->surname }}" disabled />

            <x-input-label for="email" value="{{ __('Email') }}" class="mt-2" />

            <x-text-input id="email" name="email" type="email" class="mt-1 block w-3/4"
                placeholder="{{ __('Email') }}" value="{{ $user->email }}" disabled />

            <x-input-label for="username" value="{{ __('Username') }}" class="mt-2" />

            <x-text-input id="username" name="username" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Username') }}" value="{{ $user->username }}" disabled />

            <x-input-label for="times_searched" value="{{ __('Analyzed times') }}" class="mt-2" />

            <x-text-input id="times_searched" name="times_searched" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Analyzed times') }}" value="{{ $user->times_searched }}" disabled />

            <x-input-label for="bio" value="{{ __('Bio') }}" class="mt-2" />

            <x-text-input id="bio" name="bio" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Bio') }}" value="{{ $user->social_linkedin }}" disabled />

            <!-- SOCIALS -->
            <x-input-label for="facebook" value="{{ __('Facebook') }}" class="mt-2" />

            <x-text-input id="facebook" name="facebook" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Facebook') }}" value="{{ $user->social_facebook }}" disabled />

            <x-input-label for="github" value="{{ __('Github') }}" class="mt-2" />

            <x-text-input id="github" name="github" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Github') }}" value="{{ $user->social_github }}" disabled />

            <x-input-label for="linkedin" value="{{ __('Linked in') }}" class="mt-2" />

            <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Linked In') }}" value="{{ $user->social_linkedin }}" disabled />


            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Close') }}
                </x-secondary-button>
            </div>
    </form>
</x-modal>
