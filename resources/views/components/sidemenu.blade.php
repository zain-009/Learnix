<div {{ $attributes }} class="grid grid-cols-[auto,1fr] fixed top-16 bottom-0 left-0 right-0">
    <div id='sidebar' class="bg-gray-800 h-screen border-indigo-500 border-r w-16 md:w-48 lg:w-64 transition-all">
        <x-sidemenubutton href="/home" icon="fas fa-home" :active="request()->is('home')"><span
                class="hidden md:block side-menu-span transition-all">Home</span></x-sidemenubutton>
        <x-sidemenubutton href="/teaching" icon="fas fa-user-group" :active="request()->is('teaching')"><span
                class="hidden md:block side-menu-span transition-all">Teaching</span></x-sidemenubutton>
        <x-sidemenubutton href="/enrolled" icon="fas fa-graduation-cap" :active="request()->is('enrolled')"><span
                class="hidden md:block side-menu-span transition-all">Enrolled</span></x-sidemenubutton>
        <x-sidemenubutton href="/settings" icon="fas fa-gear" :active="request()->is('settings')"><span
                class="hidden md:block side-menu-span transition-all">Settings</span></x-sidemenubutton>
    </div>
    <div class="flex-1 p-6 md:p-10 overflow-auto bg-gray-900">
        @yield('sidebar-content')
    </div>
</div>
