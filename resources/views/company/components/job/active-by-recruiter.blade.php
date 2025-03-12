<div class="row">
                @foreach($jobs as $job)
                <div class="col-lg-6 col-md-6 mb-4">
                <div class="card card-job">
                <div class="card-header">
                    <div>
                        @if($job->job_world_type == "international")
                            <span class="badge badge-primary mb-5">International</span>
                        @else
                            <span class="badge badge-warning mb-5">National</span>
                        @endif
                        <h5 class="card-title">{{$job->title}}</h5>
                        <p>This job is added to {{$job->recruiter->user->first_name}} {{$job->recruiter->user->last_name}} recruiter</p>
                        <p class="card-text">Location: {{$job->city->name}}, {{$job->country->name}}</p><br>
                        
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ asset('/company/job/'.$job->id.'/edit') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal" data-bs-target="#statusModal"
                                data-job="{{$job->title}}"></i>
                        </a>
                        <!-- Delete Button (Triggers Modal) -->
                        <a href="#"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="fas fa-trash-alt  delete-icon" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $job->id }}"></i>
                        </a>
                    </div>
                </div>

                    <div class="card-body">
                        <p class="card-text"><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($job->valid_until)->format('d F Y') }}</p>
                        <p class="card-text"><strong>Salary:</strong> {{$job->salary_min}} - {{$job->salary_max}} {{$job->country->currency_symbol}}</p>
                        <p class="card-text job-type">Job Type: {{$job->jobType->name}}</p>
                    </div>
            
                    <a href="{{asset('/company/dashboard/'.$job->id.'/recruitment-process')}}" class="btn btn-sm btn-light-primary">Go to recruitment process</a>

                </div>

                 <!-- Delete Confirmation Modal for each Job -->
                <div class="modal fade" id="deleteJobModal{{ $job->id }}" tabindex="-1" aria-labelledby="deleteJobLabel{{ $job->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteJobLabel{{ $job->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the job <strong>{{ $job->title }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{$jobs->links()}}
                </div>