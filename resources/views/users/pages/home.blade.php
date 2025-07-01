@extends('users.layout.user')

@section('users')
    <section class="flex flex-col w-full items-center ">
        @foreach ($posts as $post)
        <div class="card w-[400px] bg-gray-200 px-4 py-2 flex flex-col gap-4 border-b border-gray-400">
            <div class="card-profile flex items-center justify-between gap-3">
                <div class="left flex items-center gap-3">
                    <img src="{{ asset('img/profile.jpg') }}" alt="" class="w-10 rounded-full">
                    <p>Latansa Bima</p>
                </div>
                <div class="right">
                    <i class="ri-more-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <img src="{{ route('image.show', $post->image) }}" alt="" class="rounded-2xl">
                <p class="mt-3">{{ $post->text }}</p>
            </div>
            <div class="card-action flex items-center gap-5">
                <div class="flex items-center gap-1">
                    <i class="ri-heart-line"></i>
                    <p>10</p>
                </div>
                <div class="flex items-center gap-1">
                    <i class="ri-chat-1-line"></i>
                    <p>5</p>
                </div>
            </div>
        </div>
        @endforeach
    </section>
@endsection