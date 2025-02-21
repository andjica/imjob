@php use App\Models\User; @endphp
@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Your notifications')

@section('title-dash', 'All Notifications')
@section('css')
   
@endsection
@section('content')
    <div class="container m-0 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.success')
                @include('alerts.errors')
            
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Your new Notifications</h4>
                    </div>
                    <div class="card-body">
                    @if($newNotifications->count() == 0)
                    <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No requests from companies</h4>
                                    <p class="mb-0">There are currently no new requests for activation companies in the system.</p>
                                </div>
                            </div>
                    @else
                   
                        @foreach ($newNotifications as $not)
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($not->company->logo)
                                        <img src="{{ Storage::url($not->company->logo) }}" alt="{{ $not->company->name }}" class="rounded-circle" width="50" height="50">
                                    @else
                                        <i class="fas fa-building fa-2x text-muted"></i>
                                    @endif
                                    <strong>{{ $not->company->name }}</strong><br>
                                    <span>{{ $not->company->user->email }}</span>
                                    <br>
                                    <span>Category: {{ $not->company->category->name }}</span>
                                    <br>
                                    <span>Country: {{ $not->company->country->name }}, City: {{ $not->company->city->name }}</span>
                                    <hr>
                                    <span class="text-muted fs-7 fw-bold justify-content-right">{{ $not->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="d-flex">
                                    <!-- Accept Button -->
                                    
                                    <!-- Reject Button -->
                                    
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        <small class="card-title fw-light fst-italic">Older Notifications</small>

                        @foreach ($connections as $connection)
                            <div class="alert alert-light d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($connection->company->logo)
                                        <img src="{{ Storage::url($connection->company->logo) }}" alt="{{ $connection->company->name }}" class="rounded-circle" width="50" height="50">
                                    @else
                                        <i class="fas fa-building fa-2x text-muted"></i>
                                    @endif
                                    <strong>{{ $connection->company->name }}</strong><br>
                                    <span>{{ $connection->company->user->email }}</span>
                                    <br>
                                    <span>Category: {{ $connection->company->category->name }}</span>
                                    <br>
                                    <span>Country: {{ $connection->company->country->name }}, City: {{ $connection->company->city->name }}</span>
                                    <hr>
                                    <span class="text-muted fs-7 fw-bold justify-content-right">{{ $connection->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
     </div>
    </div>
@endsection

@section('js')
@endsection
