<nav class=" w-ful flex items-center justify-between" aria-label="Global">
    <ul class="icon-nav flex items-center gap-4">
        <li class="relative xl:hidden">
            <a class="text-xl  icon-hover cursor-pointer text-heading"
               id="headerCollapse" data-hs-overlay="#application-sidebar-brand"
               aria-controls="application-sidebar-brand" aria-label="Toggle navigation" href="javascript:void(0)">
                <i class="ti ti-menu-2 relative z-1"></i>
            </a>
        </li>

        <li class="relative">
            <h2>Dashboard</h2>
        </li>
    </ul>
    <div class="flex items-center gap-4">

        <button @click="darkMode = !darkMode;
                        localStorage.setItem('darkMode', darkMode);
                        localStorage.setItem('theme', darkMode ? 'dark' : 'light');
                        localStorage.setItem('appearance', darkMode ? 'dark' : 'light');"
                class="p-2 bg-gray-700 text-white rounded-md">
            <span x-text="darkMode ? '🌞 Light Mode' : '🌙 Dark Mode'"></span>
        </button>

        <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
            <a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                <img class="object-cover w-9 h-9 rounded-full" src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}" alt=""
                     aria-hidden="true">
            </a>
            <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[200px] hidden z-[12] dark:bg-gray-700 text-black dark:text-white"
                 aria-labelledby="hs-dropdown-custom-icon-trigger">
                <div class="card-body p-0 py-2">
                    <a href="{{ route('profile.index') }}" class="flex gap-2 items-center font-medium px-4 py-1.5 hover:bg-gray-200 text-gray-400">
                        <i class="ti ti-user  text-xl "></i>
                        <p class="text-sm ">My Profile</p>
                    </a>

                    <div class="px-4 mt-[7px] grid">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn-outline-primary font-medium text-[15px] w-full hover:bg-blue-600 hover:text-white">Logout</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    </div>
</nav>
