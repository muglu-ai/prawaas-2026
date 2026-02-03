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

    {{-- RSVP Confirmation Preview Card --}}
    <div class="rsvp-confirmation-card">
        <div class="greeting">
            Dear {{ $rsvp->name }},
        </div>
        
        <p style="margin-bottom: 1.5rem;">Thank you for submitting your RSVP for the <strong style="color: #ffd700;">Prawaas 5.0 Curtain Raiser</strong>.</p>

        <div class="event-details-box">
            <h5 style="color: #ffd700; margin-bottom: 1.25rem; font-size: 1.1rem;">Curtain Raiser Details:</h5>
            
            <div style="margin-bottom: 1rem;">
                <div style="color: #ffd700; font-weight: 600; margin-bottom: 0.25rem;">Date & Time:</div>
                <div>Monday, 16 February 2026 | 6:00 PM onwards</div>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <div style="color: #ffd700; font-weight: 600; margin-bottom: 0.25rem;">Venue:</div>
                <div>Inspiration Hall, Crowne Plaza Ahmedabad City Centre<br>S.G. Highway, Near Shapath-V, Ahmedabad – 380015</div>
            </div>
            
            <div>
                <div style="color: #ffd700; font-weight: 600; margin-bottom: 0.25rem;">Note:</div>
                <div>The function will be followed by high tea.</div>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <p style="margin-bottom: 1rem; font-weight: 600;">For more information, please get in touch with:</p>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px;">
                        <div style="color: #ffd700; font-weight: 600; margin-bottom: 0.5rem;">For Industry</div>
                        <div>Ms. Sneha Singh</div>
                        <div>Mobile: +91 - 76762 68577</div>
                        <div>Email: <a href="mailto:sneha.singh@mmactiv.com" style="color: #ffffff; text-decoration: underline;">sneha.singh@mmactiv.com</a></div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px;">
                        <div style="color: #ffd700; font-weight: 600; margin-bottom: 0.5rem;">For Operators</div>
                        <div>Mr. Siddiq Gandhi</div>
                        <div>Mobile: +91 99790 19191</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-signature">
            <div class="team-name">Thank you,</div>
            <div>Team Prawaas 5.0</div>
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
                            <th class="text-muted">Association Name:</th>
                            <td>{{ $rsvp->association_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Registration Type:</th>
                            <td>
                                {{ $rsvp->registration_type }}
                                @if($rsvp->registration_type === 'Other' && $rsvp->registration_type_other)
                                    <br><small class="text-muted">({{ $rsvp->registration_type_other }})</small>
                                @endif
                            </td>
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





</div>
@endsection
