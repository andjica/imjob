@php use App\Models\User; @endphp
@extends('company-freelancer.template-company-freelancer')

@section('main-title', 'Find Contributor')
@section('title-dash', 'Find Contributor')

@section('css')
    <style>
        .custom-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 0.15em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }

        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <div class="container m-0 pb-5">
        <!-- Quick Search Form -->
        <div class="row mb-6">
            <div class="col-12">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i class="fa fa-chevron-left text-white"></i> Back</button>
                <form action="{{ route('company-freelancer-find-contributors') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Search by contributor name..." value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <!-- Contributor Cards -->
        <div class="row g-6">
            @forelse($contributors as $contributor)
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <div class="card-toolbar">
                                <a href="{{ asset('/company/freelancer/contributor/'.$contributor->id.'/details') }}" class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2">View Profile</a>
                            </div>
                            
                            @php
                                /** @var User $user */
                                $user = auth()->user();
                            @endphp
                            
                            @if($connectedOnPending->contains($contributor->id))
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2 bg-light-warning" data-bs-toggle="tooltip" data-bs-placement="left" title="You have to wait for approval">
                                        <i class="fas fa-hourglass-half"></i> Connection on Pending
                                    </button>
                                </div>
                            @elseif(!$connectedSuccessfully->contains($contributor->id))
                                <div class="card-toolbar">
                                    <a href="#"
                                       class="btn btn-sm btn-light-primary me-2 mb-2 follow-button"
                                       id="follow_button_{{ $contributor->id }}"
                                       data-contributor-id="{{ $contributor->id }}">
                                        <i class="ki-duotone ki-check fs-3 d-none"></i>
                                        <span class="indicator-label">   
                                            <i class="fas fa-paper-plane"></i> Send Request
                                        </span>
                                        <span class="indicator-progress d-none">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @if($connectedSuccessfully->contains($contributor->id))
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-primary btn-sm mt-4" data-bs-toggle="tooltip" data-bs-placement="left" title="You are connected with this contributor">
                                        <i class="fas fa-link"></i> Connected
                                    </button>
                                </div>
                            @endif
                        </div>
        	   
                        <div class="card-body">
                            <strong>{{ $contributor->name }}</strong><br>
                            Contributor email: {{$contributor->email}}<br>
                            @if($contributor->contributorType->name == "Other(Specify)")
                            {{$contributor->custom_contributor_type}}
                            @else
                            <u>{{ $contributor->contributorType->name }}</u><br>
                            @endif
                            <i> From {{ $contributor->city->name }}, {{ $contributor->country->name }} </i>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No contributors found matching your search criteria.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row mt-2">
            <div class="col-12 d-flex justify-content-left">
                {{ $contributors->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const followButtons = document.querySelectorAll('.follow-button');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const contributorId = this.dataset.contributorId;
                   
                    const indicatorLabel = this.querySelector('.indicator-label');
                    const indicatorProgress = this.querySelector('.indicator-progress');
                    const icon = this.querySelector('i.ki-check');

                    // Show loading state
                    indicatorLabel.classList.add('d-none');
                    indicatorProgress.classList.remove('d-none');

                    // Send AJAX request
                    fetch('{{ route("company-freelancer-follow-contributor") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ follow_id: contributorId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success){
                                // Update button to indicate success
                                indicatorLabel.textContent = 'Request Sent';
                                indicatorLabel.classList.remove('d-none');
                                indicatorProgress.classList.add('d-none');
                                icon.classList.remove('d-none');
                                this.classList.remove('btn-light-primary');
                                this.classList.add('btn-success');
                                this.removeEventListener('click', arguments.callee);
                            } else {
                                throw new Error(data.message || 'Something went wrong.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revert loading state
                            indicatorLabel.classList.remove('d-none');
                            indicatorProgress.classList.add('d-none');
                            alert(error.message || 'Failed to send request. Please try again.');
                        });
                });
            });
        });
    </script>
@endsection
