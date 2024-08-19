@extends('components.layout')
@section('content')
    <div class="flex flex-col px-6 lg:px-8 h-screen pt-20">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 w-auto" src="/images/favicon.png" alt="learnix">
            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-white">Sign in to your account
            </h2>
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <x-inputfield placeholder="email" id="email" name="email" type="email" autocomplete="email"
                    :value="old('email')">Email Address</x-inputfield>
                <x-inputfield placeholder="password" id="password" name="password" type="password">Password</x-inputfield>
                <div class="text-sm m-0 flex flex-row justify-end">
                    <a href="/reset" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot
                        password?</a>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                        in</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                <a href="/register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Register Here</a>
            </p>
        </div>
    </div>
@endsection
