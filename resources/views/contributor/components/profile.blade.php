<div class="card shadow-sm border mt-2">
                <div class="card-body">
                    <!-- Contributor Avatar -->
                  
                    <!-- Contributor Name -->
                    <h3 class="fw-bold text-dark">
                        {{ $contributor->name  }}
                    </h3>

                    <!-- Contributor Email -->
                    <p class="text-muted mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i> {{ $contributor->email }}
                    </p>

                    <!-- Contributor Type -->
                    @if($contributor->contributorType->name == 'Other(Specify)')
                        <!-- Custom Contributor Type (if applicable) -->
                        <p class="text-muted">
                            <i class="fas fa-pencil-alt me-2 text-warning"></i> 
                            {{ $contributor->custom_contributor_type }}
                        </p>
                    @else
                    <p class="text-muted mb-2">
                        <i class="fas fa-user-tag me-2 text-primary"></i> 
                        {{ $contributor->contributorType->name }}
                    </p>
                    @endif
                  
                  

                    <!-- Country & City -->
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i> 
                        {{ $contributor->city->name ?? 'Unknown City' }}, 
                        {{ $contributor->country->name ?? 'Unknown Country' }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-start gap-3 mt-4">
                        <a href="" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
