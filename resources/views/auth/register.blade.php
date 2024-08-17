@extends('components.layout')
@section('content')
    <div class="flex flex-col px-6 lg:px-8 pt-28 h-screen">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 w-auto" src="/images/favicon.png" alt="learnix">
            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-white">Register a new account
            </h2>
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-xl">
            <form class="space-y-8" action="/register" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-y-4 gap-x-8 sm:grid-cols-2">
                    <x-inputfield placeholder="name" id="name" name="name" type="text"
                        value="{{ old('email') }}">Full Name</x-inputfield>
                    <x-inputfield placeholder="email" id="email" name="email" type="email"
                        value="{{ old('email') }}">Email Address</x-inputfield>
                    <x-inputfield placeholder="password" id="password" name="password"
                        type="password">Password</x-inputfield>
                    <x-inputfield placeholder="confirm password" id="password_confirmation" name="password_confirmation"
                        type="password">Confirm
                        Password</x-inputfield>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="px-28 rounded-md bg-indigo-600 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                </div>
            </form>

            <p class="mt-5 text-center text-sm text-gray-500">
                Already a member?
                <a href="/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login Here</a>
            </p>
        </div>
    </div>
@endsection
