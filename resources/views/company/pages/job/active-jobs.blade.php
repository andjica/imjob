@extends('company.template-company')

@section('main-title', 'Active Jobs')

@section('title-dash', 'This is active on mobile app')

@section('css')
  <link rel="stylesheet" href="{{asset('/css/custom/job-card.css')}}">
@endsection

@section('content')
<div class="container m-0">
         <!-- Quick Search Form -->
         <div class="row mb-6">
            <div class="col-12">
               <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i class="fa fa-chevron-left text-white"></i> Back</button>

                <form action="" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="You can search job by Company name, Country name, City name, Category name, SubCategory name, national, international.." value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">Search</button><br>
                </form>
            </div>
        </div>
        @include('alerts.success')
        @include('alerts.errors')
       
        
        <!-- Active Job Cards -->
        <div class="row">
            <!-- Card  -->
            <div class="col-lg-3">
                @include('company.components.job.sidebar-job')
            </div>
             <div class="col-lg-9">
             @if($jobs->count() == 0)
             
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
                                    <h4 class="mb-1">No jobs Found</h4>
                                    <p class="mb-0">There are currently no active jobs in the system. Please <a href="{{asset('/company/dashboard/job/create')}}">create a new job.</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
             
                    @else
                <div class="row">
                    @foreach($jobs as $job)
                    <div class="col-lg-5 col-md-6 mb-4">
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
                                @if($job->candidates->count() > 0)
                                <i class="fas fa-check-circle text-success fa-2x" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="This job has received applications from candidates and is currently in the recruitment process">
                                    </i>
                                        
                                @endif
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
             </div>
            <!-- End card -->
        </div>
        @endif
</div>
@endsection

@section('js')

@endsection
