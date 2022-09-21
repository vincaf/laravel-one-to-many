@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('delete'))
                    <div class="alert alert-warning">
                        "{{ session('delete') }}" was successfully removed.
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Author</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <th scope="row">
                                    <a href="{{ route('admin.posts.show', $post->slug) }}">
                                        {{ $post->id }}
                                    </a>
                                </th>
                                <td>{{ $post->author }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td>
                                    {{ $post->post_date }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-sm btn-success">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                        class="form-post-delete" data-post-name="{{ $post->title }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger my-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are no posts available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        const deleteFormElements = document.querySelectorAll('.form-post-delete');
        deleteFormElements.forEach(
            formElement => {
                formElement.addEventListener('submit', function(event){
                    const name = this.getAttribute('data-post-name');
                    event.preventDefault();
                    const result = window.confirm(`Are you sure you want to delete "${name}"?`);
                    if(result) this.submit();
                })
            }
        )
    </script>
@endsection
