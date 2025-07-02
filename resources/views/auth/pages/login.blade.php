@extends('auth.layout.auth')

@section('auth')
<section class="flex flex-col gap-10 justify-center items-center h-screen">
    <div class="mt-[-50px]">
        <h1 class="text-2xl font-bold text-center mb-4">InstaAPP Login</h1>
        <p class="text-center text-gray-600">Please enter your email and password to login.</p>
    </div>
    <form action="{{ route('login.authenticate')}}" method="POST" class="w-md mx-auto">
        @csrf
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="mail@gmail.com" required />
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
            <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Login</button>
    </form>
</section>
@endsection