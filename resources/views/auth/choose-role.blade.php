@extends('auth.template-auth')

@section('css')
<style>
    .role-option.active-role {
        background-color: #f3f6f9;
        border-color: #3699ff;
        box-shadow: 0px 0px 8px rgba(54, 153, 255, 0.5);
    }
    .role-selection-group {
        flex-wrap: wrap;
        gap: 20px;
    }
    .role-option {
        flex: 1 1 calc(33.333% - 20px);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-20">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-purple text-white text-center py-4">
                    <h2 class="mb-1 text-white">One More Step!</h2>
                    <p class="mb-0">Choose your role to continue setting up your account.</p>
                </div>
            </div>
            <div class="card card-bordered">
                <div class="card-header">
                    <h3 class="card-title">Select Your Role</h3>
                </div>
                <div class="card-body">
                    <form id="form-role" action="{{ route('choose-role-update') }}" method="POST">
                        @csrf

                        <div class="mb-10">
                            <label class="form-label">Choose your role</label>
                            <div class="d-flex align-items-stretch justify-content-between role-selection-group">
                                <!-- Recruiter -->
                                <label class="btn btn-outline btn-outline-dashed btn-outline-primary d-flex align-items-center px-4 py-3 role-option">
                                    <input type="radio" name="roleId" value="3" class="btn-check" />
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-user-tie fs-2 me-3"></i>
                                        <span>
                                            <span class="fw-bold text-dark d-block">Recruiter / Freelancer</span>
                                            <span class="text-gray-600">Manage recruitment tasks across one or more companies with flexibility.</span>
                                        </span>
                                    </span>
                                </label>

                                <!-- Company -->
                                <label class="btn btn-outline btn-outline-dashed btn-outline-success d-flex align-items-center px-4 py-3 role-option">
                                    <input type="radio" name="roleId" value="2" class="btn-check" />
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-building fs-2 me-3"></i>
                                        <span>
                                            <span class="fw-bold text-dark d-block">Company</span>
                                            <span class="text-gray-600">Organize hiring and team management with internal collaboration.</span>
                                        </span>
                                    </span>
                                </label>

                                <!-- Contributor -->
                                <label class="btn btn-outline btn-outline-dashed btn-outline-warning d-flex align-items-center px-4 py-3 role-option">
                                    <input type="radio" name="roleId" value="4" class="btn-check" />
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-user-plus fs-2 me-3"></i>
                                        <span>
                                            <span class="fw-bold text-dark d-block">Contributor</span>
                                            <span class="text-gray-600">Support your recruiter or company by actively participating in the hiring process and communication.</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            @error('roleId')
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
</div>
@endsection


@section('js')
<script>
    $(document).ready(function () {
        const roleOptions = $('.role-option');
        const radioButtons = $('input[name="roleId"]');

        roleOptions.on('click', function () {
            roleOptions.removeClass('active-role');
            $(this).addClass('active-role');

            const input = $(this).find('input[type="radio"]');
            if (input.length) {
                input.prop('checked', true);
            }

            $('#role-error').remove(); // Ukloni poruku ako postoji
        });

        $('#form-role').on('submit', function (e) {
            const selected = radioButtons.is(':checked');

            if (!selected) {
                e.preventDefault(); // Blokiraj submit

                if ($('#role-error').length === 0) {
                    const errorMsg = $('<div>', {
                        class: 'text-danger mt-2 text-center',
                        id: 'role-error',
                        text: 'Please select a role before continuing.'
                    });

                    $('.mb-10').append(errorMsg);
                    errorMsg[0].scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>
@endsection


