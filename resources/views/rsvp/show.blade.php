@extends('layouts.dashboard')
@section('title', 'RSVP Details')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>RSVP Details</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.rsvps.preview', $rsvp->id) }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-envelope-open-text me-1"></i> Email Preview
            </a>
            <form action="{{ route('admin.rsvps.resend', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Resend confirmation email to {{ $rsvp->email }}?');">
                @csrf
                <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane me-1"></i> Resend Email</button>
            </form>
            <a href="{{ route('admin.rsvps.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user me-2"></i>{{ $rsvp->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Personal Information</h6>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td>{{ $rsvp->name }}</td>
                        </tr>
                        <tr>
                            <th>Organization:</th>
                            <td>{{ $rsvp->org }}</td>
                        </tr>
                        <tr>
                            <th>Designation:</th>
                            <td>{{ $rsvp->desig }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>
                                <a href="mailto:{{ $rsvp->email }}">{{ $rsvp->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Number:</th>
                            <td>
                                @if($rsvp->phone_country_code)
                                    +{{ $rsvp->phone_country_code }}-{{ $rsvp->mob }}
                                @else
                                    {{ $rsvp->mob }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $rsvp->city }}</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>{{ $rsvp->country }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Event Information</h6>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Association:</th>
                            <td>{{ $rsvp->association_name }}</td>
                        </tr>
                        <tr>
                            <th>Event Identity:</th>
                            <td>{{ $rsvp->event_identity ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>RSVP Location:</th>
                            <td>{{ $rsvp->rsvp_location ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Event Date:</th>
                            <td>{{ $rsvp->ddate ? $rsvp->ddate->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Event Time:</th>
                            <td>{{ $rsvp->ttime ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Participant:</th>
                            <td>{{ $rsvp->participant ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Submitted On:</th>
                            <td>{{ $rsvp->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($rsvp->comment)
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-muted mb-2">Comment</h6>
                    <div class="bg-light p-3 rounded">
                        {{ $rsvp->comment }}
                    </div>
                </div>
            </div>
            @endif

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <h6 class="text-muted mb-3">Technical Information</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="20%">Source URL:</th>
                            <td><small class="text-muted">{{ $rsvp->source_url ?? 'N/A' }}</small></td>
                        </tr>
                        <tr>
                            <th>IP Address:</th>
                            <td><small class="text-muted">{{ $rsvp->ip_address ?? 'N/A' }}</small></td>
                        </tr>
                        <tr>
                            <th>User Agent:</th>
                            <td><small class="text-muted">{{ Str::limit($rsvp->user_agent, 100) ?? 'N/A' }}</small></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <form action="{{ route('admin.rsvps.destroy', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this RSVP?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-1"></i> Delete RSVP</button>
            </form>
        </div>
    </div>
</div>
@endsection
