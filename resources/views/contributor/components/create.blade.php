<div class="card shadow-sm">
    <div class="card-header border-0 bg-light d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-user me-2 text-primary"></i> Contributor Profile Setup
        </h3>
    </div>
    <div class="card-body">
        <form action="{{asset('/contributor/store')}}" method="POST" id="contributorForm">
            @csrf
            <!-- Contributor Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Contributor name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name">
                <div class="text-danger" id="nameEmpty">
                @error('name'){{ $message }}@enderror
                </div>
            </div>
            
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="" placeholder="Enter email">
                    <div class="text-danger" id="emailEmpty">  @error('email'){{ $message }}@enderror</div>      
            </div>
            <!-- Contributor Type -->
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Contributor type:</label>
                <div class="col-lg-8">
                    <select name="contributorTypeId" id="contributorTypeId" data-control="select2"
                        class="form-control form-control-solid @error('contributorTypeId') is-invalid @enderror">
                        <option value="">Select a Contributor type</option>
                        @foreach ($contributorTypes as $contributorType)
                            <option 
                                value="{{ $contributorType->id }}" 
                                {{ old('contributorTypeId') == $contributorType->id ? 'selected' : '' }}
                                @if (trim($contributorType->name) === 'Other(Specify)') data-is-other="true" @endif>
                                {{ $contributorType->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="contributorTypeIdEmpty">@error('contributorTypeId'){{ $message }}@enderror</span>
                </div>
            </div>


            <!-- Custom Contributor Type -->
            <div class="row mb-5 d-none" id="customContributorTypeWrapper">
                <label class="col-lg-2 col-form-label fw-bold fs-6">Specify your type:</label>
                <div class="col-lg-8">
                    <input type="text" name="customContributorType" id="customContributorType"
                        class="form-control form-control-solid @error('customContributorType') is-invalid @enderror"
                        value="{{ old('customContributorType') }}" placeholder="Enter your contributor type">
                    <span class="text-danger" id="customContributorTypeEmpty">@error('customContributorType'){{ $message }}@enderror</span>
                </div>
            </div>
            <!-- Explanation Section -->
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6">Explanation:</label>
                <div class="col-lg-8">
                    <p class="form-text text-muted">
                        Contributor Type refers to the category that best describes your role or organization, such as Ministry, Airline, Embassy, etc. 
                        You can select a predefined type from the dropdown. 
                        If none of the predefined options match your needs, you can select <strong>"Other (Specify)"</strong>, which will allow you to enter a custom contributor type in the input field provided.
                        <br><br>
                        For example, if your contributor type is not listed, such as "Community Organization" or "Research Institute," select <strong>"Other (Specify)"</strong> and type your specific contributor type in the input field.
                    </p>
                </div>
            </div>
            <!-- Country -->
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Country:</label>
                <div class="col-lg-8">
                    <select name="countryId" id="countryId" data-control="select2"
                        class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                        <option value="">Select a Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('countryId') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="countryIdEmpty">@error('countryId'){{ $message }}@enderror</span>
                </div>
            </div>
            <!-- City -->
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">City:</label>
                <div class="col-lg-8">
                    <select name="cityId" id="cityId" data-control="select2"
                        class="form-control form-control-solid @error('cityId') is-invalid @enderror">
                        <option value="">Select a City</option>
                        <option value=""></option>
                    </select>
                    <span class="text-danger" id="cityIdEmpty">@error('cityId'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Save Profile
                </button>
            </div>
            <div class="spinner-border text-primary d-none" role="status" id="loading" style="position: absolute; top: 50%; left: 50%; z-index: 1000;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </form>
    </div>
</div>