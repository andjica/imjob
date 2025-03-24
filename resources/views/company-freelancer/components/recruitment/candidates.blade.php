@if($job->candidates->count() == 0)
<div class="row">
    <div class="col-lg-12">
        <div class="card card-flush shadow-sm mb-5">
            <div class="card-body text-center">
                <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                    <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                        <!-- Metronic SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                            <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1">No Candidates Yet</h4>
                        <p class="mb-0 mt-2">
                            Currently, there are no job seekers who have applied for this position via the mobile app. 
                            Stay patient as potential candidates discover and express interest in your job posting.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div class="card card-custom">
    <div class="card-header flex-wrap py-5">
        <div class="card-title">
            <h3 class="card-label">
                Candidates
                <div class="text-muted pt-2 font-size-sm">Candidates who reply to this job</div>
            </h3>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table  table-head-custom table-checkable border-top">
            <thead>
            <tr>
                <th>Candidate</th>
                <th>From</th>
                <th>Years of experience</th>
                <th>CV</th>
                <th>Status</th>
                <th style="width: 20%">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($candidates as $candidate)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <!-- Profile Image -->
                            <div class="symbol symbol-50 symbol-light-info mr-5">
                                <img src="{{ asset('/images/300-12.jpg') }}" class="img-fluid rounded-circle" alt="Profile Image" width="50">
                            </div>
                            <!-- Name and Company -->
                            <div>
                                <span class="text-dark font-weight-bold d-block">{{ $candidate->user->getFirstName()  }}</span>
                                <a class="text-muted text-hover-primary font-weight-normal" href="mailto:alarkingg@elegantthemes.com">
                                    <small>{{ $candidate->user->email  }}</small>
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!-- Full Name -->
                        <span class="font-weight-bold text-dark">{{ $candidate->country->name }}, {{$candidate->city->name}}</span>
                    </td>
                    <td>
                        <!-- Full Name -->
                        <span class="font-weight-bold text-dark">{{ $candidate->years_of_experience}}</span>
                    </td>
                    <td>
                        <!-- PDF Link -->
                        <a href="#" class="text-danger">
                            <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                        </a>
                    </td>
                    <td>
                        <!-- Status -->
                        @if ($candidate->status === 'pending')
                            <span class="badge badge-light-warning  py-2 px-4 rounded-pill">
                                {{ $candidate->status }}
                            </span>
                        @elseif($candidate->status === 'accept')
                            <!-- Status -->
                            <span class="badge badge-light-success  py-2 px-4 rounded-pill">
                                Acepted
                            </span>
                        @else
                            <span class="badge badge-light-danger  py-2 px-4 rounded-pill">
                                X Rejected
                            </span>
                        @endif
                    </td>

                    <td>
                    @if ($candidate->status === 'pending')
                        <div class="d-flex">
                            <!-- Accept Button -->
                            <a href="javascript:;" 
                            class="btn btn-sm btn-light-success btn-icon mx-1 accept-btn" 
                            data-candidate-id="{{ $candidate->id }}" 
                            data-bs-toggle="modal" 
                            data-bs-target="#acceptCandidateModal-{{ $candidate->id }}"
                            title="Accept Candidate">
                                <i class="fa-solid fa-check"></i>
                            </a>

                            <!-- Reject Button -->
                            <a href="javascript:;" 
                            class="btn btn-sm btn-light-danger btn-icon mx-1 reject-btn" 
                            data-candidate-id="{{ $candidate->id }}" 
                            data-bs-toggle="modal" 
                            data-bs-target="#rejectCandidateModal-{{ $candidate->id }}"
                            title="Reject Candidate">
                                <i class="fa-solid fa-trash-alt"></i>
                            </a>
                        </div>
                        @elseif($candidate->status === 'reject')

                        @else
                        <a href="{{asset('company/freelancer/job/candidate/'.$candidate->id.'/recruitment-process')}}" class="btn btn-sm bg-linear-pink text-white fw-light">Go to recruitment process</a>
                    @endif
                </td>
              
                </tr>
                
               
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>

@include('company-freelancer.components.recruitment.accept-reject-modal-popup')
@endif