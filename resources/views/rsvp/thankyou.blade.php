@extends('rsvp.layout')

@section('title', 'Thank You - RSVP Submitted')

@push('styles')
<style>
    .thankyou-container {
        max-width: 600px;
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

    .thankyou-container p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .event-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        text-align: left;
    }

    .event-details h4 {
        color: #1e3a5f;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .event-details p {
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .event-details i {
        color: #1e3a5f;
        width: 20px;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="thankyou-container">
    <div class="success-icon">
        <i class="fas fa-calendar-check"></i>
    </div>
    <h1>Thank You for Your RSVP!</h1>
    <p>Your RSVP has been submitted successfully. We look forward to seeing you at the event.</p>
    <p>A confirmation email has been sent to your registered email address.</p>
    
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border: none; padding: 0.75rem 2rem;">
            <i class="fas fa-home me-2"></i>Back to Home
        </a>
    </div>
</div>
@endsection
