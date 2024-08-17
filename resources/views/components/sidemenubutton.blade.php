@props(['active' => false, 'icon'])

<a {{ $attributes }}
    class="{{ $active ? 'bg-gray-700' : 'hover:bg-gray-500' }} flex flex-row items-center justify-between mr-3 ps-5 py-3 my-4 rounded-r-3xl gap-x-1 hover:no-underline">
    <div class="flex items-center">
        <i class="{{ $icon }} pr-5 py-1 rounded-full text-white"></i>
        <span class="text-white text-lg side-menu-span pr-5 sm:pr-16">{{ $slot }}</span>
    </div>
</a>
