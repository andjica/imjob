@extends('contributor.template-contributor')
@section('main-title', 'All Posts')
@section('title-dash', 'All Posts')

@section('css')
    <style>
        .edit-icon {
            cursor: pointer;
            transition: color 0.3s ease;
            background: #0093ff;
            border-radius: 100%;
            padding: 7px;
            margin-right: 2px;
            color: white !important;
            font-size: 16px;
        }

        .edit-icon:hover {
            color: #0056b3;
        }

        .delete-icon {
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            background: #c7535e;
            border-radius: 100%;
            padding: 7px;
            color: white !important;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;

        }

        .delete-icon:hover {
            background: #a71d2a;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="container m-0">
        @include('alerts.success')
        @include('alerts.errors')
        <div class="row">
            <div class="btn-back">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i
                        class="fa fa-chevron-left text-white"></i> Back</button>
            </div>
            @if ($posts->count() == 0)
                <div class="col-lg-7">
                    <div class="card card-flush shadow-sm mb-5">
                        <div class="card-body text-center">
                            <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <!-- Metronic SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path opacity="0.3"
                                            d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                            fill="currentColor" />
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No posts Found</h4>
                                    <p class="mb-0">There are currently no posts. Please <a
                                            href="{{ asset('/contributor/post/create') }}">create a new post.</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="col-lg-5">
                        <div class="card shadow-sm border mt-2">
                            <div class="d-flex justify-content-end m-2">
                                <a href="{{ asset('/contributor/post/' . $post->id . '/edit') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Edit">
                                    <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#statusModal" data-job="{{ $post->title }}"></i>
                                </a>
                                <!-- Delete Button (Triggers Modal) -->
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt delete-icon" data-bs-toggle="modal"
                                        data-bs-target="#deletePostModal{{ $post->id }}"></i>
                                </a>
                            </div>
                            <div class="card-body">
                            {!! $post->description !!}
                            <br>

                                @if ($post->image != null)
                                    <img src="{{ Storage::url($post->image) }}"
                                        alt="Image from contributor .{{ $post->image }}" width="100px" />
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="modal fade" id="deletePostModal{{ $post->id }}" tabindex="-1"
                            aria-labelledby="deletePostLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deletePostLabel{{ $post->id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the post?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ asset('/contributor/post/' . $post->id . '/delete') }}"
                                            method="POST">
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
