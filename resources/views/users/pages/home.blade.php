@extends('users.layout.user')

@section('users')
    <section class="flex flex-col w-full items-center bg-gray-100 pb-16">
        <div class="flex items-center justify-between w-[500px] px-4 py-5 bg-white fixed">
            <h1 class="text-2xl font-bold">Instagram</h1>
            <i class="ri-send-plane-fill text-2xl"></i>
        </div>
        <div class="p-3 flex flex-col gap-2 pt-20">
            @foreach ($posts as $post)
            <div class="card w-full bg-white flex flex-col gap-4 rounded-lg pb-4">
                <div class="card-profile p-4 flex items-center justify-between gap-3">
                    <div class="left flex items-center gap-3">
                        <img src="{{ asset('img/profile.jpg') }}" alt="" class="w-10 rounded-full">
                        <p>Latansa Bima</p>
                    </div>
                    <div class="right">
                        <i class="ri-more-fill"></i>
                    </div>
                </div>
                <div class="card-content">
                    <img src="{{ route('image.show', $post->image) }}" alt="" class="w-full">
                    <p class="mt-3 px-4">{{ $post->text }}</p>
                </div>
                <div class="card-action px-4 py-1 flex items-center gap-4">
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
        </div>
        
    </section>
@endsection