<nav x-data="{ open: false }" class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-800">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="/" class="text-white">
            Banner Analyzer
        </a>
        <div class="flex items-center md:order-2">

            @auth
                <button type="button"
                    class="font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 transition ease-in-out duration-150 sm:items-center flex mr-3 text-sm text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 text-bold p-2 rounded md:mr-0"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    {{ Auth::user()->username }}
                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}
                            {{ Auth::user()->surname }}</span>
                        <span
                            class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        @if (Auth::user()->is_admin)
                            <x-dropdown-link :href="route('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                        @endif




                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </ul>
                </div>
            @else
                @if (Route::has('login'))
                    <div class="flex space-x-4">
                        <x-nav-link-public :href="route('login')">
                            {{ __('Log in') }}
                        </x-nav-link-public>
                        @if (Route::has('register'))
                            <x-nav-link-public :href="route('register')">
                                {{ __('Register') }}
                            </x-nav-link-public>
                        @endif
                    </div>    
                @endif
            @endauth
            <button data-collapse-toggle="mobile-menu-2" type="button"
                class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
            <ul class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-800 dark:border-gray-800">
                <x-nav-link-public :href="route('p_homePage')" :active="request()->routeIs('p_homePage')">
                    {{ __('Home') }}
                </x-nav-link-public>
                <x-nav-link-public :href="route('p_about')" :active="request()->routeIs('p_about')">
                    {{ __('About us') }}
                </x-nav-link-public>
            </ul>
        </div>
    </div>
</nav>
