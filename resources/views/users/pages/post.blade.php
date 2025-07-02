@extends('users.layout.user')

@section('users')
    <section class="w-full flex justify-center bg-gray-100 h-screen items-start">
        <div class="flex items-center justify-center w-[500px] px-4 py-5 bg-white fixed">
            <h1 class="text-2xl font-bold">Post</h1>
        </div>
        <div class="mt-20 bg-white w-md p-4">
            <form action="{{ route('post.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="image">Upload Image</label>
                    <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="user_avatar_help" id="image" type="file">
                </div>
                <div class="mb-5">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Caption</label>
                    <textarea id="text" name="text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Type something..."></textarea>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
        </form>
        </div>
        
    </section>
@endsection