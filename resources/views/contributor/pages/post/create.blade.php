@extends('contributor.template-contributor')
@section('main-title', 'Create post')
@section('title-dash', 'This will showing on mobile app')

@section('css')
    <style>
        .objfit {
            object-fit: cover !important;
        }
        .custom-file-upload {
            display: inline-block;
            cursor: pointer;
            padding: 10px;
            background: #f8f9fa;
            border: 0.5px dotted #ddd;
            border-radius: 5px;
            text-align: center;
            width: 70px;
        }
        .custom-file-upload i {
            font-size: 20px;
            color: #007bff;
        }
        #image {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <!--begin::Card-->
            <div class="card shadow-lg border-0 rounded-3">
                <!--begin::Card header-->
                <div class="card-header bg-light text-white py-3 d-flex align-items-center">
                    <i class="fas fa-pencil-alt me-2 fa-2x"></i>
                    <h5 class="card-title fw-light m-0">Create a New Post</h5>
                </div>
                <!--end::Card header-->

                <!--begin::Form-->
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body p-3">
                        <!--begin::Input group-->
                        <div class="mb-3">
                            <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="What's on your mind?"></textarea>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-3">
                            <label for="image" class="custom-file-upload">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer p-2  d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm ms-0">
                            <i class="fas fa-paper-plane"></i> Post
                        </button>
                    </div>
                    <!--end::Card footer-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
@endsection
