 <!-- Company Selection Modal (As defined earlier) -->
 <div class="modal fade" id="companyModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="fw-bolder">Company Information</h2>
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
              <!-- Close Icon -->
              <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                  <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                  <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"/>
                </svg>
              </span>
            </div>
          </div>
          <div class="modal-body">
            <form id="companyForm">
              <div class="mb-10">
                <label for="companyName" class="form-label">For which company is this job being posted?</label>
                <input type="text" class="form-control form-control-solid" id="companyName" name="companyName" required />
                <div id="companyNameEmpty" class="text-danger mt-2" style="display: none;"></div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmCompany">Confirm</button>
          </div>
        </div>
      </div>
    </div>