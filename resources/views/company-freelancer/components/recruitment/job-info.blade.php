<div class="col-lg-9 col-md-8">
    <div class="card card-custom shadow-lg" id="job-card">
        <div class="card-header bg-secondary text-white bg-linear-orange-opacity">
            <h3 class="card-title  text-white d-flex align-items-center">
            <i class="fas fa-heading icon-style text-white fa-3x"></i>&nbsp; Senior Software Developer
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Column 1 -->
                <div class="col-md-4">
                    
                    <div class="info-item mb-3">
                        <i class="fas fa-building icon-style"></i>
                        <div class="info-text">
                            <strong>Company:</strong>
                            <p class="text-muted">{{$job->company->name}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-user-tie icon-style"></i>
                        <div class="info-text">
                            <strong>Recruiter:</strong>
                            <p class="text-muted">@if($job->recruiter->name == null) This job post is from {{$job->company->name}} company @else{{$job->recruiter->name}} @endif</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-list icon-style"></i>
                        <div class="info-text">
                            <strong>Category:</strong>
                            <p class="text-muted">{{$job->category->name}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-tags icon-style"></i>
                        <div class="info-text">
                            <strong>SubCategory:</strong>
                            <p class="text-muted">{{$job->subCategory->name}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-briefcase icon-style"></i>
                        <div class="info-text">
                            <strong>Job Type:</strong>
                            <p class="text-muted">{{$job->jobType->name}}</p>
                        </div>
                    </div>
                    
                </div>
                <!-- Column 2 -->
                <div class="col-md-4">
                    <div class="info-item mb-3">
                        <i class="fas fa-file-alt icon-style"></i>
                        <div class="info-text">
                            @php
                                $safeDescription = truncateHtml($job->description, 200);
                            @endphp

                            <strong>Description:</strong>
                            <div class="text-muted">
                                <div class="job-description">
                                    {{-- Truncated version --}}
                                    <span id="short-description">
                                        {!! $safeDescription !!}
                                    </span>

                                    {{-- Full version (hidden initially) --}}
                                    <span id="full-description" style="display: none;">
                                        {!! $job->description !!}
                                    </span>

                                    {{-- Toggle links --}}
                                    @if(strlen(strip_tags($job->description)) > 200)
                                        <a href="javascript:void(0);" id="read-more" onclick="toggleDescription()">Read More</a>
                                        <a href="javascript:void(0);" id="show-less" onclick="toggleDescription()" style="display: none;">Show Less</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-map-marker-alt icon-style"></i>
                        <div class="info-text">
                            <strong>Location:</strong>
                            <p class="text-muted">{{$job->city->name}}, {{$job->country->name}}</p>
                        </div>
                    </div>
                    
                </div>
                <!-- Column 3 -->
                <div class="col-md-4">
                <div class="info-item mb-3">
                        <i class="fas fa-dollar-sign icon-style"></i>
                        <div class="info-text">
                            <strong>Salary Range:</strong>
                            <p class="text-muted">{{$job->salary_min}} - {{$job->salary_max}} {{$job->country->currency_symbol}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-user-graduate icon-style"></i>
                        <div class="info-text">
                            <strong>Experience Level:</strong>
                            <p class="text-muted">{{$job->experience_level}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-tools icon-style"></i>
                        <div class="info-text">
                            <strong>Required Skills:</strong>
                            <p class="text-muted">Required skill: {{$job->skills->first()->skill}}</p>
                        </div>
                    </div>
                    @if($job->skills->count() > 1)
                    <div class="info-item mb-3">
                        <i class="fas fa-tools icon-style"></i>
                        <div class="info-text">
                            <strong>Optional Skills:</strong>
                            <ul>
                                @foreach ($job->skills as $key => $skill)
                                    @if ($key > 0) {{-- Skip the first skill --}}
                                        <li class="text-muted">{{ $skill->skill }}</li> 
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="info-item mb-3">
                        <i class="fas fa-birthday-cake icon-style"></i>
                        <div class="info-text">
                            <strong>Age Range:</strong>
                            <p class="text-muted">{{$job->min_age}}-{{$job->max_age}}</p>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <i class="fas fa-calendar-alt icon-style"></i>
                        <div class="info-text">
                            <strong>Valid Until:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($job->valid_until)->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Optional: Additional Information or Sections -->
        </div>
    </div>
    </div>