@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('created'))
            <div class="alert alert-success">
                "{{ session('created') }}" was successfully created.
            </div>
        @endif
        @if (session('edited'))
            <div class="alert alert-success">
                "{{ session('edited') }}" was successfully edited.
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="card my-3" style="max-width: 850px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $post->post_image }}" alt="{{ $post->post_title }}" class="img-fluid rounded-start" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="mb-2"><strong>{{ $post->title }}</strong></h3>
                            <p><strong>Author:</strong> {{ $post->author }}</p>
                            <p>{{ $post->post_content }}</p>
                            <p><strong>Post Date:</strong> {{ $post->post_date }}</p>
                            <div class="mt-5 d-flex">
                                <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-sm btn-success">
                                    Edit post
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                    class="form-post-delete" data-post-name="{{ $post->title }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger mx-2">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        const deleteFormElements = document.querySelectorAll('.form-post-delete');
        deleteFormElements.forEach(
            formElement => {
                formElement.addEventListener('submit', function(event) {
                    const name = this.getAttribute('data-post-name');
                    event.preventDefault();
                    const result = window.confirm(`Are you sure you want to delete "${name}"?`);
                    if (result) this.submit();
                })
            }
        )
    </script>
@endsection
