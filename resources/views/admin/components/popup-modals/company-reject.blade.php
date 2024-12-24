<button type="button" class="btn btn-danger btn-sm ms-2" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $company->id }}">
    <i class="fas fa-times"></i>
</button>
<!-- Reject Modal -->
<div class="modal fade" id="rejectModal{{ $company->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $company->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light-danger">
                <h5 class="modal-title" id="rejectModalLabel{{ $company->id }}">Reject Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this company?</p>
                <ul>
                    <li><strong>Name:</strong> {{ $company->name }}</li>
                    <li><strong>Email:</strong> {{ $company->user->email }}</li>
                    <li><strong>Country:</strong> {{ $company->country->name }}</li>
                    <li><strong>Registration number:</strong> {{ $company->registration_number}}</li>
                    <li><strong>Created At:</strong> {{ $company->created_at->format('d-m-Y') }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin-dashboard-company-reject', $company->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>