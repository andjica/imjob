<div class="row">
    <div class="col-lg-10">
        <!-- Profile Information Card -->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h3>Profile Information</h3>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-3">
                <form action="{{ route('recruiter-update') }}" id="recruiterForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Profile Image -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Profile Image</label>
                        <div class="col-lg-10">
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('{{ asset('storage/' . $recruiter->profile_image) }}')">
                                @if (!empty($recruiter->profile_image) && Storage::exists('public/' . $recruiter->profile_image))
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url('{{ asset('storage/' . $recruiter->profile_image) }}')">
                                    </div>
                                @else
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url('{{ asset('images/user-286.png') }}')"></div>
                                @endif
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" title="Change profile image">
                                    <i class="fas fa-pencil-alt fs-7"></i>
                                    <input type="file" name="profile_image" id="profile_image"
                                        accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="profile_image_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" title="Remove profile image">
                                    <i class="fas fa-times fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <span class="text-danger invalid-feedback" id="profile_imageEmpty"></span>
                        </div>
                    </div>
                    <!-- Personal Information -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label required fw-bold fs-6">First Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                name="first_name" value="{{ $recruiter->user->first_name }}" />
                            <span class="text-danger invalid-feedback" id="firstNameEmpty"></span>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label required fw-bold fs-6">Last Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                name="last_name" value="{{ $recruiter->user->last_name }}" />
                            <span class="text-danger invalid-feedback" id="lastNameEmpty"></span>
                        </div>
                    </div>
                    <!-- Birthday -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label required fw-bold fs-6">Birthday</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control form-control-lg form-control-solid" id="birthday"
                                name="birthday" value="{{ $recruiter->birthday }}" />
                            <span class="text-danger invalid-feedback" id="birthdayEmpty"></span>
                        </div>
                    </div>
                    <!-- Title Function -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label required fw-bold fs-6">Title Function</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                id="titleFunction" name="title_function" value="{{ $recruiter->title_function }}" />
                            <span class="text-danger invalid-feedback" id="titleFunctionEmpty"></span>
                        </div>
                    </div>
                    <!-- Experience Level -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Experience Level</label>
                        <div class="col-lg-10">
                            <select name="experience_level" id="experience_level"
                                class="form-control form-control-lg form-control-solid">
                                <option value="junior" {{ $recruiter->experience_level == 'junior' ? 'selected' : '' }}>
                                    Junior</option>
                                <option value="mid" {{ $recruiter->experience_level == 'mid' ? 'selected' : '' }}>
                                    Mid</option>
                                <option value="senior"
                                    {{ $recruiter->experience_level == 'senior' ? 'selected' : '' }}>Senior</option>
                            </select>
                            <span class="text-danger invalid-feedback" id="experienceLevelEmpty"></span>
                        </div>
                    </div>
                    <!-- Availability -->
                    <div class="row mb-3">
                        <label for="availability" class="col-lg-2 col-form-label text-end fw-bold">
                            <i class="fas fa-clock text-primary me-2"></i> Availability
                        </label>
                        <div class="col-lg-10">
                            <select name="availability" id="availability"
                                class="form-control form-control-solid @error('availability') is-invalid @enderror">
                                <option value="">Select Availability</option>
                                <option value="morning" {{ $recruiter->availability == 'morning' ? 'selected' : '' }}>
                                    Morning (8 AM - 12 PM)</option>
                                <option value="afternoon"
                                    {{ $recruiter->availability == 'afternoon' ? 'selected' : '' }}>Afternoon (12 PM -
                                    5 PM)</option>
                                <option value="evening" {{ $recruiter->availability == 'evening' ? 'selected' : '' }}>
                                    Evening (5 PM - 9 PM)</option>
                                <option value="full_day"
                                    {{ $recruiter->availability == 'full_day' ? 'selected' : '' }}>Full Day</option>
                            </select>
                            <span class="text-danger" id="availabilityEmpty">
                                @error('availability')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    @php
                        use Illuminate\Support\Str;

                        $prefix = $recruiter->country && $recruiter->country->phone_code
                            ? '+' . trim($recruiter->country->phone_code)
                            : '+';

                        $numberWithoutPrefix = Str::startsWith($recruiter->phone_number, $prefix)
                            ? Str::replaceFirst($prefix, '', $recruiter->phone_number)
                            : $recruiter->phone_number;
                    @endphp
                         <!-- Country -->
                         <div class="row mb-5">
                            <label class="col-lg-2 col-form-label fw-bold fs-6 required">Country:</label>
                            <div class="col-lg-10">
                                <select name="countryId" id="countryId" data-control="select2" 
                                    class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                                    <option value="{{$recruiter->country_id}}">{{$recruiter->country->name}}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('countryId') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                               
                                <span class="text-danger" id="countryIdEmpty"> @error('countryId'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>

                        <!-- City -->
                        <div class="row mb-5">
                            <label class="col-lg-2 col-form-label fw-bold fs-6 required">City:</label>
                            <div class="col-lg-10">
                                <select name="cityId" id="cityId" data-control="select2"
                                    class="form-control form-control-solid @error('cityId') is-invalid @enderror">
                                    <option value="{{$recruiter->city_id}}">{{$recruiter->city->name}}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('cityId') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="cityEmpty">@error('cityId'){{ $message }}@enderror</span>
                            </div>
                        </div>
                    <!-- Phone Number -->
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Phone Number:</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                            <span class="input-group-text border-end border-2 border-gray-300" id="phoneCodeDisplay">{{ $prefix }}</span>
                            <input type="text"
                                    class="form-control form-control-solid"
                                    id="phoneNumber"
                                    name="phone_number"
                                    value="{{ $numberWithoutPrefix }}"
                                    required
                                    aria-describedby="phoneCodeDisplay" />
                            </div>
                            <span class="text-danger" id="phoneNumberEmpty">@error('phoneNumber'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Profile Info</button>
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
