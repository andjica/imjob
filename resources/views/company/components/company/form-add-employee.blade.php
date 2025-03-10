<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add Employee</h3>
    </div>
    <div class="card-body">
    <form action=" {{ route('company-dashboard-follow-change-status') }}" method="POST">
    @csrf
            <div class="mb-3">
                <label for="recruiter" class="form-label">Select Recruiter:</label>
                <!-- Recruiter -->
                <div class="row mb-5">
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Recruiter:</label>
                    <div class="col-lg-8">
                    <select name="recruiter_id" id="recruiter_id" data-control="select2"
                        class="form-control form-control-solid @error('recruiterId') is-invalid @enderror">
                        <option value="">Select a Recruiter</option>
                        @foreach ($recruiters as $recruiter)
                        @php
                            $image = $recruiter->profile_image 
                                ? asset('storage/uploads/recruiters/' . basename($recruiter->profile_image)) 
                                : asset('images/user-profile.png');
                        @endphp
                        <option value="{{ $recruiter->id }}" 
                                data-img="{{ $image }}"
                                data-country="{{ $recruiter->country->name ?? '' }}"
                                data-city="{{ $recruiter->city->name ?? '' }}">
                            {{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}
                        </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="company_id" value="{{auth()->user()->company->id}}">
                    <input type="hidden" name="status" value="Active">
                        <span class="text-danger" id="recruiterIdEmpty">@error('recruiterId'){{ $message }}@enderror</span>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
</div>