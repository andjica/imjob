

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Send Email</h3>
    </div>
    <div class="card-body">
        <form action="{{asset('/company/dashboard/email/emoloyee-invitation')}}" method="POST" id="emailForm">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" id="email">
                <span class="text-danger" id="emailEmpty"> @error('email')
                        {{ $message }}
                    @enderror
                </span><br>
                <small>
                Can't find your employee? Invite them to join the platform by sending them an email.
                </small>
            </div>
            <button type="submit" class="btn btn-success">Send Email</button>
        </form>
    </div>
</div>