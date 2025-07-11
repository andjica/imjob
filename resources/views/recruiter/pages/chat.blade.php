@extends('recruiter.template-recruiter')
@section('main-title', 'Chat with All - Candidates and Contributors')

@section('title-dash', 'Chat')
@section('css')
@endsection

@section('content')
    <div class="container m-0">
        <div class="row">
            <div class="col-lg-12">
                @if ($contributors->count() == 0 && $candidates->count() == 0)
                    <div class="card card-flush shadow-sm mb-5">
                        <div class="card-body text-center">
                            <div class="alert alert-warning d-flex justify-content-center p-5 mb-0">
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
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="mb-1">No contributor found or candidates, you don't have any connections</h4>
                                    <p>Please follow contributor for makeing connections or contact your candidate, on page <a
                                            href="{{ asset('/company/freelancer/find/contributors') }}">find
                                            contributors</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="app">
                        <chat-component-recruiter-all :contributors='@json($contributors ?? [])'
                            :candidates='@json($candidates ?? [])' :current-user-id='@json(auth()->check() ? auth()->user()->id : null)'>
                        </chat-component-recruiter-all>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script></script>
@endsection
