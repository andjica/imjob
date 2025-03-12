@extends('recruiter.template-recruiter')

@section('title-dash', 'Contributor Detail')
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('/css/custom/swiper.css') }}">
@endsection
@section('content')
    <div class="container m-0">
        <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2"> <i
                class="fa fa-chevron-left text-white"></i> Back</button>
        <div class="row mt-5">
            <!-- Contributor Information Card -->
            <div class="col-lg-10">
                <div class="card card-dashed shadow-sm">
                    <div class="card-header border-0 bg-light text-white">
                        <h3 class="card-title">
                            <i class="fas fa-building me-2 text-white"></i> Contributor Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            @if (!empty($contributor->logo) && Storage::exists('public/' . $contributor->logo))
                                <img src="{{ asset('storage/' . $contributor->logo) }}" alt="{{ $contributor->name }}"
                                    class="rounded-circle me-3" width="60" height="60">
                            @else
                                <div
                                    class="symbol symbol-60px bg-light me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-0">{{ $contributor->name }}</h4>
                                <span class="badge badge-light">{{ $contributor->owner_title }}</span>
                            </div>
                        </div>
                        <!-- Contributor Details -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-city me-2 text-dark"></i>
                                    <span>From: <strong>{{ $contributor->country->name }},
                                            {{ $contributor->city->name ?? 'N/A' }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope fs-5 text-muted me-2"></i>
                                    <span>Email: <strong>{{ $contributor->email }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tags me-2 text-muted"></i>
                                    <span>Type: <strong>
                                            @if ($contributor->custom_contributor_type != null)
                                                {{ $contributor->custom_contributor_type }}
                                            @else
                                                {{ $contributor->contributorType->name }}
                                            @endif
                                        </strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        const swiper = new Swiper('.mySwiper', {
            // Optional parameters
            loop: true,
            slidesPerView: 3,
            spaceBetween: 30,

            // Responsive breakpoints
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Accessibility
            a11y: true,
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all follow buttons
            const followButtons = document.querySelectorAll('.follow-button');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const companyId = this.dataset.companyId;
                    const indicatorLabel = this.querySelector('.indicator-label');
                    const indicatorProgress = this.querySelector('.indicator-progress');
                    const icon = this.querySelector('i.ki-check');

                    // Show loading state
                    indicatorLabel.classList.add('d-none');
                    indicatorProgress.classList.remove('d-none');

                    // Send AJAX request using Fetch API
                    fetch("{{ route('recruiter-make-request-contributor') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                company_id: companyId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
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
