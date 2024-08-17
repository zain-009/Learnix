@extends('components.layout')
@section('content')
    <div class="flex min-h-full flex-col justify-center items-center px-6 lg:px-8 mt-20">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 w-auto" src="/images/favicon.png" alt="learnix">
            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-white">Verify your identity
            </h2>
            <p class='mt-5'>Enter the code sent to {{ $email }}</p>
        </div>

        <div class=" sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/verifyPasswordCode"
                method="POST">
                @csrf
                <x-inputfield placeholder="_ _ _ _ _ _" id="code" name="code" type="text"></x-inputfield>
                <input type="hidden" value="{{ $email }}" id='email' name="email">
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Verify</button>
            </form>
        </div>
    </div>
@endsection
