@extends('users.layout.user')

@section('users')
    <section class="w-full flex justify-center bg-gray-100 h-screen items-start">
        <div class="flex items-center justify-center w-[500px] px-4 py-5 bg-white fixed">
            <h1 class="text-2xl font-bold">Post</h1>
        </div>
        <div class="mt-20 bg-white w-md p-4">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 text-green-700 bg-green-100 border border-green-300 rounded-lg">
                    <i class="ri-check-line mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded-lg">
                    <i class="ri-error-warning-line mr-2"></i>{{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded-lg">
                    <i class="ri-error-warning-line mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('post.store')}}" method="POST" enctype="multipart/form-data" id="postForm">
                @csrf
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="image">Upload Image</label>
                    <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="user_avatar_help" id="image" type="file" accept="image/*" required>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <img id="previewImg" src="" alt="Preview" class="max-w-full h-auto max-h-64 rounded-lg border">
                        <button type="button" id="removeImage" class="mt-2 text-red-600 hover:text-red-800 text-sm">
                            <i class="ri-delete-bin-line mr-1"></i>Remove Image
                        </button>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Caption</label>
                    <textarea id="text" name="text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="What's on your mind?" maxlength="500" required>{{ old('text') }}</textarea>
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="charCount">0</span>/500 characters
                    </div>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" id="submitBtn">
                    <i class="ri-send-plane-line mr-2"></i>Submit Post
                </button>
        </form>
        </div>
        
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeImageBtn = document.getElementById('removeImage');
            const textArea = document.getElementById('text');
            const charCount = document.getElementById('charCount');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('postForm');

            // Image preview functionality
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file');
                        imageInput.value = '';
                        return;
                    }

                    // Check file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size must be less than 10MB');
                        imageInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('hidden');
                }
            });

            // Remove image functionality
            removeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.classList.add('hidden');
                previewImg.src = '';
            });

            // Character count for caption
            textArea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > 500) {
                    charCount.classList.add('text-red-500');
                } else {
                    charCount.classList.remove('text-red-500');
                }
            });

            // Form submission with loading state
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line mr-2 animate-spin"></i>Posting...';
            });

            // Initialize character count
            charCount.textContent = textArea.value.length;
        });
    </script>
@endsection