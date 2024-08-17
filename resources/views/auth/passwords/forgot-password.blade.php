@extends('components.layout')
@section('content')
    <div class="flex min-h-full flex-col justify-center items-center px-6 lg:px-8 mt-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 w-auto" src="/images/favicon.png" alt="learnix">
            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-white">Reset Password
            </h2>
        </div>
        <p class="mt-5 mx-3 text-white">Enter the email address associated with your account</p>
        <div>
            @if (session()->has('error'))
                <div class="bg-red-600">{{ session('error') }}</div>
            @endif
            @if (session()->has('success'))
                <div class="bg-green-600">{{ session('success') }}</div>
            @endif
        </div>
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/reset" method="POST">
                @csrf
                <x-inputfield placeholder="email" id="email" name="email" type="email" autocomplete="email"
                    :value="old('email')">Email Address</x-inputfield>
                <div class="text-sm m-0 flex flex-row justify-end">
                    <a href="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">Login to your account?</a>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
