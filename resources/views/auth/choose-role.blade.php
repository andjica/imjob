@extends('auth.template-auth')
@section('css')
<style>
    .role-option.active-role {
        background-color: #f3f6f9;
        border-color: #3699ff;
        box-shadow: 0px 0px 8px rgba(54, 153, 255, 0.5);
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-20">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white text-center py-4">
                <h2 class="mb-1">One More Step!</h2>
                <p class="mb-0">Choose your role to continue setting up your account.</p>
            </div>
        </div>
        <div class="card card-bordered">
            <div class="card-header">
                <h3 class="card-title">Select Your Role</h3>
            </div>
            <div class="card-body">
                <form action="{{route('choose-role-update')}}" method="POST">
                    @csrf

                    <div class="mb-10">
                        <label class="form-label">Choose your role</label>
                        <div class="d-flex align-items-center justify-content-between role-selection-group">
                            <!-- Recruiter -->
                            <label class="btn btn-outline btn-outline-dashed btn-outline-primary d-flex align-items-center px-4 py-3 me-3 w-50 role-option">
                                <input type="radio" name="roleId" value="3" class="btn-check" />
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-user-tie fs-2 me-3"></i>
                                    <span>
                                        <span class="fw-bold text-dark d-block">Recruiter / Freelancer</span>
                                        <span class="text-gray-600">As a recruiter, manage recruitment tasks for a single company or handle hiring across multiple organizations.</span>
                                    </span>
                                </span>
                            </label>

                            <!-- Company -->
                            <label class="btn btn-outline btn-outline-dashed btn-outline-success d-flex align-items-center px-4 py-3 w-50 role-option">
                                <input type="radio" name="roleId" value="2" class="btn-check" />
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-building fs-2 me-3"></i>
                                    <span>
                                        <span class="fw-bold text-dark d-block">Company</span>
                                        <span class="text-gray-600">Manage your jobs and employees </span><br>
                                        <span class="text-gray-600">Collaborate seamlessly with other recruiters within your organization to streamline your hiring processes and achieve shared goals.</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        @error('role')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> Confirm Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select all role-option elements
        const roleOptions = document.querySelectorAll('.role-option');

        roleOptions.forEach(option => {
            // Add a click event listener to each role-option
            option.addEventListener('click', () => {
                // Remove active class from all role-options
                roleOptions.forEach(opt => opt.classList.remove('active-role'));

                // Add active class to the clicked role-option
                option.classList.add('active-role');
            });
        });
    });
</script>


@endsection