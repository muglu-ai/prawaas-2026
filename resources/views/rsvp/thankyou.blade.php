
@extends('rsvp.layout')
@section('title', 'Thank You - RSVP Submitted')
@push('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        margin: 2rem auto;
        padding: 0;
        overflow: hidden;
    }
    .form-header {
        background: #1e3a5f;
        color: #fff;
        padding: 2rem 1.5rem;
        text-align: center;
    }
    .form-header h2 {
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .form-header p {
        margin-bottom: 0;
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
    }
    .form-body {
        padding: 2rem 1.5rem;
    }
    .thank-intro {
        color: #334155;
        font-size: 1rem;
        margin-bottom: 1rem;
    }
    .rsvp-reference {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 1.5rem;
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: inline-block;
    }
    .rsvp-reference strong { color: #1e3a5f; font-family: ui-monospace, monospace; letter-spacing: 0.02em; }
    .details-card {
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
        padding: 1.25rem 1.5rem;
    }
    .details-card-title {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .date-time-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        color: #475569;
        font-size: 0.95rem;
    }
    .date-time-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .date-time-item i {
        color: #64748b;
        width: 1.1rem;
    }
    .venue-section {
        color: #334155;
    }
    .venue-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .venue-item:last-child { margin-bottom: 0; }
    .venue-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: #e2e8f0;
        color: #64748b;
        flex-shrink: 0;
    }
    .venue-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .venue-name { font-weight: 600; color: #1e293b; font-size: 1rem; margin-bottom: 0.25rem; }
    .venue-address { color: #475569; font-size: 0.9rem; line-height: 1.5; }
    .note-text {
        color: #475569;
        font-size: 0.9rem;
        padding: 0.75rem 0;
        border-left: 3px solid #cbd5e1;
        padding-left: 1rem;
        margin-left: 0.25rem;
    }
    .contact-section { margin-bottom: 1.5rem; }
    .contact-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .contact-title i { color: #64748b; }
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .contact-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
        color: #334155;
    }
    .contact-card-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .contact-card-name { font-weight: 600; font-size: 0.95rem; color: #1e293b; margin-bottom: 0.5rem; }
    .contact-card-info { font-size: 0.85rem; color: #475569; line-height: 1.6; }
    .contact-card-info a { color: #1e3a5f; text-decoration: none; }
    .contact-card-info a:hover { text-decoration: underline; }
    .footer-signature {
        background: #f1f5f9;
        padding: 1.25rem 1.5rem;
        text-align: center;
        color: #475569;
        border-top: 1px solid #e2e8f0;
    }
    .footer-signature .thank-text { font-weight: 600; font-size: 0.95rem; color: #334155; margin-bottom: 0.25rem; }
    .footer-signature .team-text { font-size: 0.9rem; }
    @media (max-width: 576px) {
        .form-card { margin: 1rem 0.25rem; }
        .form-header { padding: 1.5rem 1rem; }
        .form-body { padding: 1.25rem 1rem; }
        .date-time-row { flex-direction: column; gap: 0.5rem; }
        .contact-grid { grid-template-columns: 1fr; }
        .footer-signature { padding: 1rem; }
    }
</style>
@endpush


@section('content')
<div class="form-card">
    <div class="form-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
        <h2><i class="fas fa-calendar-check me-2"></i>RSVP Form for the Prawaas 5.0 Curtain Raiser</h2>
        <p>{{ config('constants.EVENT_NAME', 'Event') }} {{ config('constants.EVENT_YEAR', date('Y')) }}</p>
    </div>
    <div class="form-body">
        <!-- Progress Indicator (Confirmation complete) -->
        <div class="progress-container">
            <div class="step-indicator">
                <div class="step-item completed">
                    <div class="step-number">1</div>
                    <div class="step-label">Your Information</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-item active">
                    <div class="step-number">2</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
            <div class="progress-bar-custom">
                <div class="progress-fill" style="width: 100%;"></div>
            </div>
        </div>

        <div class="thank-intro">
            @if(isset($rsvp) && $rsvp && $rsvp->name)
                Dear {{ $rsvp->name }}, <br>
                
            @else
                Dear Attendee, <br>
            @endif
            Thank you for submitting your RSVP for the <strong>Prawaas 5.0 Curtain Raiser</strong>.
        </div>
        @if(isset($rsvp) && $rsvp && $rsvp->unique_reference)
            <div class="rsvp-reference">
                Your RSVP reference: <strong>{{ $rsvp->unique_reference }}</strong>
            </div>
        @endif

        <div class="details-card">
            <div class="details-card-title">Curtain Raiser Details</div>
            <div class="date-time-row">
                <span class="date-time-item"><i class="fas fa-calendar-alt"></i> Monday, 16 February 2026</span>
                <span class="date-time-item"><i class="fas fa-clock"></i> 6:00 PM onwards</span>
            </div>
            <div class="venue-section">
                <div class="venue-item">
                    <div class="venue-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="venue-label">Venue</div>
                        <div class="venue-name">Inspiration Hall, Crowne Plaza Ahmedabad City Centre</div>
                        <div class="venue-address">S.G. Highway, Near Shapath-V, Ahmedabad - 380015</div>
                    </div>
                </div>
                <div class="venue-item">
                    <div class="venue-icon"><i class="fas fa-info-circle"></i></div>
                    <div class="note-text">The function will be followed by high tea.</div>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <div class="contact-title">
                <i class="fas fa-phone-alt"></i>
                For more information, please get in touch with:
            </div>
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-card-label">For Industry</div>
                    <div class="contact-card-name">Ms. Sneha Singh</div>
                    <div class="contact-card-info">
                        Mobile: +91 - 76762 68577<br>
                        Email: <a href="mailto:sneha.singh@mmactiv.com">sneha.singh@mmactiv.com</a>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-card-label">For Operators</div>
                    <div class="contact-card-name">Mr. Siddiq Gandhi</div>
                    <div class="contact-card-info">
                        Mobile: +91 99790 19191
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-signature">
        <div class="thank-text">Thank you,</div>
        <div class="team-text">Team Prawaas 5.0</div>
    </div>
</div>
@endsection
