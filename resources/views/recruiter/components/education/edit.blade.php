<!-- Div card for recruiter education edit -->
<div class="row">
    <div class="col-lg-10">
        <!-- Recruiter Education Card -->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h3>Edit Recruiter Education</h3>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-3">
                <form action="{{route('recruiter-education-update')}}" method="POST" id="recruiterEducationEditForm">
                    @csrf

                    <!-- School -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">School</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control form-control-lg form-control-solid @error('school') is-invalid @enderror" 
                                name="school" id="school" placeholder="Enter the name of the school or university" 
                                value="{{ old('school', $recruiter->education->school ?? '') }}" />
                            <div class="form-text">Provide the full name of the educational institution.</div>
                            <span class="text-danger" id="schoolEmpty">@error('school'){{ $message }} @enderror</span>
                        </div>
                    </div>

                    <!-- Degree -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Degree</label>
                        <div class="col-lg-10">
                            <input type="text" id="degree" class="form-control form-control-lg form-control-solid @error('degree') is-invalid @enderror" 
                                name="degree" placeholder="e.g., Bachelor, Master, PhD" 
                                value="{{ old('degree', $recruiter->education->degree ?? '') }}" />
                            <div class="form-text">Specify the type of degree earned (e.g., Bachelor of Science).</div>
                            <span class="text-danger" id="degreeEmpty">@error('degree'){{ $message }} @enderror</span>
                        </div>
                    </div>

                    <!-- Field of Study -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Field of Study</label>
                        <div class="col-lg-10">
                            <input type="text" id="fieldOfStudy" class="form-control form-control-lg form-control-solid @error('field_of_study') is-invalid @enderror" 
                                name="fieldOfStudy" placeholder="e.g., Computer Science, Business Administration" 
                                value="{{ old('field_of_study', $recruiter->education->field_of_study ?? '') }}" />
                            <div class="form-text">Enter the major or field of study, if applicable.</div>
                            <span class="text-danger" id="fieldOfStudyEmpty">@error('fieldOfStudy'){{ $message }} @enderror</span>
                        </div>
                    </div>

                    <!-- Year of Graduation -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Year of Graduation</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control form-control-lg form-control-solid @error('year_of_graduation') is-invalid @enderror" 
                                name="yearOfGraduation" id="yearOfGraduation" placeholder="e.g., 2022" 
                                value="{{ old('year_of_graduation', $recruiter->education->year_of_graduation ?? '') }}" min="1900" max="{{ now()->year }}" />
                            <div class="form-text">Specify the year you completed your studies.</div>
                            <span class="text-danger" id="yearOfGraduationEmpty">@error('year_of_graduation'){{ $message }} @enderror</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control form-control-lg form-control-solid @error('description') is-invalid @enderror" 
                                name="description" id="description" rows="4" placeholder="Add any additional details about your education">{{ old('description', $recruiter->education->description ?? '') }}</textarea>
                            <div class="form-text">Optional: Add any additional information about your education (e.g., achievements, projects).</div>
                            <span class="text-danger" id="descriptionEmpty">@error('description'){{ $message }} @enderror</span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Education Info</button>
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
