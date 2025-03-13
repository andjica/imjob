<div class="col-lg-3" id="kt_sidebar_menu">
<!--begin::Card-->
    <div class="card card-custom card-stretch">
        <!--begin::Body-->
        <div class="card-body px-4">
            <!--begin:Nav-->
            <div class="navi navi-hover navi-active navi-link-rounded navi-bold">
                
                <!--begin:Item-->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <div class="navi-icon mr-3">
                            <i class="fa flaticon2-inbox icon-lg text-primary"></i>
                        </div>
                        <div>
                            <span class="text-dark font-weight-bold font-size-md">Currently Aplied for Jobs</span>
                            <div class="text-muted font-size-sm">All candidates who are interested in this job</div>
                        </div>
                    </div>
                    <span class="badge badge-light-primary font-weight-bold px-3 py-2">{{$job->candidates->count()}}</span>
                </div>
                <!--end:Item-->

                <!--begin:Item-->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                    
                        <div>
                            <span class="text-success font-weight-bold font-size-md">Currently Employed    
                                <i class="fa fa-briefcase icon-lg text-info"></i>
                            </span>
                            <div class="text-muted font-size-sm">Candidates who are employed for this job</div>
                        </div>
                    </div>
                    <span class="badge badge-light-success font-weight-bold px-3 py-2">{{$job->hiredCandidatesCount()}}</span>
                </div>
                <!--end:Item-->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                    
                        <div>
                            <span class="text-danger font-weight-bold font-size-md">Currently Rejected  
                            <i class="fa-solid fa-xmark icon-lg text-info"></i>                           
                            </span>
                            <div class="text-muted font-size-sm">Rejected candidates</div>
                        </div>
                    </div>
                    <span class="badge badge-light-danger font-weight-bold px-3 py-2">{{$job->rejectedCandidates->count()}}</span>
                </div>

            </div>
            <!--end:Nav-->
        </div>
        <!--end::Body-->
    </div>
    
<!--end::Card-->
</div>
