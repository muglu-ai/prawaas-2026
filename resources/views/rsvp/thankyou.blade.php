
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
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        color: #fff;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        text-align: center;
    }
    .form-header h2 {
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .form-header p {
        margin-bottom: 0;
        color: #ffd700;
        font-size: 1.1rem;
    }
    .form-body {
        padding: 2rem 1.5rem 1.5rem 1.5rem;
    }
    .details-card {
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .details-card-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        color: #ffd700;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .date-time-row {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .date-time-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        font-size: 1rem;
    }
    .venue-section {
        background: #fff;
        padding: 1.5rem;
    }
    .venue-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .venue-item:last-child { margin-bottom: 0; }
    .venue-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .venue-icon.location { background: #fee2e2; color: #dc2626; }
    .venue-icon.note { background: #dbeafe; color: #2563eb; }
    .venue-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .venue-name { font-weight: 600; color: #1e293b; font-size: 1rem; margin-bottom: 0.25rem; }
    .venue-address { color: #475569; font-size: 0.9rem; line-height: 1.5; }
    .note-text {
        color: #475569;
        font-size: 0.9rem;
        background: #f1f5f9;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border-left: 3px solid #3b82f6;
    }
    .contact-section { margin-bottom: 1.5rem; }
    .contact-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .contact-title i { color: #3b82f6; }
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .contact-card {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        border-radius: 12px;
        padding: 1.25rem;
        color: white;
    }
    .contact-card-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #ffd700;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .contact-card-name { font-weight: 600; font-size: 0.95rem; margin-bottom: 0.5rem; }
    .contact-card-info { font-size: 0.85rem; opacity: 0.9; line-height: 1.6; }
    .contact-card-info a { color: #93c5fd; text-decoration: none; }
    .contact-card-info a:hover { text-decoration: underline; }
    .footer-signature {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        padding: 1.25rem 1.5rem;
        text-align: center;
        color: white;
    }
    .footer-signature .thank-text { color: #ffd700; font-weight: 600; font-size: 1.1rem; margin-bottom: 0.25rem; }
    .footer-signature .team-text { font-size: 1rem; }
    @media (max-width: 576px) {
        .form-card { margin: 1rem 0.25rem; }
        .form-header { padding: 1.5rem 1rem 1rem 1rem; }
        .form-body { padding: 1.25rem 1rem 1rem 1rem; }
        .date-time-row { flex-direction: column; gap: 0.75rem; }
        .contact-grid { grid-template-columns: 1fr; }
        .footer-signature { padding: 1rem 1rem; }
    }
</style>
@endpush


@section('content')
<div class="form-card">
    <div class="form-header">
       
        <p style="text-align: left;">
            @if(isset($rsvp) && $rsvp && $rsvp->name)
                Dear {{ $rsvp->name }},
            @else
                Dear Attendee,
            @endif
        </p>
        <div style="color: #fff; font-size: 1rem; margin-top: 0.5rem; text-align: left;">Thank you for submitting your RSVP for the <strong>Prawaas 5.0 Curtain Raiser</strong>.</div>
    </div>
    <div class="form-body">
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="details-card">
            <div class="details-card-header">
                <i class="fas fa-star"></i>
                Curtain Raiser Details
            </div>
            <div class="date-time-row" style="justify-content: flex-start;">
                            <div class="date-time-item">
                                <i class="fas fa-calendar-alt"></i>
                                Monday, 16 February 2026
                            </div>
                            <div class="date-time-item">
                                <i class="fas fa-clock"></i>
                                6:00 PM onwards
                            </div>
                        </div>
            <div class="venue-section">
                <div class="venue-item">
                    <div class="venue-icon location">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="venue-label">Venue</div>
                        <div class="venue-name">Inspiration Hall, Crowne Plaza Ahmedabad City Centre</div>
                        <div class="venue-address">S.G. Highway, Near Shapath-V, Ahmedabad – 380015</div>
                    </div>
                </div>
                <div class="venue-item">
                    <div class="venue-icon note">
                        <i class="fas fa-info"></i>
                    </div>
                    <div>
                       
                        <div class="note-text">The function will be followed by high tea.</div>
                    </div>
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
