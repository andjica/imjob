<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recruitment Process Overview</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Recruitment Process Table -->
            <div class="col-lg-8 mb-4">
                <div class="table-responsive">
                    <table class="recruitment-process-table">
                        <thead>
                            <tr>
                                <th>Application Received</th>
                                <th>Selection</th>
                                <th>Preparation</th>
                                <th>Transfer</th>
                                <th>Offer Stage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="badge badge-success">Completed</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">Completed</span>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Current</span>
                                </td>
                                <td>
                                    <span class="badge badge-light">Upcoming</span>
                                </td>
                                <td>
                                    <span class="badge badge-light">Upcoming</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Status Update Button -->
                <button class="btn btn-sm btn-success status-update-btn" id="statusUpdateBtn">
                    Advance to Next Step
                </button>
            </div>
            <!-- End of Recruitment Process Table -->
            
            <!-- Small User Card -->
            <div class="col-lg-4">
                <div class="candidate-card">
                    <!-- Candidate Profile Picture -->
                    <img src="{{ asset('images/300-2.jpg') }}" alt="Andjela Stojanovic">
    
                    <!-- Candidate Details -->
                    <div class="candidate-details">
                        <h5>Andjela Stojanovic</h5>
                        <p><i class="fa fa-envelope"></i> andjela.stojanovic@example.com</p>
                        <p><i class="fa fa-phone"></i> +1234567890</p>
                        <p><i class="fa fa-map-marker-alt"></i> 1234 Elm Street, Springfield, USA</p>
                        <!-- Current Status Badge -->
                        <span class="badge badge-warning p-2">
                            First Interview
                        </span>
                        <!-- CV Download Button -->
                        <a href="{{ asset('cv/andjela_stojanovic_cv.pdf') }}" class="badge badge-danger p-2 cv-download-btn" target="_blank">
                            <i class="fa fa-file-pdf text-white"></i> Download CV
                        </a>
                    </div>
                </div>
            </div>
            <!-- End of Small User Card -->
        </div>
    </div>
</div>