<div>
    <label for="{{ $attributes->get('name') }}"
        class="block text-sm font-medium leading-6 text-white">{{ $slot }}</label>
    <div class="mt-2">
        <input {{ $attributes }} required
            class="bg-slate-800 h-10 block w-full hover:ring-1 rounded-md border-0 px-5 py-1.5 focus:ring-2 ring-indigo-600 text-white shadow-sm ring-0 focus:outline-none placeholder:text-gray-500 sm:text-sm sm:leading-6">
    </div>
    @error($attributes->get('name'))
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
