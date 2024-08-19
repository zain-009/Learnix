@extends('components.layout')
@section('sidebar-content')
    <div class="flex flex-col justify-center items-center mb-5 gap-y-5">
        <div class="w-full py-5 bg-gray-800 flex flex-col items-center rounded-lg border text-3xl border-indigo-500 gap-y-3">
            <span class="font-bold text-center">{{ $type }} Submissions</span>
            <span>{{ $class->className }}</span>
            <span>{{ $class->section }}</span>
        </div>
        @if ($type == 'Assignment')
            <div
                class="max-w-96 w-full p-5 bg-gray-800 flex flex-col items-center rounded-lg border text-xl border-indigo-500 gap-y-2">
                <div class="flex items-center justify-between w-full gap-x-5">
                    <div class="flex gap-x-3 items-center">
                        <i class="fa fa-file-lines"></i>
                        <span>{{ $assignment->title }}</span>
                    </div>
                    <div class="flex flex-col text-lg items-center">
                        <span>Duration</span>
                        <span>{{ $assignment->duration }} Days</span>
                    </div>
                </div>
                <span class="text-base w-full">Submissions: {{ $count }}</span>
                <div class="flex flex-col w-full text-base">
                    <span>Instructions:</span>
                    <p class="text-sm">
                        @if (is_null($assignment->instructions))
                            none
                        @else
                            {{ $assignment->instructions }}
                        @endif
                    </p>
                </div>
            </div>
        @else
            <div
                class="max-w-96 w-full p-5 bg-gray-800 flex flex-col items-center rounded-lg border text-xl border-indigo-500 gap-y-2">
                <div class="flex items-center justify-between w-full gap-x-5">
                    <div class="flex gap-x-3 items-center">
                        <i class="fa fa-file-lines"></i>
                        <span>{{ $quiz->title }}</span>
                    </div>
                    <div class="flex flex-col text-lg items-center">
                        <span>Duration</span>
                        <span>{{ $quiz->duration }} Hours</span>
                    </div>
                </div>
                <span class="text-base w-full">Submissions: {{ $count }}</span>
                <div class="flex flex-col w-full text-base">
                    <span>Instructions:</span>
                    <p class="text-sm">
                        @if (is_null($quiz->instructions))
                            none
                        @else
                            {{ $quiz->instructions }}
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-24 w-full justify-center flex flex-col items-center gap-y-5">
        @foreach ($submissions as $submission)
            <div class=" p-5 w-72 sm:w-80 md:w-96 bg-gray-800 rounded-xl">
                <div class="flex justify-between items-center">
                    <div class="flex gap-x-4 items-center">
                        <div class='flex gap-x-4 items-center pl-2'>
                            @if ($submission->user->image)
                                <img src="{{ Storage::url($submission->user->image) }}"
                                    alt="{{ $submission->user->name }}" class="rounded-full w-10 h-10">
                            @else
                                <i class="fas fa-user rounded-full px-[13px] py-[12px] bg-gray-700"></i>
                            @endif
                            <span>{{ $submission->user->name ?? 'Unknown User' }}</span>
                        </div>
                    </div>
                    <div class="flex gap-x-3 items-center">
                        @if ($submission->turn_in_time == 'on_time')
                            <span class="text-green-400">On Time</span>
                        @else
                            <span class="text-red-600">late</span>
                        @endif
                        <i class="fa-solid fa-ellipsis-vertical px-3 py-2 rounded-full hover:bg-gray-700"></i>
                        <div uk-dropdown="mode: click" class="bg-gray-600 text-white p-0">
                            <ul>
                                <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                    <a class=" hover:no-underline hover:text-white p-3 w-full text-center" download
                                        href="{{ Storage::url($submission->file) }}">Download</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
