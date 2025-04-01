<div class="col-md-6">
    <div class="card mb-5 mb-xl-10 border-end">
        <!--begin::Card header-->
        <div class="card-header">
            <h3 class="card-title">Edit Company Information</h3>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-3">
            <form action="{{route('company-update')}}" method="POST" id="companyForm" enctype="multipart/form-data">
                @csrf

                <!-- Company Name -->
                <div class="row mb-5">
                    <label class="col-lg-3 col-form-label fw-bold fs-6 required">Company Name:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control form-control-solid" id="companyName" name="companyName" value="{{ $company->name }}" required />
                        <span class="text-danger" id="companyNameEmpty">@error('companyName'){{ $message }}@enderror</span>
                    </div>
                </div>

                
                <!-- Company Type -->
                <div class="row mb-5">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">Company Type:</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control form-control-solid" name="companyType"  value="{{ $company->companyType->name }}" readonly
                            data-bs-toggle="tooltip" data-bs-placement="top" title="This field cannot be updated." />
                        <span class="text-muted fst-italic">This field is disabled and cannot be updated.</span>
                    </div>
                </div>
                <!-- Owner Title -->
                <div class="row mb-5">
                        <label class="col-lg-3 col-form-label fw-bold fs-6 required">Owner Title:</label>
                        <div class="col-lg-6">
                            <select name="ownerTitle" id="ownerTitle" name="ownerTitle"
                                class="form-control form-control-solid @error('ownerTitle') is-invalid @enderror">
                                <option value="{{ $company->owner_title }}">{{ $company->owner_title }}</option>
                                @foreach (['CEO', 'Main Director', 'Owner'] as $title)
                                    <option value="{{ $title }}" {{ old('ownerTitle', $company->owner_title) == $title ? 'selected' : '' }}>
                                        {{ $title }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="ownerTitleEmpty">@error('ownerTitle'){{ $message }}@enderror</span>
                        </div>
                    </div>


                <!-- Category -->
                <div class="row mb-5">
                    <label class="col-lg-3 col-form-label fw-bold fs-6 required">Category:</label>
                    <div class="col-lg-9">
                        <select name="categoryId" id="categoryId" data-control="select2" name="categoryId"
                            class="form-control form-control-solid @error('categoryId') is-invalid @enderror">
                            <option value="{{$company->category_id}}">{{$company->category->name}}</option>
                            @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                        </select>
                        <span class="text-danger" id="categoryEmpty">@error('categoryId'){{ $message }} @enderror</span>
                    </div>
                </div>

                <!-- Sub-Category -->
                <div class="row mb-5">
                    <label class="col-lg-3 col-form-label fw-bold fs-6 required">Sub-Category:</label>
                    <div class="col-lg-9">
                        <select name="subCategoryId" id="subCategoryId" data-control="select2" name="subCategoryId"
                            class="form-control form-control-solid @error('subCategoryId') is-invalid @enderror">
                            <option value="{{$company->sub_category_id}}">{{$company->subCategory->name}}</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ old('subCategoryId') == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="subCategoryEmpty">@error('subCategoryId'){{ $message }} @enderror</span>
                    </div>
                </div>

                 <!-- Register Number Field -->
                 <div class="row mb-5">
                        <label class="col-lg-3 col-form-label fw-bold fs-6 required">Register Number:</label>
                        <div class="col-lg-9">
                            <input type="text" name="registrationNumber" id="registrationNumber" 
                                class="form-control form-control-solid @error('registrationNumber') is-invalid @enderror"
                                value="{{ old('registrationNumber', $company->registration_number) }}" required />
                            <span class="text-danger" id="registrationNumberEmpty"> @error('registrationNumber'){{ $message }} @enderror</span>
                        </div>
                    </div>
                     <!-- Tax Number Field -->
                        <div class="row mb-5">
                            <label class="col-lg-3 col-form-label fw-bold fs-6 required">Tax Number:</label>
                            <div class="col-lg-9">
                                <input type="text" name="taxNumber" id="taxNumber" 
                                    class="form-control form-control-solid @error('taxNumber') is-invalid @enderror"
                                    value="{{ old('taxNumber', $company->tax_number) }}" required />
                                <span class="text-danger" id="taxNumberEmpty"> @error('taxNumber'){{ $message }} @enderror</span>
                            </div>
                        </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card mb-5 mb-xl-10">
                <!--begin::Card body-->
                <div class="card-body pt-10">
                
                        <!-- Email -->
                        <div class="row mb-5">
                            <label class="col-lg-3 col-form-label fw-bold fs-6 required">Email:</label>
                            <div class="col-lg-9">
                                <input type="email" class="form-control form-control-solid" name="email" id="email" value="{{ $company->email }}" required />
                                <span class="text-danger" id="emailEmpty">@error('email'){{ $message }}@enderror</span>
                            </div>
                        </div>
                            <!-- Country -->
                            <div class="row mb-5">
                            <label class="col-lg-3 col-form-label fw-bold fs-6 required">Country:</label>
                            <div class="col-lg-9">
                                <select name="countryId" id="countryId" data-control="select2" 
                                    class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                                    <option value="{{$company->country_id}}">{{$company->country->name}}</option>
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
                            <label class="col-lg-3 col-form-label fw-bold fs-6 required">City:</label>
                            <div class="col-lg-9">
                                <select name="cityId" id="cityId" data-control="select2"
                                    class="form-control form-control-solid @error('cityId') is-invalid @enderror">
                                    <option value="{{$company->city_id}}">{{$company->city->name}}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('cityId') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="cityEmpty">@error('cityId'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        @php
                        use Illuminate\Support\Str;

                        $prefix = $company->country && $company->country->phone_code
                            ? '+' . trim($company->country->phone_code)
                            : '+';

                        $numberWithoutPrefix = Str::startsWith($company->phone_number, $prefix)
                            ? Str::replaceFirst($prefix, '', $company->phone_number)
                            : $company->phone_number;
                    @endphp


                            <!-- Phone Number -->
                            <div class="row mb-5">
                                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Phone Number:</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                    <span class="input-group-text border-0 border-end border-2 border-gray-300" id="phoneCodeDisplay">{{ $prefix }}</span>
                                    <input type="text"
                                            class="form-control form-control-solid"
                                            id="phoneNumber"
                                            name="phoneNumber"
                                            value="{{ $numberWithoutPrefix }}"
                                            required
                                            aria-describedby="phoneCodeDisplay" />
                                    </div>
                                    <span class="text-danger" id="phoneempty">@error('phone'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        <!-- Address -->
                        <div class="row mb-5">
                            <label class="col-lg-3 col-form-label fw-bold fs-6 required">Address:</label>
                            <div class="col-lg-9">
                                <textarea name="address" class="form-control form-control-solid" rows="3" required>{{ $company->address }}</textarea>
                                <span class="text-danger" id="addressEmpty">@error('address'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="row mb-5">
                            <label class="col-lg-3 col-form-label fw-bold fs-6">Logo:</label>
                            <div class="col-lg-9">
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ $company->logo ? asset('storage/' . $company->logo) : asset('images/q-mark.png') }}')">
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ $company->logo ? asset('storage/' . $company->logo) : asset('images/q-mark.png') }}')"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" title="Change Logo">
                                        <i class="fas fa-pencil-alt fs-7"></i>
                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" title="Remove Logo">
                                        <i class="fas fa-times fs-2"></i>
                                    </span>
                                </div>



                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            </div>
    
           