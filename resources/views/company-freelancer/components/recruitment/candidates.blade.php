<div class="card card-custom">
    <div class="card-header flex-wrap py-5">
        <div class="card-title">
            <h3 class="card-label">
                Candidates
                <div class="text-muted pt-2 font-size-sm">Candidates who reply to your job</div>
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
                        <span class="font-weight-bold text-dark">{{ $candidate->user->getFirstName()  }}</span>
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
                        <!-- Action Buttons -->
                        @if ($candidate->status === 'pending')
                            <div class="d-flex">
                                <!-- Accept Button -->
                                <a href="javascript:;" 
                                class="btn btn-sm btn-light-success btn-icon mx-1 accept-btn" 
                                data-candidate-name="{{ $candidate->user->getFirstName() }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#acceptCandidateModal"
                                title="Accept Candidate">
                                    <i class="fa-solid fa-check"></i>
                                </a>

                                <!-- Reject Button -->
                                <a href="javascript:;" 
                                class="btn btn-sm btn-light-danger btn-icon mx-1 reject-btn" 
                                data-candidate-name="{{ $candidate->user->getFirstName() }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#rejectCandidateModal"
                                title="Reject Candidate">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                            </div>
                        @elseif($candidate->status === 'accept')
                            <div class="d-flex">
                                <a href="javascript:;" class="btn btn-sm btn-light-primary btn-icon mx-1" title="Edit Details">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-light-danger btn-icon mx-1" title="Delete">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </a>
                                <a href="{{ asset('/company/freelancer/job/candidate/' . $candidate->id . '/recruitment-process') }}" class="btn btn-sm bg-linear-orange text-white d-flex align-items-center" title="Go to Recruitment Process">
                                    <i class="fa-solid fa-clipboard-list text-white"></i>
                                    Process
                                </a>
                            </div>
                        @else
                            <i class="fa-solid fa-xmark fa-xl text-danger"></i>
                        @endif
                    </td>
                </tr>
                @include('company-freelancer.components.recruitment.accept-reject-modal-popup')
            @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>


