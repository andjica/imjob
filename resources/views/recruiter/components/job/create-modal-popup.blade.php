<!-- Company Selection Modal -->
<div class="modal fade" id="companyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Increased modal size for better layout -->
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="fw-bolder">For which company is this job being posted?</h2>
          <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
            <!-- Close Icon -->
            <span class="svg-icon svg-icon-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"/>
              </svg>
            </span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row gx-9 gy-6">
            <!-- Iterate through companies -->
            @foreach($recruiterWithCompanies as $company)
            <div class="col-xl-6" data-kt-billing-element="card">
              <!-- Card with radio button -->
              <div class="card card-dashed h-xl-100 p-6 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-start">
                  <!-- Radio Button -->
                  <div class="form-check me-4">
                    <input class="form-check-input" type="radio" name="selectedCompany" id="company{{ $company->id }}" value="{{ $company->id }}">
                  </div>
                  <!-- Company Info -->
                  <div class="d-flex flex-column">
                    <div class="d-flex align-items-center fs-4 fw-bold mb-2">
                      {{ $company->name }}
                      <span class="badge badge-light-success fs-7 ms-2">Connected</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <img src="{{ $company->logo ? asset('storage/' . $company->logo) : asset('images/q-mark.png') }}" alt="{{ $company->name }} Logo" class="me-4" width="100px">
                      <div>
                        <div class="fs-4 fw-bold">{{ $company->category->name }}, {{ $company->subCategory->name }}</div>
                        <div class="fs-6 fw-semibold text-gray-500">{{ $company->country->name }}, {{ $company->city->name }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
           
                <!-- Add Company Card -->
                <div class="col-xl-6">
                <div class="card card-dashed h-xl-100 p-6 d-flex align-items-center justify-content-center">
                  <div class="text-center">
                    <h4 class="text-gray-900 fw-bold mb-3"><i class="fas fa-building me-2 fa-3x" aria-label="Company Icon" title="Company"></i>
                     Add a New Company</h4>
                    <button type="button" class="btn btn-primary px-6" id="addCompanyButton">
                      Add Company
                    </button>
                  </div>
                </div>
              </div>
              <!-- End of Add Company Card -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmCompany">Confirm</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Alert Modal (New Modal) -->
  <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
         <div class="modal-body text-center">
          <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>
          <p class="mt-5">Are you certain you want to exit this page?<br> Any unsaved changes to your job post will be lost.</p>
          <p>You can view all existing companies by clicking the button below.</p>
          </div>
          <div class="modal-footer">
            <a href="{{route('recruiter-find-companies')}}" class="btn btn-primary">View All Companies</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>