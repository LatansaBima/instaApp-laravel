@extends('users.layout.user')

@section('users')
    <section class="w-full flex flex-col justify-center">
        <div class="top-profile w-full px-4">
            <div class="profile-action flex items-center w-full justify-between py-6">
                <div class="flex items-center gap-3">
                    @if(isset($isOwnProfile) && !$isOwnProfile)
                        <a href="{{ route('profile.index') }}" class="text-blue-500 hover:underline">
                            <i class="ri-arrow-left-line text-xl"></i>
                        </a>
                    @endif
                    <p class="text-lg font-semibold">{{ $user->name }}</p>
                </div>
                @if(!isset($isOwnProfile) || $isOwnProfile)
                    <i class="ri-settings-3-line text-2xl"></i>
                @endif
            </div>
            <div class="profile-stats flex mt-2">
                <div class="w-[90px]">
                    <img src="{{ asset('/img/profile.jpg')}}" alt="" class="size-[90px] rounded-full">
                </div>
                <div class="flex-1 flex justify-start items-center gap-12 pl-8">
                    <div class="text-center">
                        <p class="font-bold">{{$posts->count()}}</p>
                        <p>Post</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold">518</p>
                        <p>Followers</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold">400</p>
                        <p>Following</p>
                    </div>
                </div>
            </div>
            <div class="mt-6 font-medium">
                <p class="font-extrabold text-lg">{{ $user->name }} | Engineer</p>
                <p class="font-light">Welcome to My Instagram Guys!</p>
                <div class="mt-4 w-full flex">
                    @if(!isset($isOwnProfile) || $isOwnProfile)
                        <!-- Own profile buttons -->
                        <button type="button" class=" w-[50%] text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Edit Profile</button>
                        <form action="{{ route('logout') }}" method="POST" class="w-[50%]">
                            @csrf
                            <button type="submit" class=" w-full text-black bg-white border border-gray-500 hover:bg-gray-500 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Logout</button>
                        </form>
                    @else
                        <!-- Other user's profile buttons -->
                        <button type="button" class=" w-[50%] text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Follow</button>
                        <button type="button" class=" w-[50%] text-black bg-white border border-gray-500 hover:bg-gray-500 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Message</button>
                    @endif
                </div>
            </div>
            <div class="mt-5 flex gap-8">
                <div class="bg-white border flex items-center justify-center rounded-full size-[65px]">
                    <i class="ri-add-line text-xl"></i>
                </div>
                <div class="bg-gray-600 border border-gray-400 rounded-full size-[65px]"></div>
                <div class="bg-gray-600 border border-gray-400 rounded-full size-[65px]"></div>
                <div class="bg-gray-600 border border-gray-400 rounded-full size-[65px]"></div>
                <div class="bg-gray-600 border border-gray-400 rounded-full size-[65px]"></div>
            </div>
        </div>
        <div class="profile-post w-full flex-1 grid grid-cols-3 grid-rows-[auto_1fr_auto] gap-1 mt-8 bg-gray-100">
                @foreach ($posts as $post)
                <div class="border border-gray-200">
                    <img src="{{ route('image.show', $post->image)}}" alt="" class="h-full w-full object-cover">
                </div>
                @endforeach
        </div>    
    </section>
@endsection