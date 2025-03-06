@extends('contributor.template-contributor')

@section('content')
@section('title-dash', 'Recruiters')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-muted text-white pt-10">
                    <h3 class="card-title mt-3">Recruiters List</h3><br>
                    <hr>
                    <p class="text-muted fs-6">
                        Here, you can find and connect with top-tier recruiters to help you grow your team and achieve
                        your business goals.
                        Simply browse the list of available recruiters, make a request, and wait for their response.
                        It's that easy!
                    </p>
                    <p class="text-muted fs-6">
                        Once you’ve sent a request to a recruiter, the status will show as
                        <span class="fw-semibold text-warning">Pending</span>. This means the recruiter has not yet
                        responded to your request.
                        Please allow some time for them to review and accept your invitation.
                    </p>
                    <p class="text-muted fs-6">
                        Once a recruiter accepts your request, you’ll be notified, and you can start collaborating to
                        build the team your company deserves.
                    </p>

                </div>

                <div class="card-body p-4">
                    <div class="card-header p-0" id="kt_contacts_list_header">
                        <!--begin::Form-->
                        @if (request('search'))
                            <form method="GET" action="{{ route('company-dashboard-find-recruiters') }}">
                                <button type="submit" class="btn btn-primary mb-3 btn-sm">
                                    <i class="fa-solid fa-chevron-left"></i> Back to All Recruiters
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('company-dashboard-find-recruiters') }}" method="GET"
                            class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                            <!--begin::Icon-->
                            <i
                                class="fas fa-search fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                            <!--end::Icon-->

                            <!--begin::Input-->
                            <input type="text" id="searchRecruiter" class="form-control form-control-solid ps-13"
                                name="search" value="{{ old('search', request('search')) }}"
                                placeholder="Search recruiter by first name, last name, email, title, company name">
                            <!--end::Input-->
                        </form>
                        <!--end::Form-->
                    </div>
                    @if ($recruiters->count() === 0)
                        <div class="card card-flush shadow-sm mb-5">
                            <div class="card-body text-center">
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                    <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path opacity="0.3"
                                                d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                                fill="currentColor" />
                                            <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <div class="d-flex flex-column">

                                        <h4 class="mb-1">No Recruiters Found</h4>
                                        <p class="mb-0">There are currently no active recruiters in the system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach ($recruiters as $recruiter)
                                <div class="d-flex flex-stack pt-2 border-bottom">
                                    <!--begin::Image-->
                                    <div class="symbol symbol-40px me-5">
                                        @if ($recruiter->profile_image)
                                            <img src="{{ asset(Storage::url($recruiter->profile_image)) }}"
                                                alt="Profile Image" class="img-fluid rounded-circle shadow-sm"
                                                style="width: 60px; height: 60px;"> <!-- Smaller size here -->
                                        @else
                                            <img src="{{ asset('images/user-286.png') }}" alt="Profile Image"
                                                class="img-fluid rounded-circle shadow-sm"
                                                style="width: 60px; height: 60px;">
                                        @endif
                                    </div>
                                    <!--end::Image-->

                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <!--begin:Recruiter-->
                                        <div class="flex-grow-1 me-2">
                                            <h5 class="card-title">{{ $recruiter->user->first_name }}
                                                {{ $recruiter->user->last_name }}</h5>

                                            <span
                                                class="text-muted fw-semibold d-block fs-7">{{ $recruiter->title_function }}</span>
                                            <p class="text-muted">{{ $recruiter->user->email }}</p>

                                        </div>
                                        @php
                                            /** @var User $user */
                                            $user = auth()->user();
                                        @endphp

                                        <!-- Recruiter Status Check -->
                                        @if ($connectedOnPending->contains('id', $recruiter->id))
                                            <div class="card-toolbar">
                                                <button type="button"
                                                    class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2 bg-light-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="You have to wait for company approval">
                                                    <i class="fas fa-hourglass-half"></i> Connection on Pending
                                                </button>
                                            </div>
                                        @elseif($connectedSuccessfully->contains('id', $recruiter->id))
                                            <!-- This button is shown if the recruiter is connected and the status is active -->
                                            <div class="card-toolbar">
                                                <button type="button" class="btn btn-primary btn-sm mt-4"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="You are connected with this company">
                                                    <i class="fas fa-link"></i>
                                                </button>
                                            </div>
                                        @elseif(isset($user->recruiter) && $user->recruiter->id == $recruiter->id)
                                            <!-- If the logged-in recruiter is viewing themselves, do nothing -->
                                        @else
                                            <!-- Default action for recruiters not pending, active, or self -->
                                            <button type="button" data-recruiter-id="{{ $recruiter->id }}"
                                                data-status="Pending"
                                                class="btn btn-sm btn-light-primary me-2 mb-2 follow-button">
                                                Follow
                                            </button>
                                        @endif

                                        <!--end:Action-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $recruiters->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>

            </div>
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

                const recruiterId = this.dataset.recruiterId;
                const status = this.dataset.status;
                // Send AJAX request using Fetch API
                fetch('{{ route('contributor-make-request') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            recruiter_id: recruiterId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button to indicate success
                            button.textContent = 'Request Sent';
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-success');
                            button.disabled = true;
                        } else {
                            throw new Error(data.message || 'Something went wrong.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert loading state
                        // indicatorLabel.classList.remove('d-none');
                        // indicatorProgress.classList.add('d-none');
                        alert(error.message || 'Failed to send request. Please try again.');
                    });
            });
        });
    });
</script>
@endsection
