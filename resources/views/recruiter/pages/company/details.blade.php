@extends('recruiter.template-recruiter')
@section('main-title', 'Company detail')

@section('title-dash', 'Company Detail')
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('/css/custom/swiper.css') }}">
@endsection
@section('content')
    <div class="container m-0">
        <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2"> <i
                class="fa fa-chevron-left text-white"></i> Back</button>
        <div class="row mt-5">
            <!-- Company Information Card -->
            <div class="col-lg-10">
                <div class="card card-dashed shadow-sm">
                    <div class="card-header border-0 bg-light text-white">
                        <h3 class="card-title">
                            <i class="fas fa-building me-2 text-white"></i> Company Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Company Logo and Name -->
                        <div class="d-flex align-items-center mb-4">
                            @if (!empty($company->logo) && Storage::exists('public/' . $company->logo))
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}"
                                    class="rounded-circle me-3" width="60" height="60">
                            @else
                                <div
                                    class="symbol symbol-60px bg-light me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-0">{{ $company->name }}</h4>
                                <span class="badge badge-light">{{ $company->owner_title }}</span>
                            </div>
                        </div>
                        <!-- Company Details in Three Columns -->
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-city me-2 text-dark"></i>
                                    <span>From: <strong>{{ $company->country->name }},
                                            {{ $company->city->name ?? 'N/A' }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-tags me-2 text-muted"></i>
                                    <span>Category: <strong>{{ $company->category->name ?? 'N/A' }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-list-ul me-2 text-muted"></i>
                                    <span>Sub-Category: <strong>{{ $company->subCategory->name ?? 'N/A' }}</strong></span>
                                </div>
                            </div>
                            <!-- Column 2 -->
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-users me-2 text-muted"></i>
                                    <span>Employees: <strong>{{ $company->recruitersCount() }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope fs-5 text-muted me-2"></i>
                                    <span>Email: {{ $company->email }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone fs-5 text-muted me-2"></i>
                                    <span>Phone: {{ $company->phone_number }}</span>
                                </div>
                            </div>
                            <!-- Column 3 -->
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-id-badge fs-5 text-secondary me-2"></i>
                                    <span>Reg No: {{ $company->registration_number }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-receipt fs-5 text-muted me-2"></i>
                                    <span>Tax No: {{ $company->tax_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Optional: Action Buttons -->
                    <!--
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-primary">Edit</a>
                        <a href="#" class="btn btn-secondary">Delete</a>
                    </div>
                    -->
                </div>
                <!-- End Company Information Card -->
            </div>

            <!-- Buttons Column -->
            <div class="col-lg-1 d-none d-lg-flex flex-column align-items-left justify-content-start">
                @if (!$isOwnCompany)
                    @if ($isConnected === "Active")
                        <!-- Ako postoji zajednicka saradnja mora se prikazu dva buttons, jedan samo info da su konektovani drugi dole broj jobova ako ih ima da je recruter okacio -->
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="tooltip"
                            data-bs-placement="left" title="You are connected with this company">
                            <i class="fas fa-link"></i>
                        </button>
                        <!-- Broj jobova -->
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="tooltip"
                            data-bs-placement="left" title="Number of job is ">
                            0 <i class="fas fa-briefcase"></i>
                        </button>
                        @elseif($isConnected === "Pending")
                              <!-- PENDING: Reminder or Info -->
                            <button type="button" class="btn btn-warning btn-sm mb-2" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Connection request is pending approval">
                                <i class="fas fa-hourglass-half"></i> Pending
                            </button>
                            @elseif(empty($isConnected) || $isConnected === "None" || $isConnected === "0")

                        <button type="button" class="btn btn-success btn-sm mb-2 follow-button"
                            data-company-id="{{ $company->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Make connection, send request to this company"
                            aria-label="Connect with Company {{ $company->name }}">
                            <i class="fas fa-handshake"></i>
                        </button>
                    @endif
                @endif
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-10">
                <!-- Swiper -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        @foreach ($similarCompanies as $similarCompany)
                            @if ($company->id === $similarCompany->id)
                                @continue
                            @endif
                            <div class="swiper-slide">
                                <div class="company-block">
                                    <img src="{{ asset('/images/q-mark.png') }}" class="img-fluid" alt="Company A Logo">
                                    <h5>{{ $similarCompany->name }}</h5>
                                    <p><strong>Category:</strong> {{ $similarCompany->category->name }}</p>
                                    <p><strong>Subcategory:</strong> {{ $similarCompany->subCategory->name }}</p>
                                    <p><strong>Location:</strong> {{ $similarCompany->city->name }},
                                        {{ $similarCompany->country->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Swiper Navigation Buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Swiper Pagination (optional) -->
                    <div class="swiper-pagination"></div>
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
       document.addEventListener('DOMContentLoaded', function () {
    const followButtons = document.querySelectorAll('.follow-button');

    followButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const companyId = this.dataset.companyId;

            fetch("{{ route('recruiter-make-request-company') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ company_id: companyId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.remove('btn-success');
                    this.classList.add('btn-secondary');
                    this.setAttribute('disabled', true);
                    this.setAttribute('title', 'Request sent');
                    this.innerHTML = '<i class="fas fa-check"></i>';
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send request. Please try again.');
            });
        });
    });
});

    </script>
@endsection
