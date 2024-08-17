@extends('components.layout')
@section('sidebar-content')
    @if ($enrolled->isEmpty())
        <span class="text-2xl text-white">You are not enrolled in any class</span>
    @else
        <div class="grid  grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-10 gap-y-8">
            @foreach ($enrolled as $class)
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
                    $gradient = $colors[$loop->index % count($colors)];
                @endphp
                <a href='/class/{{ $class->classCode }}'
                    class="hover:no-underline hover:text-current hover:shadow-xl hover:shadow-indigo-900 hover:-translate-y-2 duration-200  rounded-lg border-indigo-500 border overflow-hidden transition-all">
                    <div class="flex flex-col h-96">
                        <div
                            class="bg-gradient-to-r {{ $gradient }} p-5 flex flex-col gap-y-2 border-indigo-500 border-b text-sm">
                            <span class='text-lg font-medium'>{{ $class->className }}</span>
                            <span>{{ $class->section }}</span>
                            <span>{{ $class->teacherName }}</span>
                        </div>
                        <img src="/images/bg.webp" alt="">
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
