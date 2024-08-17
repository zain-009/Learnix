<!DOCTYPE html>
<html class="bg-gray-900" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnix</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.4/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.9/dist/css/uikit.min.css" />

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900">

    <nav class="fixed top-0 z-50 w-full bg-gray-800 border-b border-indigo-500">
        <div class="mx-auto px-4 sm:px-8 lg:px-10">
            <div class="flex h-16 items-center justify-between">
                <div id="sidebarToggle" class="flex items-center gap-x-6">
                    @auth
                        <button
                            class="md:hidden hover:outline-none bg-gray-700 hover:bg-gray-900 hover:ring-1 ring-indigo-500 px-3 py-1.5 rounded-full"
                            id="sidebar-toggle">
                            <i class="fas fa-bars text-lg text-white"></i>
                        </button>
                    @endauth
                    <a class="flex flex-row items-center gap-x-2 hover:no-underline" href="/">
                        <img class="h-10 w-auto" src="/images/favicon.png" alt="learnix">
                        <h1 class="font-poppins text-white text-2xl ">Learnix</h1>
                    </a>
                </div>
                @auth
                    <div class="flex gap-x-5 items-center">
                        <div class="dropdown" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative hover:outline-none hover:ring-1 ring-indigo-500 hover:bg-gray-900 rounded-full bg-gray-700"
                                <span class="absolute -inset-1.5"></span>
                                <i class="fas fa-plus font-medium text-white px-3.5 py-2.5"></i>
                            </button>
                            <div x-transition x-show="open" @click.away="open = false"x-cloak
                                class="absolute right-20 z-10 mt-2 w-36 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none flex flex-col justify-center">
                                <button uk-toggle="target: #modal-example" href="#"
                                    class="block px-7 py-2 text-sm text-gray-700 hover:bg-slate-200" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Join a class</button>
                                <button uk-toggle="target: #modal-example2" href="#"
                                    class="block px-5 py-2 text-sm text-gray-700 hover:bg-slate-200" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Create a class</button>

                                <div class="uk-container">
                                    <!-- This is the modal -->
                                    <div id="modal-example" uk-modal>
                                        <div
                                            class="uk-modal-dialog uk-modal-body rounded-lg bg-gray-800 border border-indigo-500">
                                            <div class="flex flex-col gap-8 mt-5">
                                                <span class="text-2xl">Enter the 6 digit class code below</span>
                                                <form class="flex flex-col gap-y-5" action="/joinClass" method="POST">
                                                    @csrf
                                                    <div>
                                                        <input type="text" name="classCode" id="classCode" min="6"
                                                            max="6" placeholder="Class Code" maxlength="6"
                                                            class="w-full h-12 p-3 border border-indigo-500 rounded-lg bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                                    </div>
                                                    <div class="flex justify-end items-center gap-x-5">
                                                        <span
                                                            class="bg-gray-700 py-2 px-4 rounded-lg uk-modal-close cursor-pointer">Cancel</span>
                                                        <button type="submit"
                                                            class="bg-indigo-600 py-2 px-4 rounded-lg hover:bg-indigo-700">Join</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="modal-example2" uk-modal>
                                        <div
                                            class="uk-modal-dialog uk-modal-body rounded-lg bg-gray-800 border border-indigo-500">
                                            <div class="flex flex-col gap-8 mt-5">
                                                <span class="text-2xl">Enter class details</span>
                                                <form class="flex flex-col gap-y-5" action="/createClass" method="post">
                                                    @csrf
                                                    <input type="text" name="className" id="className"
                                                        placeholder="Class Name"
                                                        class="w-full h-12 p-3 border border-indigo-500 rounded-lg bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                                    <input type="text" name="section" id="section"
                                                        placeholder="Section"
                                                        class="w-full h-12 p-3 border border-indigo-500 rounded-lg bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                                    <div class="flex justify-end items-center gap-x-5">
                                                        <span
                                                            class="bg-gray-700 py-2 px-4 rounded-lg uk-modal-close cursor-pointer">Cancel</span>
                                                        <button type="submit"
                                                            class="bg-indigo-500 py-2 px-4 rounded-lg hover:bg-indigo-600">Create</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="/logout" method="post">
                            @csrf
                            <button
                                class="hover:outline-none hover:ring-1 ring-indigo-500 hover:bg-gray-900 rounded-md bg-gray-700 px-3 py-2 text-sm font-medium text-white">Logout</button>
                        </form>
                    </div>
                @endauth
                @guest()
                    @if (request()->is('login'))
                        <a href="/register"
                            class="hover:outline-none hover:no-underline hover:ring-1 ring-indigo-500 hover:bg-gray-900 rounded-md bg-gray-700 px-3 py-2 text-sm font-medium text-white"
                            aria-current="page">Register</a>
                    @else
                        <a href="/login"
                            class="hover:outline-none hover:no-underline hover:ring-1 ring-indigo-500 hover:bg-gray-900 rounded-md bg-gray-700 px-3 py-2 text-sm font-medium text-white"
                            aria-current="page">Login</a>
                    @endif
                @endguest
            </div>
        </div>
    </nav>
    @auth
        <x-sidemenu></x-sidemenu>
    @endauth
    @yield('content')
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const spans = document.querySelectorAll('.side-menu-span');

        sidebarToggle.addEventListener('click', () => {
            if (sidebar.classList.contains('w-16')) {
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-48');
                spans.forEach(span => span.classList.remove('hidden'));
            } else {
                sidebar.classList.remove('w-48');
                sidebar.classList.add('w-16');
                spans.forEach(span => span.classList.add('hidden'));
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.9/dist/js/uikit-icons.min.js"></script>
</body>

</html>
