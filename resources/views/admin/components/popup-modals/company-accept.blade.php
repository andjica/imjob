<button type="button" class="btn btn-success btn-sm" title="Accept" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $company->id }}">
    <i class="fas fa-check"></i>
    </button>
    <!-- Accept Modal -->
    <div class="modal fade" id="acceptModal{{ $company->id }}" tabindex="-1" aria-labelledby="acceptModalLabel{{ $company->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light-success">
                    <h5 class="modal-title" id="acceptModalLabel{{ $company->id }}">Accept Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to accept this company?</p>
                    <ul>
                        <li><strong>Name:</strong> {{ $company->name }}</li>
                        <li><strong>Email:</strong> {{ $company->user->email }}</li>
                        <li><strong>Country:</strong> {{ $company->country->name }}</li>
                        <li><strong>Registration number:</strong> {{ $company->registration_number}}</li>
                        <li><strong>Created At:</strong> {{ $company->created_at->format('d-m-Y') }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin-dashboard-company-accept', $company->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>