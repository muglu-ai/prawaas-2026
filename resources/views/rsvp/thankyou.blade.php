@extends('rsvp.layout')

@section('title', 'Thank You - RSVP Submitted')

@push('styles')
<style>
    .thankyou-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .thankyou-container {
        max-width: 650px;
        width: 100%;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    /* Header Section */
    .thankyou-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
    }

    .thankyou-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 25px solid transparent;
        border-right: 25px solid transparent;
        border-top: 20px solid #2c5282;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        color: #4ade80;
        font-size: 2.5rem;
        border: 3px solid rgba(74, 222, 128, 0.3);
    }

    .thankyou-header h1 {
        color: #ffffff;
        margin: 0 0 0.75rem;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .thankyou-header p {
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
        line-height: 1.6;
        margin: 0;
    }

    .thankyou-header p strong {
        color: #ffd700;
    }

    /* Body Section */
    .thankyou-body {
        padding: 2.5rem 2rem 2rem;
    }

    /* Curtain Raiser Details Card */
    .details-card {
        background: #f8fafc;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }

    .details-card-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        padding: 1rem 1.5rem;
        color: #ffd700;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .details-card-header i {
        font-size: 1rem;
    }

    .date-time-row {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
        color: white;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .date-time-item i {
        opacity: 0.85;
    }

    .venue-section {
        padding: 1.5rem;
        background: white;
    }

    .venue-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .venue-item:last-child {
        margin-bottom: 0;
    }

    .venue-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
    }

    .venue-icon.location {
        background: #fee2e2;
        color: #dc2626;
    }

    .venue-icon.note {
        background: #dbeafe;
        color: #2563eb;
    }

    .venue-content {
        flex: 1;
    }

    .venue-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .venue-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .venue-address {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .note-text {
        color: #475569;
        font-size: 0.9rem;
        background: #f1f5f9;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border-left: 3px solid #3b82f6;
    }

    /* Contact Section */
    .contact-section {
        margin-bottom: 1.5rem;
    }

    .contact-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-title i {
        color: #3b82f6;
    }

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
        letter-spacing: 0.5px;
        color: #ffd700;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .contact-card-name {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .contact-card-info {
        font-size: 0.85rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .contact-card-info a {
        color: #93c5fd;
        text-decoration: none;
    }

    .contact-card-info a:hover {
        text-decoration: underline;
    }

    /* Footer Signature */
    .footer-signature {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        padding: 1.5rem 2rem;
        text-align: center;
        color: white;
    }

    .footer-signature .thank-text {
        color: #ffd700;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }

    .footer-signature .team-text {
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .thankyou-wrapper {
            padding: 1rem;
        }

        .thankyou-header {
            padding: 2rem 1.5rem;
        }

        .thankyou-header h1 {
            font-size: 1.5rem;
        }

        .thankyou-body {
            padding: 2rem 1.5rem 1.5rem;
        }

        .date-time-row {
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .footer-signature {
            padding: 1.25rem 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="thankyou-wrapper">
    <div class="thankyou-container">
        {{-- Header --}}
        <div class="thankyou-header">
           
            @if($rsvp)
            <p style="font-size: 1.1rem; margin-bottom: 0.75rem;">Dear {{ $rsvp->name }},</p>
            @endif
          
            <p>Thank you for submitting your RSVP for the <strong>Prawaas 5.0 Curtain Raiser</strong>.</p>
        </div>

        {{-- Body --}}
        <div class="thankyou-body">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Curtain Raiser Details --}}
            <div class="details-card">
                <div class="details-card-header">
                    <i class="fas fa-star"></i>
                    Curtain Raiser Details
                </div>
                
                <div class="date-time-row">
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
                        <div class="venue-content">
                            <div class="venue-label">Venue</div>
                            <div class="venue-name">Inspiration Hall, Crowne Plaza Ahmedabad City Centre</div>
                            <div class="venue-address">S.G. Highway, Near Shapath-V, Ahmedabad – 380015</div>
                        </div>
                    </div>

                    <div class="venue-item">
                        <div class="venue-icon note">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="venue-content">
                            <div class="venue-label">Note</div>
                            <div class="note-text">The function will be followed by high tea.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
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

        {{-- Footer --}}
        <div class="footer-signature">
            <div class="thank-text">Thank you,</div>
            <div class="team-text">Team Prawaas 5.0</div>
        </div>
    </div>
</div>
@endsection
