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
                        <a href="{{ route('profile.show', $post->user->id_user) }}" class="font-medium hover:underline">
                            {{$post->user->name}}
                        </a>
                    </div>
                    <div class="right">
                        <i class="ri-more-fill"></i>
                    </div>
                </div>
                <div class="card-content">
                    <img src="{{ route('image.show', $post->image) }}" alt="" class="w-full">
                    <div class="flex">
                        <p class="mt-5 px-4 font-medium"> {{ $post->user->name}}</p>
                        <p class="mt-5 px-4 ml-[-18px]"> {{ $post->text }} </p>
                    </div>
                </div>
                <div class="card-action px-4 mt-[-5px] flex items-center gap-4">
                    <div class="flex items-center gap-1">
                        <button class="like-btn" data-post-id="{{ $post->id_post }}" 
                                data-is-liked="{{ $post->is_liked ? 'true' : 'false' }}">
                            <i class="ri-heart-{{ $post->is_liked ? 'fill text-red-500' : 'line' }}"></i>
                        </button>
                        <p class="like-count">{{ $post->like_count }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="comment-toggle-btn" data-post-id="{{ $post->id_post }}">
                            <i class="ri-chat-1-line"></i>
                        </button>
                        <p class="comment-count">{{ $post->comment_count }}</p>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section px-4" id="comments-{{ $post->id_post }}">
                    <!-- Existing Comments -->
                    <div class="comments-list mb-3" data-loaded-count="{{ $post->comments->count() }}">
                        @foreach($post->comments as $comment)
                        <div class="comment-item mb-2">
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            <span class="text-gray-700">{{ $comment->comment }}</span>
                            <span class="text-xs text-gray-500 block">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($post->has_more_comments)
                    <button class="load-more-comments text-gray-500 text-sm mb-3" data-post-id="{{ $post->id_post }}" data-offset="{{ $post->comments->count() }}">
                        View more comments ({{ $post->comment_count - $post->comments->count() }} remaining)
                    </button>
                    @endif
                    
                    <!-- Comment Form -->
                    <div class="comment-form flex items-center gap-2 border-t pt-3">
                        <input type="text" 
                               class="comment-input flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               placeholder="Add a comment..." 
                               data-post-id="{{ $post->id_post }}">
                        <button class="submit-comment-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                                data-post-id="{{ $post->id_post }}">
                            Post
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-btn');
            
            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const isLiked = this.getAttribute('data-is-liked') === 'true';
                    const heartIcon = this.querySelector('i');
                    const likeCount = this.parentElement.querySelector('.like-count');
                    
                    const url = isLiked ? `/post/${postId}/unlike` : `/post/${postId}/like`;
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.like_count !== undefined) {
                            likeCount.textContent = data.like_count;
                            
                            if (data.is_liked) {
                                heartIcon.className = 'ri-heart-fill text-red-500';
                                this.setAttribute('data-is-liked', 'true');
                            } else {
                                heartIcon.className = 'ri-heart-line';
                                this.setAttribute('data-is-liked', 'false');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
            
            // Comment toggle functionality
            const commentToggleButtons = document.querySelectorAll('.comment-toggle-btn');
            commentToggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const commentsSection = document.querySelector(`#comments-${postId}`);
                    commentsSection.classList.toggle('hidden');
                });
            });
            
            // Load more comments functionality
            const loadMoreButtons = document.querySelectorAll('.load-more-comments');
            loadMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const offset = parseInt(this.getAttribute('data-offset'));
                    const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
                    
                    fetch(`/post/${postId}/comments?offset=${offset}&limit=10`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.comments.length > 0) {
                            data.comments.forEach(comment => {
                                const commentDiv = document.createElement('div');
                                commentDiv.className = 'comment-item mb-2';
                                commentDiv.innerHTML = `
                                    <span class="font-semibold">${comment.user_name}</span>
                                    <span class="text-gray-700">${comment.comment}</span>
                                    <span class="text-xs text-gray-500 block">${comment.created_at}</span>
                                `;
                                commentsList.appendChild(commentDiv);
                            });
                            
                            // Update offset
                            this.setAttribute('data-offset', offset + data.comments.length);
                            
                            // Update button text or hide if no more comments
                            if (!data.has_more) {
                                this.style.display = 'none';
                            } else {
                                const remaining = data.total - (offset + data.comments.length);
                                this.textContent = `View more comments (${remaining} remaining)`;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more comments:', error);
                    });
                });
            });
            
            // Submit comment functionality
            const submitCommentButtons = document.querySelectorAll('.submit-comment-btn');
            submitCommentButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const commentInput = document.querySelector(`input[data-post-id="${postId}"]`);
                    const commentText = commentInput.value.trim();
                    
                    if (commentText === '') {
                        alert('Please enter a comment');
                        return;
                    }
                    
                    fetch(`/post/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            comment: commentText
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success && data.comment) {
                            // Add new comment to the comments list
                            const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
                            const newComment = document.createElement('div');
                            newComment.className = 'comment-item mb-2';
                            newComment.innerHTML = `
                                <span class="font-semibold">${data.comment.user_name}</span>
                                <span class="text-gray-700">${data.comment.comment}</span>
                                <span class="text-xs text-gray-500 block">${data.comment.created_at}</span>
                            `;
                            commentsList.insertBefore(newComment, commentsList.firstChild);
                            
                            // Update comment count
                            const commentButton = document.querySelector(`button.comment-toggle-btn[data-post-id="${postId}"]`);
                            const commentCountElement = commentButton.parentElement.querySelector('.comment-count');
                            if (data.comment_count) {
                                commentCountElement.textContent = data.comment_count;
                            } else {
                                const currentCount = parseInt(commentCountElement.textContent);
                                commentCountElement.textContent = currentCount + 1;
                            }
                            
                            // Clear input
                            commentInput.value = '';
                            
                            // Show comments section if hidden
                            const commentsSection = document.querySelector(`#comments-${postId}`);
                            if (commentsSection.classList.contains('hidden')) {
                                commentsSection.classList.remove('hidden');
                            }
                        } else {
                            console.error('Server response:', data);
                            alert(data.message || 'Error adding comment');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error adding comment: ' + error.message);
                    });
                });
            });
            
            // Allow Enter key to submit comment
            const commentInputs = document.querySelectorAll('.comment-input');
            commentInputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const postId = this.getAttribute('data-post-id');
                        const submitButton = document.querySelector(`button.submit-comment-btn[data-post-id="${postId}"]`);
                        submitButton.click();
                    }
                });
            });
        });
    </script>
@endsection