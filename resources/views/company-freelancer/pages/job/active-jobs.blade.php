@extends('company-freelancer.template-company-freelancer')

@section('main-title', 'Active Jobs')

@section('title-dash', 'This is active on mobile app')

@section('css')
    <style>
        .card-job {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
            position: relative;
        }

        .card-job:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-job .card-header {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #f4f4f9;
            position: relative;
        }

        .card-job img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .card-job .card-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .card-job .card-body {
            padding: 20px;
        }

        .card-job .card-text {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }

        .card-job .job-type {
            font-weight: bold;
            color: #007bff;
        }

        .btn-see-more {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            text-align: center;
            position: absolute;
            right: 17px;
            bottom: 17px;
            font-size: smaller;
            font-weight: 500;
            text-transform: lowercase;
        }

        .btn-see-more:hover {
            background-color: black;
            transform: translateY(-2px);
            color: white !important;
        }

        .btn-see-more:focus {
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.8);
        }

        .edit-icon {
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
    transition: color 0.3s ease;
    background: #0093ff;
    border-radius: 100%;
    padding: 7px;
    color: white !important;
    font-size: 16px;
}
        .edit-icon:hover {
            color: #0056b3;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <!-- Search Box -->
        <div class="row search-container">
            <div class="col-md-12">
                <input type="text" class="search-input" placeholder="Search active jobs...">
            </div>
        </div>

        <!-- Active Job Cards -->
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card card-job">
                    <div class="card-header">
                        <img src="https://play-lh.googleusercontent.com/G4zVlOijuReq3y7ky-dN6WPeWgW_jyTmhEr31e1LW6cROlFVnA1pldsv1Sp6O4lLHA=w240-h480-rw" alt="Company Logo">
                        <div>
                            <h5 class="card-title">Tech Innovators</h5>
                            <p class="card-text">Location: San Francisco, CA</p>
                        </div>
                        <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal" data-bs-target="#statusModal"
                            data-job="Tech Innovators"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Valid Until:</strong> Jan 31, 2025</p>
                        <p class="card-text"><strong>Salary:</strong> $60,000 - $80,000</p>
                        <p class="card-text job-type">Job Type: Full-Time</p>
                        <p class="card-text"><strong>Recruiter:</strong> John Doe</p>
                        <a href="#" class="btn-see-more">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-job">
                    <div class="card-header">
                        <img src="https://play-lh.googleusercontent.com/G4zVlOijuReq3y7ky-dN6WPeWgW_jyTmhEr31e1LW6cROlFVnA1pldsv1Sp6O4lLHA=w240-h480-rw" alt="Company Logo">
                        <div>
                            <h5 class="card-title">Unity3d Innovators</h5>
                            <p class="card-text">Location: San Francisco, CA</p>
                        </div>
                        <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal" data-bs-target="#statusModal"
                            data-job="Tech Innovators"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Valid Until:</strong> Jan 31, 2025</p>
                        <p class="card-text"><strong>Salary:</strong> $60,000 - $80,000</p>
                        <p class="card-text job-type">Job Type: Full-Time</p>
                        <p class="card-text"><strong>Recruiter:</strong> John Doe</p>
                        <a href="#" class="btn-see-more">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-job">
                    <div class="card-header">
                        <img src="https://play-lh.googleusercontent.com/G4zVlOijuReq3y7ky-dN6WPeWgW_jyTmhEr31e1LW6cROlFVnA1pldsv1Sp6O4lLHA=w240-h480-rw" alt="Company Logo">
                        <div>
                            <h5 class="card-title">Danny Innovators</h5>
                            <p class="card-text">Location: San Francisco, CA</p>
                        </div>
                        <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal" data-bs-target="#statusModal"
                            data-job="Tech Innovators"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Valid Until:</strong> Jan 31, 2025</p>
                        <p class="card-text"><strong>Salary:</strong> $60,000 - $80,000</p>
                        <p class="card-text job-type">Job Type: Full-Time</p>
                        <p class="card-text"><strong>Recruiter:</strong> John Doe</p>
                        <a href="#" class="btn-see-more">See More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Status Update -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Job Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to change the status of <span id="job-name"></span>?</p>
                    <select id="job-status" class="form-select">
                        <option value="active">Active</option>
                        <option value="not_active">Not Active</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-status">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusModal = document.getElementById('statusModal');
            const jobNameSpan = document.getElementById('job-name');
            const jobStatusSelect = document.getElementById('job-status');
            let currentJob = null;

            // Handle pencil icon click
            document.querySelectorAll('.edit-icon').forEach(icon => {
                icon.addEventListener('click', () => {
                    currentJob = icon.dataset.job;
                    jobNameSpan.textContent = currentJob;
                });
            });

            // Save changes
            document.getElementById('save-status').addEventListener('click', () => {
                const selectedStatus = jobStatusSelect.value;
                console.log(`Job: ${currentJob}, Status: ${selectedStatus}`);
                // Add your logic to save the status (e.g., send an AJAX request to update the database)
                const modal = bootstrap.Modal.getInstance(statusModal);
                modal.hide();
            });
        });
    </script>
@endsection
