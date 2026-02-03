@extends('rsvp.layout')

@section('title', 'Thank You - RSVP Submitted')

@push('styles')
<style>
    .thankyou-container {
        max-width: 700px;
        margin: 0 auto;
        background: var(--bg-secondary);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        padding: 3rem;
        text-align: center;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 3rem;
        box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
    }

    .thankyou-container h1 {
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-size: 2rem;
    }

    .thankyou-container > p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .event-details-card {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        border-radius: 12px;
        overflow: hidden;
        margin: 2rem 0;
        text-align: left;
    }

    .event-date-time-bar {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .event-date-time-bar .date-item,
    .event-date-time-bar .time-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-size: 1rem;
        font-weight: 500;
    }

    .event-date-time-bar i {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .event-venue-section {
        padding: 1.5rem;
        color: white;
    }

    .event-venue-section .venue-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .event-venue-section .venue-row:last-child {
        margin-bottom: 0;
    }

    .event-venue-section i {
        font-size: 1.1rem;
        margin-top: 3px;
        opacity: 0.9;
        width: 20px;
        text-align: center;
    }

    .event-venue-section .venue-row i.fa-map-marker-alt {
        color: #ef4444;
    }

    .event-venue-section .venue-text {
        flex: 1;
        line-height: 1.5;
    }

    .event-venue-section .venue-name {
        font-weight: 600;
        font-size: 1.05rem;
    }

    .note-text {
        background: rgba(255,255,255,0.1);
        padding: 0.75rem 1rem;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .footer-signature {
        background: rgba(0,0,0,0.2);
        padding: 1.25rem 1.5rem;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .footer-signature .team-name {
        font-weight: 600;
        color: #ffd700;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
@php
    $rsvpConfig = config('constants.rsvp', []);
    $rsvpEventDate = $rsvpConfig['event_date'] ?? null;
    $rsvpEventTime = $rsvpConfig['event_time'] ?? '';
    $rsvpVenueName = $rsvpConfig['venue_name'] ?? '';
    $rsvpVenueAddress = $rsvpConfig['venue_address'] ?? '';
    $rsvpNote = $rsvpConfig['note'] ?? '';
@endphp

<div class="thankyou-container">
    <div class="success-icon">
        <i class="fas fa-calendar-check"></i>
    </div>
    <h1>Thank You for Your RSVP!</h1>
    <p>Your RSVP has been submitted successfully. We look forward to seeing you at the event.</p>
    
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Event Details Card --}}
    <div class="event-details-card">
        <div class="event-date-time-bar">
            <div class="date-item">
                <i class="fas fa-calendar-alt"></i>
                @if($rsvpEventDate)
                    {{ \Carbon\Carbon::parse($rsvpEventDate)->format('l, F jS, Y') }}
                @else
                    Event Date TBA
                @endif
            </div>
            <div class="time-item">
                <i class="far fa-clock"></i>
                {{ $rsvpEventTime ?: 'Time TBA' }}
            </div>
        </div>
        
        <div class="event-venue-section">
            <div class="venue-row">
                <i class="fas fa-map-marker-alt"></i>
                <div class="venue-text">
                    @if($rsvpVenueName)
                        <div class="venue-name">{{ $rsvpVenueName }}</div>
                    @endif
                    {{ $rsvpVenueAddress }}
                </div>
            </div>
            
            @if($rsvpNote)
            <div class="venue-row">
                <i class="fas fa-info-circle"></i>
                <div class="note-text">
                    <strong>Note:</strong> {{ $rsvpNote }}
                </div>
            </div>
            @endif
        </div>

        <div class="footer-signature">
            <div class="team-name">Thank You,</div>
            <div>{{ $rsvpConfig['contact_name'] ?? 'Team ' . config('constants.EVENT_NAME', 'Event') }}, Event Secretariat</div>
            <div class="mt-2">
                {!! nl2br(e($rsvpConfig['contact_address'] ?? '')) !!}<br>
                Tel: {{ $rsvpConfig['contact_phone'] ?? '' }}<br>
                Website: {{ $rsvpConfig['contact_website'] ?? '' }}
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border: none; padding: 0.75rem 2rem;">
            <i class="fas fa-home me-2"></i>Back to Home
        </a>
    </div>
</div>
@endsection
