@php use App\Models\User; @endphp
@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Find companies')

@section('title-dash', 'Find Companies')
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
                <form action="{{ route('company-freelancer-find-companies') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Search by company name, country, city, address" value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <!-- Company Cards -->
        <div class="row g-6">
            @forelse($companies as $company)
            @if($company->id === auth()->user()->company->id)
                @continue  {{-- Preskačemo svoju kompaniju --}}
            @endif
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <div class="card-toolbar">
                                <a href="{{asset('/company/freelancer/company/'.$company->id.'/details')}}" class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2">View profile</a>
                            </div>
                            @php
                                /** @var User $user */
                                $user = auth()->user();
                            @endphp
                            @if($connectedOnPending->contains($company->id))
                                <div class="card-toolbar">
                                <button type="button" class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2 bg-light-warning" data-bs-toggle="tooltip" data-bs-placement="left" title="You have to wait for company aproval">
                                    <i class="fas fa-hourglass-half"></i> Connection on Pending
                                </button>

                                </div>
                            @elseif($connectedSuccessfully->contains($company->id))
                            <!-- This button is shown if the company is connected and the status is active -->
                            <div class="card-tolbar">
                                <button type="button" class="btn btn-primary btn-sm mt-4" data-bs-toggle="tooltip" data-bs-placement="left" title="You are connected with this company">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                            @elseif($user->company->id == $company->id)
                            @else
                                <div class="card-toolbar">
                                    <a href="#"
                                       class="btn btn-sm btn-light-primary me-2 mb-2 follow-button"
                                       id="kt_user_follow_button_{{ $company->id }}"
                                       data-company-id="{{ $company->id }}">
                                        <i class="ki-duotone ki-check fs-3 d-none"></i>
                                        <!-- Indicator label -->
                                        <span class="indicator-label">    <i class="fas fa-paper-plane"></i>Send request</span>
                                        <!-- Indicator progress -->
                                        <span class="indicator-progress d-none">
                                        Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <strong>{{$company->name}}</strong><br>
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo" class="h-50px rounded img-fluid">
                            @else
                                <i class="fas fa-building text-muted fa-2x"></i> <!-- Fallback Icon -->
                            @endif
                            <br>
                            <br>
                            <u>{{ $company->category->name }}</u><small>- {{$company->subCategory->name}} - </small><br>
                            Type of company - {{ $company->companyType->name }},<i> <br>From {{ $company->city->name }}, {{ $company->country->name }} </i>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No companies found matching your search criteria.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row mt-2">
            <div class="col-12 d-flex justify-content-left">
                {{ $companies->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all follow buttons
            const followButtons = document.querySelectorAll('.follow-button');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                
                    event.preventDefault();

                    const companyId = this.dataset.companyId;
                    //var andjica = $(this).data('company-id');
                    alert(companyId);
                    const indicatorLabel = this.querySelector('.indicator-label');
                    const indicatorProgress = this.querySelector('.indicator-progress');
                    const icon = this.querySelector('i.ki-check');

                    // Show loading state
                    indicatorLabel.classList.add('d-none');
                    indicatorProgress.classList.remove('d-none');

                    // Send AJAX request using Fetch API
                    fetch('{{ route("company-freelancer-make-request") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ company_id: companyId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success){
                                // Update button to indicate success
                                indicatorLabel.textContent = 'Request Sent';
                                indicatorLabel.classList.remove('d-none');
                                indicatorProgress.classList.add('d-none');
                                icon.classList.remove('d-none');
                                this.classList.remove('btn-light');
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
