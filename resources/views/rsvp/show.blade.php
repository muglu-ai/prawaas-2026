@extends('layouts.dashboard')
@section('title', 'RSVP Details')

@push('styles')
<style>
    .rsvp-confirmation-card {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        color: white;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .rsvp-confirmation-card .greeting {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    .rsvp-confirmation-card .event-title {
        font-size: 1rem;
        font-weight: 600;
        color: #ffd700;
        margin-bottom: 1.5rem;
    }
    .event-details-box {
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    .event-details-box .detail-row {
        display: flex;
        margin-bottom: 0.75rem;
    }
    .event-details-box .detail-row:last-child {
        margin-bottom: 0;
    }
    .event-details-box .detail-label {
        font-weight: 600;
        min-width: 80px;
        color: #ffd700;
    }
    .event-details-box .detail-value {
        flex: 1;
    }
    .footer-signature {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.2);
        font-size: 0.9rem;
    }
    .footer-signature .team-name {
        font-weight: 600;
        color: #ffd700;
    }
    .participant-info-card {
        border-left: 4px solid #1e3a5f;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>RSVP Details</h2>
        <a href="{{ route('admin.rsvps.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    {{-- RSVP Confirmation Preview Card --}}
    <div class="rsvp-confirmation-card">
        <div class="greeting">
            Dear {{ $rsvp->title ? $rsvp->title . '. ' : '' }}{{ $rsvp->name }},
        </div>
        <p>Greetings from {{ config('constants.EVENT_NAME', 'Bengaluru Tech Summit') }} {{ config('constants.EVENT_YEAR', date('Y')) }} !!</p>
        
        @if($rsvp->event_identity)
        <div class="event-title">
            Thank you for RSVP on {{ $rsvp->event_identity }}
        </div>
        @else
        <div class="event-title">
            Thank you for your RSVP!
        </div>
        @endif

        <p>Mentioned below are the details of event for your kind reference</p>

        <div class="event-details-box">
            @if($rsvp->ddate)
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ $rsvp->ddate->format('l, jS F Y') }}</span>
            </div>
            @endif
            @if($rsvp->ttime)
            <div class="detail-row">
                <span class="detail-label">Time:</span>
                <span class="detail-value">{{ $rsvp->ttime }}</span>
            </div>
            @endif
            @if($rsvp->comment)
            <div class="detail-row">
                <span class="detail-label">Note:</span>
                <span class="detail-value">{{ $rsvp->comment }}</span>
            </div>
            @endif
            @if($rsvp->rsvp_location)
            <div class="detail-row">
                <span class="detail-label">Venue:</span>
                <span class="detail-value">{{ $rsvp->rsvp_location }}</span>
            </div>
            @endif
        </div>

        <p>Looking forward to meet you.</p>

        @php
            $rsvpConfig = config('constants.rsvp', []);
        @endphp
        <div class="footer-signature">
            <div class="team-name">Thank You,</div>
            <div>{{ $rsvpConfig['contact_name'] ?? 'Team ' . config('constants.EVENT_NAME', 'Event') }}, Event Secretariat</div>
            <div class="mt-2">
                <small>
                    {!! nl2br(e($rsvpConfig['contact_address'] ?? '')) !!}<br>
                    Tel: {{ $rsvpConfig['contact_phone'] ?? config('constants.ORGANIZER_PHONE', '') }}<br>
                    Website: <a href="https://{{ $rsvpConfig['contact_website'] ?? config('constants.EVENT_WEBSITE', '') }}" class="text-white">{{ $rsvpConfig['contact_website'] ?? config('constants.EVENT_WEBSITE', '') }}</a>
                </small>
            </div>
        </div>
    </div>

    {{-- Participant Information Card --}}
    <div class="card participant-info-card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Participant Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%" class="text-muted">Name:</th>
                            <td><strong>{{ $rsvp->name }}</strong></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Organization:</th>
                            <td>{{ $rsvp->org }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Designation:</th>
                            <td>{{ $rsvp->desig }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Organisation Type:</th>
                            <td>{{ $rsvp->association_name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%" class="text-muted">Email:</th>
                            <td><a href="mailto:{{ $rsvp->email }}">{{ $rsvp->email }}</a></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Contact:</th>
                            <td>
                                @if($rsvp->phone_country_code)
                                    +{{ $rsvp->phone_country_code }}-{{ $rsvp->mob }}
                                @else
                                    {{ $rsvp->mob }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">City:</th>
                            <td>{{ $rsvp->city }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Country:</th>
                            <td>{{ $rsvp->country }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Details Card --}}
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Event Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%" class="text-muted">Event Identity:</th>
                            <td>{{ $rsvp->event_identity ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Venue/Location:</th>
                            <td>{{ $rsvp->rsvp_location ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Participant:</th>
                            <td>{{ $rsvp->participant ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%" class="text-muted">Event Date:</th>
                            <td>
                                @if($rsvp->ddate)
                                    <strong>{{ $rsvp->ddate->format('l, jS F Y') }}</strong>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Event Time:</th>
                            <td>{{ $rsvp->ttime ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">RSVP Submitted:</th>
                            <td>{{ $rsvp->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($rsvp->comment)
            <div class="mt-3">
                <h6 class="text-muted">Comment/Note:</h6>
                <div class="bg-light p-3 rounded">
                    {{ $rsvp->comment }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Technical Information (Collapsible) --}}
    <div class="card mb-4">
        <div class="card-header bg-light" data-bs-toggle="collapse" data-bs-target="#technicalInfo" style="cursor: pointer;">
            <h5 class="mb-0">
                <i class="fas fa-cog me-2 text-muted"></i>Technical Information
                <i class="fas fa-chevron-down float-end"></i>
            </h5>
        </div>
        <div id="technicalInfo" class="collapse">
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th width="20%" class="text-muted">Source URL:</th>
                        <td><small class="text-muted">{{ $rsvp->source_url ?? 'N/A' }}</small></td>
                    </tr>
                    <tr>
                        <th class="text-muted">IP Address:</th>
                        <td><small class="text-muted">{{ $rsvp->ip_address ?? 'N/A' }}</small></td>
                    </tr>
                    <tr>
                        <th class="text-muted">User Agent:</th>
                        <td><small class="text-muted">{{ $rsvp->user_agent ?? 'N/A' }}</small></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.rsvps.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
        <form action="{{ route('admin.rsvps.destroy', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this RSVP?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i> Delete RSVP
            </button>
        </form>
    </div>
</div>
@endsection
