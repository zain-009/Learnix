@extends('components.layout')

@section('sidebar-content')
    @php
        $colors = [
            'from-blue-500 to-green-500',
            'from-purple-500 to-blue-500',
            'from-[#08203e] to-[#557c93]',
            'from-[#432371] to-[#faae7b]',
            'from-[#392d69] to-[#b57bee]',
            'from-[#0e1c26] to-[#294861]',
            'from-indigo-800 to-blue-500',
        ];
        $gradient = $colors[1];
    @endphp

    <div x-data="{ activeTab: 1 }">
        <ul class="flex space-x-4 mb-6 text-white border-b border-gray-700">
            <li @click="activeTab = 1"
                :class="{
                    'text-indigo-500 border-b-2 border-indigo-500 font-semibold': activeTab ===
                        1,
                    'text-white': activeTab !== 1
                }"
                class="cursor-pointer pb-2">
                <a class="px-4 py-4 transition duration-300 ease-in-out hover:no-underline">
                    Stream
                </a>
            </li>
            <li @click="activeTab = 2"
                :class="{
                    'text-indigo-500 border-b-2 border-indigo-500 font-semibold': activeTab ===
                        2,
                    'text-white': activeTab !== 2
                }"
                class="cursor-pointer pb-2">
                <a class="px-4 py-2 transition duration-300 ease-in-out hover:no-underline">
                    Classwork
                </a>
            </li>
            <li @click="activeTab = 3"
                :class="{
                    'text-indigo-500 border-b-2 border-indigo-500 font-semibold': activeTab ===
                        3,
                    'text-white': activeTab !== 3
                }"
                class="cursor-pointer pb-2">
                <a class="px-4 py-2 transition duration-300 ease-in-out hover:no-underline">
                    People
                </a>
            </li>
        </ul>

        <div>
            <div x-show="activeTab === 1">
                <div class="flex flex-col gap-y-5 xl:mx-32">
                    <div class='bg-gradient-to-r {{ $gradient }} flex flex-col justify-end gap-y-2 p-5 h-48 rounded-lg'>
                        <span class="text-2xl">{{ $class->className }}</span>
                        <span class="text-xl">{{ $class->section }}</span>
                    </div>
                    <div class='grid grid-cols-12 gap-x-5 gap-y-5'>
                        <div class="col-span-12 sm:col-span-4 lg:col-span-3 xl:col-span-2 gap-y-1">
                            <div
                                class="bg-gray-800 px-10 lg:px-3 py-4 sm:px-6 rounded-lg border border-indigo-500 h-min flex flex-row sm:flex-col justify-between">
                                <span class='whitespace-nowrap lg:mr-5'>Class Code</span>
                                <span
                                    class="text-blue-500 text-lg font-medium cursor-pointer transition-transform duration-200"
                                    x-data="{
                                        copied: false,
                                        copyToClipboard() {
                                            navigator.clipboard.writeText('{{ $class->classCode }}').then(() => {
                                                this.copied = true;
                                                setTimeout(() => this.copied = false, 300);
                                            });
                                        }
                                    }" @click="copyToClipboard" :class="{ 'scale-110': copied }">
                                    {{ $class->classCode }}
                                </span>
                                <span x-cloak uk-dropdown
                                    class='p-2 bg-gray-800 rounded-lg border border-indigo-500 text-white'>Click
                                    the
                                    link to copy</span>
                            </div>
                            <div
                                class="mt-5 bg-gray-800 px-10 py-4 sm:px-6 rounded-lg border border-indigo-500 h-min flex flex-row items-center sm:flex-col justify-between">
                                <span class='whitespace-nowrap h-min'>Leave Class</span>
                                <button uk-toggle="target: #leave" type="button"
                                    class="md:mt-2 bg-red-800 hover:bg-red-900 rounded-md px-5 py-1">Leave</button>
                                <div id="leave" uk-modal>
                                    <div
                                        class="uk-modal-dialog uk-modal-body rounded-lg bg-gray-800 border border-indigo-500">
                                        <div class="flex flex-col gap-8 mt-5">
                                            <span class="text-2xl">Are you sure you want to leave this class?</span>
                                            <form class="flex flex-col gap-y-5" action="/leaveClass" method="POST">
                                                @csrf
                                                <div class="flex justify-center gap-x-5">
                                                    <input type="text" name="classId" id="classId"
                                                        value="{{ $class->id }}" hidden>
                                                    <span
                                                        class="bg-gray-700 hover:bg-gray-800 py-2 px-4 rounded-lg uk-modal-close cursor-pointer">Cancel</span>
                                                    <button type="submit"
                                                        class="bg-red-800 hover:bg-red-900 py-2 px-4 rounded-lg ">Leave</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class='col-span-12 sm:col-span-8 lg:col-span-9 xl:col-span-10 w-full gap-y-5 flex flex-col mb-20'>
                            @if (auth()->user()->id == $class->teacherId)
                                <form action="/postAnnouncement" method="post">
                                    @csrf
                                    <div
                                        class='bg-gray-800 rounded-lg border border-indigo-500 p-3 h-min flex items-center gap-x-2'>
                                        @if ($teacherImage)
                                            <img src="{{ Storage::url($teacherImage) }}" alt="Teacher Image"
                                                class="rounded-full w-10 h-10">
                                        @else
                                            <i class="fas fa-user text-xl  px-4 py-2.5 rounded-full bg-gray-700 w-min"></i>
                                        @endif
                                        <input type="text" name="announcement" id="announcement"
                                            placeholder='Announce something to your class'
                                            class='bg-gray-800 focus:outline-none w-full ml-2'>
                                        <input type="text" name="classId" id="classId" hidden
                                            value="{{ $class->id }}">
                                        <button type="submit">
                                            <i
                                                class="fa-solid fa-paper-plane text-lg px-3.5 py-2 rounded-full bg-gray-700 border border-gray-800 hover:border-indigo-500"></i>
                                        </button>
                                    </div>
                                </form>
                            @endif
                            @foreach ($announcements as $announcement)
                                <div
                                    class='bg-gray-800 rounded-lg border border-indigo-500 px-5 py-3 h-min flex flex-col gap-y-3'>
                                    <div class="flex justify-between items-center">
                                        <div class="flex gap-x-3">
                                            @if ($teacherImage)
                                                <img src="{{ Storage::url($teacherImage) }}" alt="Teacher Image"
                                                    class="rounded-full w-10 h-10">
                                            @else
                                                <i
                                                    class="fas fa-user text-xl px-4 py-2.5 rounded-full bg-gray-700 w-min"></i>
                                            @endif
                                            <div class="flex flex-col">
                                                <span>{{ $class->teacherName }}</span>
                                                <span
                                                    class="text-sm text-gray-500">{{ $announcement->created_at->format('d M h:i A') }}</span>
                                            </div>
                                        </div>
                                        @if (auth()->user()->id == $class->teacherId)
                                            <form action="/deleteAnnouncement" method="post">
                                                @csrf
                                                <input type="text" name="announcementId" id="announcementId" hidden
                                                    value="{{ $announcement->id }}">
                                                <i
                                                    class="fa-solid fa-ellipsis-vertical px-3 py-2 rounded-full hover:bg-gray-700"></i>
                                                <button type='submit' uk-dropdown="mode: click"
                                                    class="p-3 bg-gray-600 text-white hover:bg-slate-700">
                                                    Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                    <p>{{ $announcement->announcement }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 2">
                @if (auth()->user()->id == $class->teacherId)
                    <div class="pb-3 mb-5 border-b border-indigo-500">
                        <div class="uk-inline">
                            <button type="button">
                                <div
                                    class="flex bg-indigo-500 hover:bg-indigo-600 rounded-full px-4 py-2 items-center gap-x-3 w-min cursor-pointer">
                                    <i class="fa fa-plus"></i>
                                    <span>Create</span>
                                </div>
                            </button>
                            <div uk-dropdown="mode: click" class="bg-gray-700 p-0">
                                <button uk-toggle="target: #quiz" type='submit'
                                    class="p-3 mx-auto w-52 text-white hover:bg-gray-800">
                                    Quiz
                                </button>
                                <button uk-toggle="target: #assignment" type='submit'
                                    class="p-3 mx-auto w-52 text-white hover:bg-gray-800">
                                    Assignment
                                </button>
                                <button uk-toggle="target: #material" type='submit'
                                    class="p-3 mx-auto w-52 text-white hover:bg-gray-800">
                                    Material
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="quiz" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body rounded-lg bg-gray-800 border border-indigo-500 p-0">
                            <div
                                class="flex justify-between items-center bg-gray-700 py-3 px-5 rounded-t-lg border-b border-indigo-500">
                                <div class="flex gap-x-3 items-center">
                                    <i class="fa fa-file-code text-2xl"></i>
                                    <span class="text-2xl">Quiz</span>
                                </div>
                                <i
                                    class="fa fa-x uk-modal-close cursor-pointer px-[12px] py-[10px] rounded-full hover:bg-gray-800"></i>
                            </div>
                            <form action="/uploadQuiz" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-8 gap-5 p-5">
                                    <input type="text" name="classId" id="classId" value="{{ $class->id }}"
                                        hidden>
                                    <div class="col-span-6 flex flex-col gap-y-3">
                                        <input type="text" name="title" id="title" placeholder="Title"
                                            class="w-full h-12 px-3 py-0 border border-indigo-500 rounded-md bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                        <input type="text" name="instructions" id="instructions"
                                            placeholder="Instructions (Optional)"
                                            class="w-full h-12 px-3 py-0 border border-indigo-500 rounded-md bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                    </div>
                                    <div class="col-span-2">
                                        <div x-data="{ isOpen: false, points: 100 }" class="flex flex-col">
                                            <span>Marks</span>
                                            <div @click="isOpen = !isOpen"
                                                class="relative flex justify-between items-center bg-gray-700 px-1 sm:px-2 rounded-lg cursor-pointer">
                                                <input required type="text" x-model="points" name="marks"
                                                    id="marks"
                                                    class="px-2 py-1 rounded-md w-12 sm:w-24  bg-gray-700 text-sm outline-none" />
                                                <i :class="isOpen ? 'rotate-180' : 'rotate-0'"
                                                    class="transition-transform duration-200 fas fa-chevron-down mr-1"></i>
                                                <div x-show="isOpen" @click = "points = 'Ungraded';"
                                                    @click.outside = "isOpen = false" x-transition
                                                    class="absolute right-0 top-6 mt-2 w-32 bg-gray-700 hover:bg-gray-800 border border-gray-600 rounded-md shadow-lg">
                                                    <span class="px-4 py-2 cursor-pointer text-sm">
                                                        Ungraded
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col mt-1" x-data="{ focusInput() { this.$refs.duration.focus(); } }" @click="focusInput()">
                                            <span>Duration</span>
                                            <div
                                                class="flex justify-between items-center bg-gray-700 px-2 sm:px-4 rounded-lg cursor-pointer">
                                                <input type="text" name="duration" id="duration" x-ref="duration"
                                                    value="1" maxlength="2"
                                                    class="py-1 rounded-md w-5 bg-gray-700 text-sm outline-none" />
                                                <span class="text-sm">Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-5 px-5">
                                    <input class="w-64 sm:w-full" type="file" name="file" id="file" required>
                                    <button type="submit"
                                        class="bg-indigo-700 py-2 px-4 rounded-lg hover:bg-indigo-900">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="assignment" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body rounded-lg bg-gray-800 border border-indigo-500 p-0">
                            <div
                                class="flex justify-between items-center bg-gray-700 py-3 px-5 rounded-t-lg border-b border-indigo-500">
                                <div class="flex gap-x-3 items-center">
                                    <i class="fa fa-file-lines text-2xl"></i>
                                    <span class="text-2xl">Assignment</span>
                                </div>
                                <i
                                    class="fa fa-x uk-modal-close cursor-pointer px-[12px] py-[10px] rounded-full hover:bg-gray-800"></i>
                            </div>
                            <form action="/uploadAssignment" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="classId" id="classId" hidden value="{{ $class->id }}">
                                <div class="grid grid-cols-8 gap-5 p-5">
                                    <div class="col-span-6 flex flex-col gap-y-3">
                                        <input required type="text" name="title" id="title" placeholder="Title"
                                            class="w-full h-12 px-3 py-0 border border-indigo-500 rounded-md bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                        <input type="text" name="instructions" id="instructions"
                                            placeholder="Instructions (Optional)"
                                            class="w-full h-12 px-3 py-0 border border-indigo-500 rounded-md bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                    </div>
                                    <div class="col-span-2 flex flex-col items-center">
                                        <div class="flex flex-col" x-data="{ focusInput() { this.$refs.duration.focus(); } }" @click="focusInput()">
                                            <span>Duration</span>
                                            <div
                                                class="flex justify-between items-center bg-gray-700 px-2 sm:px-4 rounded-lg cursor-pointer">
                                                <input required type="text" name="duration" id="duration"
                                                    x-ref="duration" value="7" maxlength="2"
                                                    class="py-1 rounded-md w-5 bg-gray-700 text-sm outline-none" />
                                                <span class="text-sm">Days</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-5 px-5">
                                    <input class="w-64 sm:w-full" type="file" name="file" id="file" required>
                                    <button type="submit"
                                        class="bg-indigo-700 py-2 px-4 rounded-lg hover:bg-indigo-900">Assign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="material" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body rounded-lg p-0 bg-gray-800 border border-indigo-500">
                            <div
                                class="flex justify-between items-center bg-gray-700 py-3 px-5 rounded-t-lg border-b border-indigo-500">
                                <div class="flex gap-x-3 items-center">
                                    <i class="fa-regular fa-folder-open text-2xl"></i>
                                    <span class="text-2xl">Material</span>
                                </div>
                                <i
                                    class="fa fa-x uk-modal-close cursor-pointer px-[12px] py-[10px] rounded-full hover:bg-gray-800"></i>
                            </div>
                            <div class="flex flex-col gap-y-3 mx-5 mt-5">
                                <form class="flex flex-col gap-y-5" action="/uploadMaterial" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <input type="text" value="{{ $class->id }}" hidden name="classId"
                                            id="classId">
                                        <input required type="text" name="title" id="title" placeholder="Title"
                                            class="w-full h-12 px-3 border border-indigo-500 rounded-lg bg-gray-700 focus:outline-none focus:border-indigo-600" />
                                    </div>
                                    <div class="flex items-center justify-between mb-5">
                                        <input class="w-64" type="file" name="file" id="file" required>
                                        <button type="submit"
                                            class="bg-indigo-700 py-2 px-4 rounded-lg hover:bg-indigo-900">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!$materials && !$assignments && !$quizzes)
                    @if (auth()->user()->id == $class->teacherId)
                        <div class="flex flex-col justify-center items-center gap-y-1 mt-36">
                            <i class="fa-regular fa-file-lines text-7xl mb-3"></i>
                            <span class="text-lg">This is where you assign work</span>
                            <span class="text-center">You can add quizzes, assignments, and<br>study material for the
                                class</span>
                        </div>
                    @else
                        <div class="flex flex-col justify-center items-center gap-y-1 mt-36">
                            <i class="fa-regular fa-file-lines text-7xl mb-3"></i>
                            <span class="text-lg">No Work</span>
                        </div>
                    @endif
                @else
                    <div class="grid grid-cols-1 mx-auto mt-5">
                        <ul class="mb-5 w-full justify-center flex flex-col items-center gap-y-5">
                            @foreach ($materials as $material)
                                <div class=" p-4 w-72 sm:w-80 md:w-96 bg-gray-800 rounded-xl">
                                    <div class="flex justify-between items-center">
                                        <div class="flex gap-x-4 items-center">
                                            <i class="fa-regular fa-folder-open text-2xl"></i>
                                            <span>Material</span>
                                        </div>
                                        <span>{{ $material->created_at->format('d M') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>{{ $material->title }}</span>
                                        <i
                                            class="fa-solid fa-ellipsis-vertical px-3 py-2 rounded-full hover:bg-gray-700"></i>
                                        <div uk-dropdown="mode: click" class="bg-gray-600 text-white p-0">
                                            <ul>
                                                <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                    <a class=" hover:no-underline hover:text-white p-3 w-full text-center"
                                                        download href="{{ Storage::url($material->file) }}">Download</a>
                                                </li>
                                                @if (auth()->user()->id == $class->teacherId)
                                                    <li class="p-0 hover:bg-slate-700 flex justify-center cursor-pointer">
                                                        <form action="/deleteMaterial" method="post"
                                                            class="hover:bg-slate-700 w-full">
                                                            @csrf
                                                            <input type="text" name="materialId" id="materialId"
                                                                value="{{ $material->id }}" hidden>
                                                            <button class="p-3 w-full" type="submit">Delete</button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                        <ul class="mb-5 w-full justify-center flex flex-col items-center gap-y-5">
                            @foreach ($assignments as $assignment)
                                @php
                                    $submission = \App\Models\AssignmentSubmissions::where(
                                        'assignment_id',
                                        $assignment->id,
                                    )
                                        ->where('user_id', auth()->user()->id)
                                        ->first();
                                @endphp
                                <div class=" p-4 w-72 sm:w-80 md:w-96 bg-gray-800 rounded-xl">
                                    <div class="flex justify-between items-center pb-3">
                                        <div class="flex gap-x-4 items-center">
                                            <i class="fa-regular fa-file-lines text-2xl"></i>
                                            <span>Assignment</span>
                                        </div>
                                        @if ($submission)
                                            <span class="text-green-300">Submitted</span>
                                        @else
                                            <div class="flex flex-col md:flex-row gap-x-1">
                                                <span class="text-center">Due</span>
                                                <span>{{ \Carbon\Carbon::parse($assignment->created_at)->addDays($assignment->duration)->format('d M, h:i A') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center justify-between">
                                            <span>{{ $assignment->title }}</span>
                                            <i
                                                class="fa-solid fa-ellipsis-vertical px-3 py-2 rounded-full hover:bg-gray-700"></i>
                                            <div uk-dropdown="mode: click" class="bg-gray-600 text-white p-0">
                                                <ul>
                                                    <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                        @if (!$submission && auth()->user()->id != $class->teacherId)
                                                            <Button uk-toggle="target: #submitAssignment" type="button"
                                                                class=" hover:no-underline hover:text-white p-3 w-full text-center">Submit</Button>
                                                        @endif
                                                        <div id="submitAssignment" uk-modal>
                                                            <div
                                                                class="uk-modal-dialog uk-modal-body rounded-lg p-0 bg-gray-800 border border-indigo-500">
                                                                <div
                                                                    class="flex justify-between items-center bg-gray-700 py-3 px-5 rounded-t-lg border-b border-indigo-500">
                                                                    <div class="flex gap-x-3 items-center">
                                                                        <i class="fa-regular fa-file-lines text-2xl"></i>
                                                                        <span class="text-2xl">Submit Assignment</span>
                                                                    </div>
                                                                    <i
                                                                        class="fa fa-x uk-modal-close cursor-pointer px-[12px] py-[10px] rounded-full hover:bg-gray-800"></i>
                                                                </div>
                                                                <div class="flex flex-col gap-y-3 mx-5">
                                                                    <form class="flex flex-col gap-y-5"
                                                                        action="/submitAssignment" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div>
                                                                            <input type="text"
                                                                                value="{{ $assignment->id }}" hidden
                                                                                name="assignmentId" id="assignmentId">
                                                                        </div>
                                                                        <div
                                                                            class="flex items-center justify-between mb-5">
                                                                            <input class="w-64" type="file"
                                                                                name="file" id="file" required>
                                                                            <button type="submit"
                                                                                class="bg-indigo-700 py-2 px-4 rounded-lg hover:bg-indigo-900">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                        <a class=" hover:no-underline hover:text-white p-3 w-full text-center"
                                                            download
                                                            href="{{ Storage::url($assignment->file) }}">Download</a>
                                                    </li>
                                                    @if (auth()->user()->id == $class->teacherId)
                                                        <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                            <form action="/submissions" method="get">
                                                                <input type="text" value="{{ $class->id }}" hidden
                                                                    name="classId" id="classId">
                                                                <input type="text" value="assignment" hidden
                                                                    name="type" id="type">
                                                                <input type="text" value="{{ $assignment->id }}"
                                                                    hidden name="id" id="id">
                                                                <Button
                                                                    class=" hover:no-underline hover:text-white p-3 w-full text-center">Submissions</Button>
                                                            </form>
                                                        </li>
                                                        <li
                                                            class="p-0 hover:bg-slate-700 flex justify-center cursor-pointer">
                                                            <form action="/deleteAssignment" method="post"
                                                                class="hover:bg-slate-700 w-full">
                                                                @csrf
                                                                <input type="text" name="assignmentId"
                                                                    id="assignmentId" value="{{ $assignment->id }}"
                                                                    hidden>
                                                                <button class="p-3 w-full" type="submit">Delete</button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @if ($assignment->instructions)
                                            <div class="flex flex-col mt-2">
                                                <span class="font-semibold">Instructions</span>
                                                <span class="text-sm">{{ $assignment->instructions }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                        <ul class="mb-24 w-full justify-center flex flex-col items-center gap-y-5">
                            @foreach ($quizzes as $quiz)
                                @php
                                    $submission = \App\Models\QuizSubmissions::where('quiz_id', $quiz->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->first();
                                @endphp
                                <div class=" p-4 w-72 sm:w-80 md:w-96 bg-gray-800 rounded-xl">
                                    <div class="flex justify-between items-center pb-3">
                                        <div class="flex gap-x-4 items-center">
                                            <i class="fa-regular fa-file-code text-2xl"></i>
                                            <span>Quiz</span>
                                        </div>
                                        @if ($submission)
                                            <span class="text-green-300">Submitted</span>
                                        @else
                                            <div class="flex flex-col">
                                                <span class="text-center">Remaining</span>
                                                <span class="text-center">
                                                    @php
                                                        $dueTime = \Carbon\Carbon::parse($quiz->created_at)->addMinutes(
                                                            $quiz->duration * 60,
                                                        );
                                                        $remainingTime = floor(
                                                            \Carbon\Carbon::now()->diffInMinutes($dueTime, false),
                                                        );
                                                    @endphp

                                                    @if ($remainingTime > 0)
                                                        {{ $remainingTime }} min
                                                    @else
                                                        Time's up
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center justify-between">
                                            <span>{{ $quiz->title }}</span>
                                            <i
                                                class="fa-solid fa-ellipsis-vertical px-3 py-2 rounded-full hover:bg-gray-700"></i>
                                            <div uk-dropdown="mode: click" class="bg-gray-600 text-white p-0">
                                                <ul>
                                                    <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                        @if (!$submission && auth()->user()->id != $class->teacherId)
                                                            <Button uk-toggle="target: #submitQuiz" type="button"
                                                                class=" hover:no-underline hover:text-white p-3 w-full text-center">Submit</Button>
                                                        @endif
                                                        <div id="submitQuiz" uk-modal>
                                                            <div
                                                                class="uk-modal-dialog uk-modal-body rounded-lg p-0 bg-gray-800 border border-indigo-500">
                                                                <div
                                                                    class="flex justify-between items-center bg-gray-700 py-3 px-5 rounded-t-lg border-b border-indigo-500">
                                                                    <div class="flex gap-x-3 items-center">
                                                                        <i class="fa-regular fa-file-code text-2xl"></i>
                                                                        <span class="text-2xl">Submit Quiz</span>
                                                                    </div>
                                                                    <i
                                                                        class="fa fa-x uk-modal-close cursor-pointer px-[12px] py-[10px] rounded-full hover:bg-gray-800"></i>
                                                                </div>
                                                                <div class="flex flex-col gap-y-3 mx-5">
                                                                    <form class="flex flex-col gap-y-5"
                                                                        action="/submitQuiz" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div>
                                                                            <input type="text"
                                                                                value="{{ $quiz->id }}" hidden
                                                                                name="quizId" id="quizId">
                                                                        </div>
                                                                        <div
                                                                            class="flex items-center justify-between mb-5">
                                                                            <input class="w-64" type="file"
                                                                                name="file" id="file" required>
                                                                            <button type="submit"
                                                                                class="bg-indigo-700 py-2 px-4 rounded-lg hover:bg-indigo-900">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                        <a class=" hover:no-underline hover:text-white p-3 w-full text-center"
                                                            download href="{{ Storage::url($quiz->file) }}">Download</a>
                                                    </li>
                                                    @if (auth()->user()->id == $class->teacherId)
                                                        <li class=" hover:bg-slate-700 flex justify-center cursor-pointer">
                                                            <form action="/submissions" method="get">
                                                                <input type="text" value="{{ $class->id }}" hidden
                                                                    name="classId" id="classId">
                                                                <input type="text" value="quiz" hidden
                                                                    name="type" id="type">
                                                                <input type="text" value="{{ $quiz->id }}" hidden
                                                                    name="id" id="id">
                                                                <Button
                                                                    class=" hover:no-underline hover:text-white p-3 w-full text-center">Submissions</Button>
                                                            </form>
                                                        </li>
                                                        <li
                                                            class="p-0 hover:bg-slate-700 flex justify-center cursor-pointer">
                                                            <form action="/deletequiz" method="post"
                                                                class="hover:bg-slate-700 w-full">
                                                                @csrf
                                                                <input type="text" name="quizId" id="quizId"
                                                                    value="{{ $quiz->id }}" hidden>
                                                                <button class="p-3 w-full" type="submit">Delete</button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @if ($quiz->instructions)
                                            <div class="flex flex-col mt-2">
                                                <span class="font-semibold">Instructions</span>
                                                <span class="text-sm">{{ $quiz->instructions }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>

            <div x-cloak x-show="activeTab === 3" class='mx-8 flex flex-col gap-y-4'>
                <span class="pb-3 border-b border-indigo-500 text-2xl">Teacher</span>
                <div class='flex gap-x-4 items-center pl-2'>
                    @if ($teacherImage)
                        <img src="{{ Storage::url($teacherImage) }}" alt="Teacher Image" class="rounded-full w-10 h-10">
                    @else
                        <i class="fas fa-user text-xl px-4 py-2.5 rounded-full bg-gray-700 w-min"></i>
                    @endif
                    <span>{{ $class->teacherName }}</span>
                </div>
                <span class="pb-3 border-b border-indigo-500 text-2xl mt-5">Students</span>
                <div class='flex flex-col gap-y-5'>
                    @foreach ($users as $user)
                        <div class='flex gap-x-4 items-center pl-2'>
                            @if ($user->image)
                                <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}"
                                    class="rounded-full w-10 h-10">
                            @else
                                <i class="fas fa-user rounded-full px-[13px] py-[12px] bg-gray-700"></i>
                            @endif
                            <span>{{ $user->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
