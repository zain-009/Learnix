@extends('components.layout')
@section('sidebar-content')
    <div class="pb-40 flex flex-col items-start" x-data="{
        originalName: '{{ $user->name }}',
        originalEmail: '{{ $user->email }}',
        name: '{{ $user->name }}',
        email: '{{ $user->email }}',
        isChanged: false,
        resetValues() {
            this.name = this.originalName;
            this.email = this.originalEmail;
            this.isChanged = false;
        }
    }">
        <div
            class="flex flex-col justify-start items-start gap-y-7 border border-indigo-500 p-5 md:p-10 rounded-md bg-gray-800 w-full max-w-md">
            <span class="text-2xl sm:text-4xl">Personal Information</span>
            <hr class="w-36 sm:w-48 md:w-72 transition-all">
            <div class="flex flex-col sm:flex-row justify-start items-start sm:items-center gap-5">
                @if (auth()->user()->image)
                    <img src="{{ Storage::url(auth()->user()->image) }}" alt="Profile Image" class="rounded-full w-32 h-32">
                @else
                    <i class="fas fa-user text-4xl px-10 py-9 rounded-full bg-gray-700 w-min"></i>
                @endif
                <form action='/uploadProfileImage' class='flex flex-col gap-y-2' method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" accept="image/*" name="image" id="image"
                        class="text-sm max-w-60 text-gray-400">
                    @error('image')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="text-white bg-indigo-500 hover:bg-indigo-700 cursor-pointer w-min px-2 py-1 rounded-lg">
                        Change
                    </button>
                </form>
            </div>
            <form class="flex flex-col gap-y-7" action="/updateCredentials" method="post">
                @csrf
                <div class="flex flex-col gap-y-2 w-full max-w-80">
                    <label for="name" class="text-white text-lg">Full Name</label>
                    <input placeholder="name" id="name" name="name" type="text" x-model="name"
                        x-on:input="isChanged = true"
                        class="w-full bg-slate-700 block hover:ring-1 rounded-md border-0 px-5 py-1.5 focus:ring-2 ring-indigo-500 text-white shadow-sm ring-0 focus:outline-none placeholder:text-gray-500 sm:text-sm sm:leading-6">
                </div>
                <div class="flex flex-col gap-y-2 w-full max-w-80">
                    <label for="email" class="text-white text-lg">Email</label>
                    <input placeholder="email" id="email" name="email" type="email" autocomplete="email"
                        x-model="email" x-on:input="isChanged = true"
                        class="w-full bg-slate-700 block hover:ring-1 rounded-md border-0 px-5 py-1.5 focus:ring-2 ring-indigo-500 text-white shadow-sm ring-0 focus:outline-none placeholder:text-gray-500 sm:text-sm sm:leading-6">
                </div>
                <div class="flex gap-5" x-show="isChanged" x-cloak>
                    <button type="button" class="bg-gray-700 hover:bg-gray-800 py-2 px-4 rounded-lg"
                        x-on:click="resetValues()">Cancel</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-800 py-2 px-4 rounded-lg">Save</button>
                </div>
            </form>
            <span class="text-2xl sm:text-4xl mt-5">Account Security</span>
            <hr class="w-36 sm:w-48 md:w-72 transition-all">
            <form action="/deleteAccount" method="POST"
                class="flex flex-col sm:flex-row sm:items-center items-start gap-5">
                @csrf
                <input placeholder="password" id="password" name="password" type="password"
                    class="w-full sm:w-48  bg-slate-700 block hover:ring-1 rounded-md border-0 px-5 py-1.5 focus:ring-2 ring-indigo-500 text-white shadow-sm ring-0 focus:outline-none placeholder:text-gray-500 sm:text-sm sm:leading-6">
                <button type="submit" class="bg-red-600 py-2 px-4 rounded-lg hover:bg-red-800">Delete Account</button>
            </form>
        </div>


    </div>
@endsection
