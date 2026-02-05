@extends('layouts.poster-registration')

@section('title', 'Poster Registration - ' . config('constants.EVENT_NAME') . ' ' . config('constants.EVENT_YEAR'))

@push('head-links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css">
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
<style>
    /* Progress Bar Styles - Same as delegate registration */
    .registration-progress {
        padding: 2rem 0;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .progress-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e0e0e0;
        z-index: 0;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        flex: 1;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #e0e0e0;
        border: 3px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: #6c757d;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
    }

    .progress-step.active .step-circle {
        background: #0B5ED7;
        border-color: #0B5ED7;
        color: white;
        box-shadow: 0 4px 12px rgba(11, 94, 215, 0.3);
        transform: scale(1.1);
    }

    .progress-step.completed .step-circle {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .progress-step.completed.active .step-circle {
        background: #28a745;
        border-color: #28a745;
        color: white;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .progress-step .step-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #6c757d;
        text-align: center;
        transition: color 0.3s ease;
    }

    .progress-step.active .step-label {
        color: #0B5ED7;
        font-weight: 700;
    }

    .progress-step.completed .step-label {
        color: #333;
    }

    /* Progress line between steps */
    .progress-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 25px;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #e0e0e0;
        z-index: -1;
        transition: background 0.3s ease;
    }

    .progress-step.completed:not(:last-child)::after {
        background: #28a745;
    }

    .progress-step.active:not(:last-child)::after {
        background: linear-gradient(to right, #0B5ED7 0%, #e0e0e0 100%);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .progress-step .step-label {
            font-size: 0.75rem;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
        
        .progress-steps::before {
            top: 20px;
        }
        
        .progress-step:not(:last-child)::after {
            top: 20px;
        }
    }

    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e0e0e0;
    }
    .form-container {padding: 0 !important;}
    
    .author-block {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: white;
        position: relative;
    }
    
    .author-block.lead-author {
        border-color: #0B5ED7;
        background: #f8f9ff;
    }
    
    .author-block-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    .author-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0B5ED7;
    }
    
    .remove-author-btn {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .role-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-lead {
        background: #0B5ED7;
        color: white;
    }
    
    .badge-presenter {
        background: #20C997;
        color: white;
    }
    
    .attendance-summary {
        background: #e7f3ff;
        border: 2px solid #0B5ED7;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .fee-display {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0B5ED7;
    }
    
    .word-count {
        font-size: 0.875rem;
        color: #666;
        text-align: right;
        margin-top: 0.25rem;
    }
    
    /* Mobile-friendly price calculation styles */
    .price-mobile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .price-mobile-item {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .price-mobile-item .price-label {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .price-mobile-item .price-value {
        font-size: 1rem;
        font-weight: 700;
        color: #000;
    }
    
    .price-mobile-item.price-total {
        grid-column: 1 / -1;
        background: #0B5ED7;
        border-color: #0B5ED7;
    }
    
    .price-mobile-item.price-total .price-label {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .price-mobile-item.price-total .price-value {
        color: #fff;
        font-size: 1.25rem;
    }
    
    @media (max-width: 400px) {
        .price-mobile-grid {
            grid-template-columns: 1fr;
        }
        
        .price-mobile-item.price-total {
            grid-column: 1;
        }
    }
    
    .word-count.warning {
        color: #ff6b6b;
        font-weight: 600;
    }
    
    /* Validation styling */
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6 .4.4.4-.4m0 4.8-.4-.4-.4.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }

    .invalid-feedback:not(:empty) {
        display: block;
    }
    
    .text-danger {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* GST Invoice Section Styles */
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
    
    #gstin_full_width {
        width: 100% !important;
        max-width: 100% !important;
    }

    #gstin_full_width .input-group {
        display: flex !important;
        flex-wrap: nowrap !important;
        align-items: stretch !important;
        width: 100% !important;
        max-width: 100% !important;
        position: relative !important;
    }
    
    #gstin_full_width .input-group > * {
        margin-left: 0;
        margin-right: 0;
    }

    #gstin_full_width .input-group .form-control {
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: auto !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-right: none !important;
        margin-right: 0 !important;
    }

    #gstin_full_width .input-group .btn,
    #gstin_full_width .input-group #validateGstBtn {
        flex: 0 0 auto !important;
        flex-shrink: 0 !important;
        flex-grow: 0 !important;
        white-space: nowrap !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-left: 1px solid #ced4da !important;
        margin-left: -1px !important;
        padding: 0.75rem 1rem !important;
        display: inline-flex !important;
        align-items: center !important;
        position: relative !important;
        z-index: 2 !important;
        width: auto !important;
        min-width: auto !important;
    }
    
    #gstin_full_width .input-group #validateGstBtn[style*="display: none"] {
        display: none !important;
    }
    
    #gstin_full_width .input-group #validateGstBtn:not([style*="display: none"]) {
        display: inline-flex !important;
    }

    #gstin_full_width .input-group .form-control:focus {
        z-index: 3;
        border-right: none !important;
    }

    #gstin_full_width .input-group .form-control:focus + .btn {
        border-left-color: var(--primary-color);
        z-index: 2;
    }

    #gstin_full_width .input-group .form-control.is-invalid {
        border-right: none !important;
    }

    #gstin_full_width .input-group .form-control + .btn {
        margin-left: -1px !important;
    }
    
    #gstin_full_width #gstin_hint_text {
        display: inline-block !important;
        margin-top: 0.5rem;
        padding: 0;
        border: none;
        background: transparent;
    }
    
    #gstin_full_width #gstin_hint_text[style*="display: none"] {
        display: none !important;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-color);
    }
</style>
@endpush

@section('poster-content')
<div class="container py-3">
    {{-- Step Indicator - Same as preview page --}}
    <div class="registration-progress mb-4">
        <div class="progress-steps">
            <!-- Step 1: Registration (Active) -->
            <div class="progress-step active">
                <div class="step-circle">
                    <span>1</span>
                </div>
                <div class="step-label">Registration Details</div>
            </div>
            
            <!-- Step 2: Preview -->
            <div class="progress-step">
                <div class="step-circle">
                    <span>2</span>
                </div>
                <div class="step-label">Review & Preview</div>
            </div>
            
            <!-- Step 3: Payment -->
            <div class="progress-step">
                <div class="step-circle">
                    <span>3</span>
                </div>
                <div class="step-label">Payment</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4"><i class="fas fa-file-alt"></i> Poster Registration Form</h2>

            <div class="form-card">
                <div class="form-body">
        {{-- Auto-save Indicator --}}
        <div id="autoSaveIndicator" class="alert alert-info d-none" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 150px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); padding: 12px 20px; border-radius: 5px;">
            <i class="fas fa-spinner fa-spin"></i> <span>Saving...</span>
        </div>

        {{-- Form Container --}}
        <form id="posterRegistrationForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="session_id" value="{{ session()->getId() }}">
            @if(isset($draft->tin_no) && $draft->tin_no)
            <input type="hidden" name="tin_no" value="{{ $draft->tin_no }}">
            <input type="hidden" name="token" value="{{ $draft->token }}">
            @endif

            {{-- 1) Registration Details --}}
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2"><i class="fas fa-info-circle"></i> Registration Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label for="sector" class="form-label">Sector <span class="text-danger">*</span></label>
                        <select class="form-select" id="sector" name="sector" required>
                            <option value="">Select Sector</option>
                            @foreach(config('constants.sectors') as $sector)
                                <option value="{{ $sector }}" {{ ($draft->sector ?? '') == $sector ? 'selected' : '' }}>
                                    {{ $sector }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="currency" class="form-label">Currency <span class="text-danger">*</span></label>
                        <select class="form-select" id="currency" name="currency" required>
                            <option value="">Select Currency</option>
                            <option value="INR" {{ ($draft->currency ?? 'INR') == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                            <option value="USD" {{ ($draft->currency ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            {{-- 2) Abstract / Poster Details --}}
            <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2"><i class="fas fa-file-alt"></i> Abstract / Poster Details</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="poster_category" class="form-label">Poster Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="poster_category" name="poster_category" required>
                            <option value="Breaking Boundaries" selected>Breaking Boundaries</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="abstract_title" class="form-label">Abstract Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="abstract_title" name="abstract_title" 
                               value="{{ $draft->abstract_title ?? '' }}" maxlength="250" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="abstract" class="form-label">Abstract (Max 250 words) <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="abstract" name="abstract" rows="6" required>{{ $draft->abstract ?? '' }}</textarea>
                        <div class="word-count" id="wordCount">0 / 250 words</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="extended_abstract" class="form-label">Extended Abstract Upload (PDF only) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="extended_abstract" name="extended_abstract" accept=".pdf" required>
                        @if(isset($draft->extended_abstract_path) && $draft->extended_abstract_path)
                        <small class="text-muted">Current file: {{ basename($draft->extended_abstract_path) }}</small>
                        @endif
                        <div class="invalid-feedback"></div>
                        <small class="text-muted d-block mt-2">Max file size: 5MB. Download Extended Abstract Submission Template /Format: <a href="{{ asset('uploads/events/Bengaluru_Tech_Summit_2026-Abstract-submission-template.pdf') }}" target="_blank">Click Here</a></small>
                    </div>
                    <div class="col-md-6">
                        <label for="presentation_mode" class="form-label">Preferred Mode of Presentation <span class="text-danger">*</span></label>
                        <select class="form-select" id="presentation_mode" name="presentation_mode" required>
                            <option value="Poster" selected>Poster</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            {{-- 3) Authors Section --}}
            
            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Authors</h5>
                    
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> Exactly 1 Lead Author is required. Maximum 1 Presenter is allowed. Lead Author and Presenter can be the same person.
                </div>

                <div id="authorsContainer">
                    {{-- Authors will be dynamically added here --}}
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="addAuthorBtn">
                        <i class="fas fa-plus"></i> Add Another Author
                    </button>
            </div>

           

           

            {{-- 5) Organisation Details for Raising the Invoice --}}
            <div class="form-section" id="gst_invoice_section">
                <h4 class="section-title">
                    <i class="fas fa-file-invoice-dollar"></i>
                    Organisation Details for Raising the Invoice
                </h4>

                <div class="row" id="gst_required_row">
                    <div class="col-md-4 mb-2" id="gst_required_full_width">
                        <label class="form-label required-field">Do you require GST Invoice?</label>
                        <select name="gst_required" class="form-select" id="gst_required" required>
                            <option value="1" {{ ($draft->gst_required ?? '0') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ ($draft->gst_required ?? '0') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-8 mb-2" id="gstin_full_width" style="display: {{ ($draft->gst_required ?? '0') == '1' ? 'block' : 'none' }};">
                        <label class="form-label required-field" id="gstin_label">GSTIN</label>
                        <div class="input-group">
                            <input type="text" name="gstin" class="form-control" 
                                   value="{{ $draft->gstin ?? '' }}" 
                                   placeholder="Enter 15-character GSTIN" 
                                   id="gstin_input"
                                   maxlength="15"
                                   style="text-transform: uppercase;">
                            <button type="button" class="btn btn-primary" id="validateGstBtn" style="display: {{ ($draft->gst_required ?? '0') == '1' ? 'inline-flex' : 'none' }};">
                                <i class="fas fa-search me-1"></i>Validate
                            </button>
                        </div>
                        <span class="input-group-text" id="gstin_hint_text" style="display: {{ ($draft->gst_required ?? '0') == '1' ? 'inline-block' : 'none' }}; border: none; padding: 0.25rem 0; background: transparent;">
                            <small class="text-muted" style="font-size: 0.75rem; margin: 0;">Click "Validate" to auto-fill details</small>
                        </span>
                        <div class="invalid-feedback"></div>
                        <div class="d-flex justify-content-end align-items-center mt-1">
                            <div id="gst_loading" class="d-none">
                                <small class="text-info" style="font-size: 0.75rem;"><i class="fas fa-spinner fa-spin"></i> Validating...</small>
                            </div>
                        </div>
                        <div id="gst_validation_message" style="margin-top: 0.5rem;"></div>
                    </div>
                </div>

                <div id="gst_fields" style="display: {{ ($draft->gst_required ?? '0') == '1' ? 'block' : 'none' }};">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field" id="gst_legal_name_label">GST Legal Name</label>
                            <input type="text" name="gst_legal_name" class="form-control" 
                                   value="{{ $draft->gst_legal_name ?? '' }}" 
                                   placeholder="Enter legal name for invoice"
                                   id="gst_legal_name_input"
                                   readonly>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field" id="gst_address_label">GST Address</label>
                            <textarea name="gst_address" class="form-control" rows="2" 
                                      placeholder="Enter address for invoice"
                                      id="gst_address_input"
                                      readonly>{{ $draft->gst_address ?? '' }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field" id="gst_state_label">State</label>
                            <input type="hidden" name="gst_country" value="India">
                            <select name="gst_state" class="form-select" id="gst_state">
                                <option value="">-- Select State --</option>
                                @php
                                    $indianStates = [
                                        'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa',
                                        'Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala',
                                        'Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland',
                                        'Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura',
                                        'Uttar Pradesh','Uttarakhand','West Bengal',
                                        'Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu',
                                        'Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'
                                    ];
                                @endphp
                                @foreach($indianStates as $state)
                                    <option value="{{ $state }}" {{ ($draft->gst_state ?? '') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field">Primary Contact Full Name</label>
                            <input type="text" name="contact_name" class="form-control" 
                                   value="{{ $draft->contact_name ?? '' }}" 
                                   placeholder="Enter full name" id="contact_name">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field">Primary Contact Email Address</label>
                            <input type="email" name="contact_email" class="form-control" 
                                   value="{{ $draft->contact_email ?? '' }}" 
                                   placeholder="Enter email address" id="contact_email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label required-field">Primary Contact Mobile Number</label>
                            <input type="tel" name="contact_phone" class="form-control" 
                                   value="{{ $draft->contact_phone ?? '' }}" 
                                   placeholder="Enter mobile number" 
                                   id="contact_phone"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   maxlength="15">
                            <input type="hidden" name="contact_phone_country_code" id="contact_phone_country_code" value="{{ $draft->contact_phone_country_code ?? '+91' }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>

             {{-- 6) Attendance Summary & Pricing --}}
             <div id="priceDisplay" class="alert alert-success d-none mt-2">
                <h5><i class="fas fa-calculator"></i> Price Calculation</h5>
                <div id="priceDetails">
                    {{-- Desktop Table View --}}
                    <div class="d-none d-md-block">
                        <table class="table table-bordered text-center mb-0" style="color: #000;">
                            <tr>
                                <td><strong>Attendees Count: </strong><span id="attendeeCount">0</span></td>
                                <td><strong>Rate per Attendee: </strong><span id="ratePerAttendee">₹0</span></td>
                                <td><strong>Base Price: </strong><span id="registrationFee">₹0</span></td>
                                <td id="gstCell"><strong><span id="gstLabel">GST (18%)</span>: </strong><span id="gstAmount">₹0</span></td>
                                <td><strong>Processing Charge: </strong><span id="processingCharge">₹0</span></td>
                                <td><strong>Total Amount Payable: </strong><span id="totalAmount">₹0</span></td>
                            </tr>
                        </table>
                    </div>
                    {{-- Mobile Card View --}}
                    <div class="d-md-none">
                        <div class="price-mobile-grid">
                            <div class="price-mobile-item">
                                <span class="price-label">Attendees Count</span>
                                <span class="price-value" id="attendeeCountMobile">0</span>
                            </div>
                            <div class="price-mobile-item">
                                <span class="price-label">Rate per Attendee</span>
                                <span class="price-value" id="ratePerAttendeeMobile">₹0</span>
                            </div>
                            <div class="price-mobile-item">
                                <span class="price-label">Base Price</span>
                                <span class="price-value" id="registrationFeeMobile">₹0</span>
                            </div>
                            <div class="price-mobile-item" id="gstMobileItem">
                                <span class="price-label" id="gstLabelMobile">GST (18%)</span>
                                <span class="price-value" id="gstAmountMobile">₹0</span>
                            </div>
                            <div class="price-mobile-item">
                                <span class="price-label">Processing Charge</span>
                                <span class="price-value" id="processingChargeMobile">₹0</span>
                            </div>
                            <div class="price-mobile-item price-total">
                                <span class="price-label">Total Amount Payable</span>
                                <span class="price-value" id="totalAmountMobile">₹0</span>
                            </div>
                        </div>
                    </div>
                    <div id="attendeesList" class="mt-2" style="display: none"></div>
                </div>
            </div>

            {{-- 7) Publication Permission --}}
            <div class="form-section">
               
                    <input class="form-check-input" type="checkbox" id="publication_permission" name="publication_permission" value="1" required>
                    <label class="form-check-label" for="publication_permission">
                        <strong>I grant permission to publish this abstract/poster.</strong>
                    </label>
                    <br>
                    <div class="invalid-feedback"></div>

                      <input class="form-check-input" type="checkbox" id="authors_approval" name="authors_approval" value="1" required>
                    <label class="form-check-label" for="authors_approval">
                        <strong>I declare that all authors have approved this submission and the information provided is accurate.</strong>
                    </label>
                    <div class="invalid-feedback"></div>
                
            </div>

            {{-- 7) Author(s) Approval --}}
            {{-- <div class="form-section">
                <h5 class="mb-3 border-bottom pb-2"><i class="fas fa-check-circle"></i> Author(s) Approval</h5>
                <div class="form-check">
                  
                </div>
            </div> --}}

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <strong>Note:</strong> After submitting this form, you will be redirected to preview your registration details before making payment.
            </div>

            {{-- Submit Button --}}
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-lg" id="submitForm">
                    <i class="fas fa-check me-2"></i> Submit & Preview
                </button>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    h5.border-bottom {
        color: var(--primary-color);
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- intl-tel-input -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let authorCount = -1;
    const maxAuthors = 4;
    let leadAuthorIndex = null;
    let presenterIndex = null;
    
    // Store intl-tel-input instances for phone fields
    const authorPhoneInstances = new Map();
    
    // Countries data from server
    const countriesData = @json($countries);
    
    // Pricing configuration (per attendee)
    const pricingINR = {{ config('constants.POSTER_BASE_AMOUNT_INR') }};
    const pricingUSD = {{ config('constants.POSTER_BASE_AMOUNT_USD') }};
    const gstRate = {{ config('constants.GST_RATE') }}; // GST percentage
    const indProcessingCharge = {{ config('constants.IND_PROCESSING_CHARGE') }}; // Processing charge for INR
    const intProcessingCharge = {{ config('constants.INT_PROCESSING_CHARGE') }}; // Processing charge for USD

    // Existing draft data for editing
    const existingDraft = @json($draft ?? null);
    const existingAuthors = existingDraft && existingDraft.authors ? existingDraft.authors : null;
    const existingLeadAuthorIndex = existingDraft ? (existingDraft.lead_author_index ?? 0) : 0;
    const existingPresenterIndex = existingDraft ? (existingDraft.presenter_index ?? 0) : 0;

    // Initialize authors - either from existing draft or add one empty author
    if (existingAuthors && existingAuthors.length > 0) {
        // Load existing authors
        existingAuthors.forEach((author, index) => {
            addAuthor(author, index);
        });
        // Set lead author and presenter after all authors are added
        setTimeout(() => {
            if (existingLeadAuthorIndex !== null && existingLeadAuthorIndex !== undefined) {
                const leadRadio = document.querySelector(`input[name="lead_author"][value="${existingLeadAuthorIndex}"]`);
                if (leadRadio) {
                    leadRadio.checked = true;
                    leadRadio.dispatchEvent(new Event('change'));
                }
            }
            if (existingPresenterIndex !== null && existingPresenterIndex !== undefined) {
                const presenterRadio = document.querySelector(`input[name="presenter"][value="${existingPresenterIndex}"]`);
                if (presenterRadio) {
                    presenterRadio.checked = true;
                    presenterRadio.dispatchEvent(new Event('change'));
                }
            }
            updateAttendanceSummary();
        }, 100);
    } else {
        // Add one empty author for new registrations
        addAuthor();
    }

    // Word count for abstract
    const abstractField = document.getElementById('abstract');
    const wordCountDisplay = document.getElementById('wordCount');
    
    abstractField.addEventListener('input', function() {
        const text = this.value.trim();
        const words = text.length > 0 ? text.split(/\s+/).length : 0;
        wordCountDisplay.textContent = `${words} / 250 words`;
        
        if (words > 250) {
            wordCountDisplay.classList.add('warning');
        } else {
            wordCountDisplay.classList.remove('warning');
        }
    });
    
    // Trigger initial count
    abstractField.dispatchEvent(new Event('input'));

    // Add author button
    document.getElementById('addAuthorBtn').addEventListener('click', function() {
        if (authorCount < maxAuthors - 1) {
            addAuthor();
        }
    });
    
    // Restrict phone inputs to numbers only
    function restrictToNumbers(input) {
        if (input.dataset.restricted === 'true') {
            return;
        }
        input.dataset.restricted = 'true';
        
        input.addEventListener('beforeinput', function(e) {
            if (e.inputType === 'deleteContentBackward' || 
                e.inputType === 'deleteContentForward' || 
                e.inputType === 'deleteByCut') {
                return;
            }
            if (e.data && !/^\d+$/.test(e.data)) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        }, { capture: true, passive: false });
        
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            const cursorPos = e.target.selectionStart || 0;
            const numbersOnly = value.replace(/[^\d]/g, '').replace(/\s/g, '');
            
            if (value !== numbersOnly) {
                e.target.value = numbersOnly;
                e.target.setSelectionRange(cursorPos - 1, cursorPos - 1);
            }
        });
        
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'Tab' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                e.preventDefault();
                return false;
            }
        });
    }

    function addAuthor(existingAuthorData = null, existingIndex = null) {
        if (authorCount >= maxAuthors - 1) {
            Swal.fire('Maximum Reached', 'You can add maximum 4 authors.', 'warning');
            return;
        }

        authorCount++;
        const container = document.getElementById('authorsContainer');
        const authorBlock = document.createElement('div');
        authorBlock.className = 'author-block';
        authorBlock.dataset.authorIndex = authorCount;
        
        const allBlocks = document.querySelectorAll('.author-block');
        const isFirstAuthor = allBlocks.length === 0;
        
        // Determine if this author is lead/presenter based on existing data
        const isLeadAuthor = existingAuthorData ? (existingIndex === existingLeadAuthorIndex) : isFirstAuthor;
        const isPresenter = existingAuthorData ? (existingIndex === existingPresenterIndex) : isFirstAuthor;
        const willAttend = existingAuthorData ? (existingAuthorData.will_attend == 1 || existingAuthorData.will_attend === true) : isFirstAuthor;
        
        // Get existing values or defaults
        const authorTitle = existingAuthorData ? (existingAuthorData.title || '') : '';
        const authorFirstName = existingAuthorData ? (existingAuthorData.first_name || '') : '';
        const authorLastName = existingAuthorData ? (existingAuthorData.last_name || '') : '';
        const authorDesignation = existingAuthorData ? (existingAuthorData.designation || '') : '';
        const authorEmail = existingAuthorData ? (existingAuthorData.email || '') : '';
        const authorMobile = existingAuthorData ? (existingAuthorData.mobile || '') : '';
        const authorPhoneCountryCode = existingAuthorData ? (existingAuthorData.phone_country_code || '+91') : '+91';

        authorBlock.innerHTML = `
            <div class="author-block-header">
                <div>
                    <span class="author-number">Author ${authorCount + 1}</span>
                    <div class="role-badges" id="roleBadges${authorCount}"></div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-author-btn" onclick="removeAuthor(${authorCount})" ${isFirstAuthor ? 'disabled' : ''}>
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="author_title_${authorCount}" class="form-label">Title <span class="text-danger">*</span></label>
                    <select class="form-select" id="author_title_${authorCount}" name="authors[${authorCount}][title]" required>
                        <option value="">Select Title</option>
                        <option value="Dr." ${authorTitle === 'Dr.' ? 'selected' : ''}>Dr.</option>
                        <option value="Prof." ${authorTitle === 'Prof.' ? 'selected' : ''}>Prof.</option>
                        <option value="Mr." ${authorTitle === 'Mr.' ? 'selected' : ''}>Mr.</option>
                        <option value="Ms." ${authorTitle === 'Ms.' ? 'selected' : ''}>Ms.</option>
                        <option value="Mrs." ${authorTitle === 'Mrs.' ? 'selected' : ''}>Mrs.</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-5">
                    <label for="author_first_name_${authorCount}" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_first_name_${authorCount}" name="authors[${authorCount}][first_name]" value="${authorFirstName}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-5">
                    <label for="author_last_name_${authorCount}" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_last_name_${authorCount}" name="authors[${authorCount}][last_name]" value="${authorLastName}" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="author_designation_${authorCount}" class="form-label">Designation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_designation_${authorCount}" name="authors[${authorCount}][designation]" value="${authorDesignation}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="author_email_${authorCount}" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="author_email_${authorCount}" name="authors[${authorCount}][email]" value="${authorEmail}" required>
                    <div class="invalid-feedback"></div>
                </div>
                
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="author_mobile_${authorCount}" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control author-mobile" id="author_mobile_${authorCount}" name="authors[${authorCount}][mobile]" 
                           pattern="[0-9]*" inputmode="numeric" value="${authorMobile}" required>
                    <input type="hidden" name="authors[${authorCount}][phone_country_code]" id="author_mobile_country_code_${authorCount}" value="${authorPhoneCountryCode}">
                    <div class="invalid-feedback"></div>
                </div>
               
            </div>
             <div class="form-section">
            <div class="row ">
                <div class="col-md-4">
                    <label class="form-label">is this the Lead Author? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input lead-author-checkbox" type="checkbox" id="lead_author_yes_${authorCount}" value="${authorCount}" ${isLeadAuthor ? 'checked' : ''} onchange="toggleLeadAuthor(${authorCount}, true)">
                            <label class="form-check-label" for="lead_author_yes_${authorCount}">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lead_author_no_${authorCount}" value="-1" ${!isLeadAuthor ? 'checked' : ''} onchange="toggleLeadAuthor(${authorCount}, false)">
                            <label class="form-check-label" for="lead_author_no_${authorCount}">No</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">are you a Presenter? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input presenter-checkbox" type="checkbox" id="presenter_yes_${authorCount}" name="authors[${authorCount}][is_presenter]" value="1" ${isPresenter ? 'checked' : ''} onchange="togglePresenter(${authorCount}, true)">
                            <label class="form-check-label" for="presenter_yes_${authorCount}">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="presenter_no_${authorCount}" value="0" ${!isPresenter ? 'checked' : ''} onchange="togglePresenter(${authorCount}, false)">
                            <label class="form-check-label" for="presenter_no_${authorCount}">No</label>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <label class="form-label">Will Attend Event? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input attend-checkbox" type="checkbox" id="will_attend_yes_${authorCount}" name="authors[${authorCount}][will_attend]" value="1" ${willAttend ? 'checked' : ''} onchange="toggleAttendance(${authorCount}, true)">
                            <label class="form-check-label" for="will_attend_yes_${authorCount}">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="will_attend_no_${authorCount}" value="0" ${!willAttend ? 'checked' : ''} onchange="toggleAttendance(${authorCount}, false)">
                            <label class="form-check-label" for="will_attend_no_${authorCount}">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            </div>

            <div class="row mb-3">
                <div class="col-md-6 cv-upload-section" id="cv_upload_section_${authorCount}" style="display: ${isLeadAuthor ? 'block' : 'none'};">
                    <label for="author_cv_${authorCount}" class="form-label">Upload CV (PDF only) <span class="text-danger">*</span></label>
                    <input type="file" class="form-control cv-upload-input" id="author_cv_${authorCount}" name="authors[${authorCount}][cv]" accept=".pdf" ${isLeadAuthor && !existingAuthorData ? 'required' : ''}>
                    <div class="invalid-feedback"></div>
                    <small class="text-muted">Required for Lead Author. Max file size: 5MB.${existingAuthorData && existingAuthorData.cv_path ? ' (CV already uploaded)' : ''}</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="author_country_${authorCount}" class="form-label">Country <span class="text-danger">*</span></label>
                    <select class="form-select author-country-select" id="author_country_${authorCount}" name="authors[${authorCount}][country_id]" data-author-index="${authorCount}" required>
                        <option value="">Select Country</option>
                        ${countriesData.map(country => {
                            const existingCountryId = existingAuthorData ? existingAuthorData.country_id : null;
                            const isSelected = existingCountryId ? country.id == existingCountryId : country.code === 'IN';
                            return `<option value="${country.id}" ${isSelected ? 'selected' : ''}>${country.name}</option>`;
                        }).join('')}
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="author_state_${authorCount}" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="author_state_${authorCount}" name="authors[${authorCount}][state_id]" data-existing-state="${existingAuthorData ? (existingAuthorData.state_id || '') : ''}" required disabled>
                        <option value="">Select Country First</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="author_city_${authorCount}" class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_city_${authorCount}" name="authors[${authorCount}][city]" value="${existingAuthorData ? (existingAuthorData.city || '') : ''}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="author_postal_code_${authorCount}" class="form-label">Postal Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_postal_code_${authorCount}" name="authors[${authorCount}][postal_code]" value="${existingAuthorData ? (existingAuthorData.postal_code || '') : ''}" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            
            <h6 class="mt-4 mb-3">Affiliation</h6>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="author_institution_${authorCount}" class="form-label">Institution / Organisation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_institution_${authorCount}" name="authors[${authorCount}][institution]" value="${existingAuthorData ? (existingAuthorData.institution || '') : ''}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label for="author_affiliation_city_${authorCount}" class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="author_affiliation_city_${authorCount}" name="authors[${authorCount}][affiliation_city]" value="${existingAuthorData ? (existingAuthorData.affiliation_city || '') : ''}" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-4">
                    <label for="author_affiliation_country_${authorCount}" class="form-label">Country <span class="text-danger">*</span></label>
                    <select class="form-select" id="author_affiliation_country_${authorCount}" name="authors[${authorCount}][affiliation_country_id]" required>
                        <option value="">Select Country</option>
                        ${countriesData.map(country => {
                            const existingAffCountryId = existingAuthorData ? existingAuthorData.affiliation_country_id : null;
                            const isSelected = existingAffCountryId ? country.id == existingAffCountryId : country.code === 'IN';
                            return `<option value="${country.id}" ${isSelected ? 'selected' : ''}>${country.name}</option>`;
                        }).join('')}
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        `;
        
        container.appendChild(authorBlock);
        
        // Initialize intl-tel-input for mobile number
        setTimeout(() => {
            const mobileInput = document.getElementById(`author_mobile_${authorCount}`);
            const mobileCountryCodeInput = document.getElementById(`author_mobile_country_code_${authorCount}`);
            
            if (mobileInput && typeof window.intlTelInput !== 'undefined') {
                // Apply restriction BEFORE initializing intl-tel-input
                restrictToNumbers(mobileInput);
                
                mobileInput.placeholder = '';
                const itiMobile = window.intlTelInput(mobileInput, {
                    initialCountry: 'in',
                    preferredCountries: ['in', 'us', 'gb'],
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                    separateDialCode: true,
                    nationalMode: false,
                    autoPlaceholder: 'off',
                });
                
                // Store the instance for later use
                authorPhoneInstances.set(mobileInput, itiMobile);
                
                // Re-apply restriction after intl-tel-input initialization
                restrictToNumbers(mobileInput);
                
                // Update hidden field when country changes
                mobileInput.addEventListener('countrychange', function() {
                    const selectedCountryData = itiMobile.getSelectedCountryData();
                    if (mobileCountryCodeInput && selectedCountryData && selectedCountryData.dialCode) {
                        mobileCountryCodeInput.value = '+' + selectedCountryData.dialCode;
                    }
                });
            }
        }, 100);
        
        // Load states for the selected country (existing or India default)
        const currentAuthorIndex = authorCount;
        setTimeout(() => {
            const countrySelect = document.getElementById(`author_country_${currentAuthorIndex}`);
            const stateSelect = document.getElementById(`author_state_${currentAuthorIndex}`);
            const existingStateId = stateSelect ? stateSelect.dataset.existingState : null;
            
            if (countrySelect && countrySelect.value) {
                loadStatesForAuthorCountry(countrySelect.value, currentAuthorIndex, existingStateId);
            } else {
                // Default to India
                const indiaCountry = countriesData.find(country => country.code === 'IN');
                if (indiaCountry) {
                    loadStatesForAuthorCountry(indiaCountry.id, currentAuthorIndex, existingStateId);
                }
            }
        }, 150);
        
        // Update button state
        updateAddAuthorButton();
        
        // Set lead author and presenter based on existing data or default to first author
        if (existingAuthorData) {
            // Update lead author index and presenter index based on existing data
            if (isLeadAuthor) {
                leadAuthorIndex = currentAuthorIndex;
            }
            if (isPresenter) {
                presenterIndex = currentAuthorIndex;
            }
            updateRoleBadges(currentAuthorIndex);
        } else if (authorCount === 0) {
            // Set first author as lead by default for new registrations
            leadAuthorIndex = 0;
            presenterIndex = 0;
            updateRoleBadges(0);
        }
    }

    window.removeAuthor = function(index) {
        const allBlocks = document.querySelectorAll('.author-block');
        if (allBlocks.length <= 1) {
            Swal.fire('Cannot Remove', 'At least one author is required.', 'warning');
            return;
        }

        const authorBlock = document.querySelector(`[data-author-index="${index}"]`);
        if (authorBlock) {
            // Check if removing lead author
            if (leadAuthorIndex === index) {
                Swal.fire('Cannot Remove', 'Cannot remove the Lead Author. Please assign another author as Lead Author first.', 'warning');
                return;
            }
            
            // Check if removing presenter
            if (presenterIndex === index) {
                presenterIndex = null;
            }
            
            authorBlock.remove();
            renumberAuthors();
            updateAddAuthorButton();
            updateAttendanceSummary();
        }
    }

    function renumberAuthors() {
        const blocks = document.querySelectorAll('.author-block');
        let newCount = -1;
        blocks.forEach(block => {
            newCount++;
            const oldIndex = block.dataset.authorIndex;
            block.dataset.authorIndex = newCount;
            block.querySelector('.author-number').textContent = `Author ${newCount + 1}`;
            
            // Update lead author index if needed
            if (leadAuthorIndex == oldIndex) {
                leadAuthorIndex = newCount;
            }
            
            // Update presenter index if needed
            if (presenterIndex == oldIndex) {
                presenterIndex = newCount;
            }
            
            // Enable/disable remove button
            const removeBtn = block.querySelector('.remove-author-btn');
            if (removeBtn) {
                removeBtn.disabled = blocks.length === 1;
                removeBtn.setAttribute('onclick', `removeAuthor(${newCount})`);
            }
        });
        authorCount = newCount;
    }

    function updateAddAuthorButton() {
        const btn = document.getElementById('addAuthorBtn');
        if (authorCount >= maxAuthors - 1) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-ban"></i> Maximum Authors Reached (4)';
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus"></i> Add Another Author';
        }
    }

    window.toggleLeadAuthor = function(index, isLead) {
        const yesCheckbox = document.getElementById(`lead_author_yes_${index}`);
        const noCheckbox = document.getElementById(`lead_author_no_${index}`);
        
        if (isLead) {
            // User wants to make this author the lead
            yesCheckbox.checked = true;
            noCheckbox.checked = false;
            
            // Remove lead author styling from all blocks
            document.querySelectorAll('.author-block').forEach(block => {
                block.classList.remove('lead-author');
            });
            
            // Uncheck all other "Yes" checkboxes and check their "No" checkboxes
            document.querySelectorAll('.lead-author-checkbox').forEach(checkbox => {
                const otherIndex = checkbox.value;
                if (otherIndex !== String(index)) {
                    checkbox.checked = false;
                    const otherNoCheckbox = document.getElementById(`lead_author_no_${otherIndex}`);
                    if (otherNoCheckbox) otherNoCheckbox.checked = true;
                }
            });
            
            // Add to selected block
            const selectedBlock = document.querySelector(`[data-author-index="${index}"]`);
            if (selectedBlock) {
                selectedBlock.classList.add('lead-author');
                leadAuthorIndex = index;
                updateRoleBadges(index);
            }
        } else {
            // User wants to deselect this as lead
            if (leadAuthorIndex === index) {
                // Prevent deselecting if this is the current lead author
                Swal.fire('Cannot Deselect', 'Please select another author as Lead Author before deselecting this one.', 'warning');
                yesCheckbox.checked = true;
                noCheckbox.checked = false;
                return;
            }
            yesCheckbox.checked = false;
            noCheckbox.checked = true;
        }
    }

    window.togglePresenter = function(index, isPresenter) {
        const yesCheckbox = document.getElementById(`presenter_yes_${index}`);
        const noCheckbox = document.getElementById(`presenter_no_${index}`);
        
        if (isPresenter) {
            yesCheckbox.checked = true;
            noCheckbox.checked = false;
            
            // Uncheck all other presenter "Yes" checkboxes and check their "No" checkboxes
            document.querySelectorAll('.presenter-checkbox').forEach(checkbox => {
                if (checkbox.id !== `presenter_yes_${index}`) {
                    checkbox.checked = false;
                    const otherIndex = checkbox.id.replace('presenter_yes_', '');
                    const otherNoCheckbox = document.getElementById(`presenter_no_${otherIndex}`);
                    if (otherNoCheckbox) otherNoCheckbox.checked = true;
                }
            });
            presenterIndex = index;
        } else {
            yesCheckbox.checked = false;
            noCheckbox.checked = true;
            if (presenterIndex === index) {
                presenterIndex = null;
            }
        }
        
        updateRoleBadges(index);
    }

    window.toggleAttendance = function(index, willAttend) {
        const yesCheckbox = document.getElementById(`will_attend_yes_${index}`);
        const noCheckbox = document.getElementById(`will_attend_no_${index}`);
        
        if (willAttend) {
            yesCheckbox.checked = true;
            noCheckbox.checked = false;
        } else {
            // Check if at least one author needs to attend
            const anyAttending = Array.from(document.querySelectorAll('.attend-checkbox')).some(cb => cb.checked && cb.id !== `will_attend_yes_${index}`);
            
            if (!anyAttending) {
                Swal.fire('Cannot Deselect', 'At least one author must attend the event.', 'warning');
                yesCheckbox.checked = true;
                noCheckbox.checked = false;
                return;
            }
            
            yesCheckbox.checked = false;
            noCheckbox.checked = true;
        }
        
        updateAttendanceSummary();
    }

    function updateRoleBadges(index) {
        // Update badges for all authors
        document.querySelectorAll('.author-block').forEach(block => {
            const blockIndex = parseInt(block.dataset.authorIndex);
            const badgesContainer = document.getElementById(`roleBadges${blockIndex}`);
            const cvUploadSection = document.getElementById(`cv_upload_section_${blockIndex}`);
            const cvUploadInput = document.getElementById(`author_cv_${blockIndex}`);
            
            if (badgesContainer) {
                badgesContainer.innerHTML = '';
                
                if (leadAuthorIndex === blockIndex) {
                    badgesContainer.innerHTML += '<span class="role-badge badge-lead">Lead Author</span>';
                    // Show CV upload for lead author
                    if (cvUploadSection) cvUploadSection.style.display = 'block';
                    if (cvUploadInput) cvUploadInput.required = true;
                } else {
                    // Hide CV upload for non-lead authors
                    if (cvUploadSection) cvUploadSection.style.display = 'none';
                    if (cvUploadInput) {
                        cvUploadInput.required = false;
                        cvUploadInput.value = ''; // Clear file if any
                    }
                }
                
                if (presenterIndex === blockIndex) {
                    badgesContainer.innerHTML += '<span class="role-badge badge-presenter">Presenter</span>';
                }
            }
        });
    }

    window.updateAttendanceSummary = function() {
        const attendees = [];
        let count = 0;
        
        document.querySelectorAll('.author-block').forEach(block => {
            const index = block.dataset.authorIndex;
            const willAttend = document.getElementById(`will_attend_yes_${index}`);
            const firstName = document.getElementById(`author_first_name_${index}`);
            const lastName = document.getElementById(`author_last_name_${index}`);
            
            if (willAttend && willAttend.checked) {
                count++;
                const name = (firstName?.value || '') + ' ' + (lastName?.value || '');
                attendees.push(name.trim() || `Author ${parseInt(index) + 1} (name not entered)`);
            }
        });
        
        // Calculate fee
        const currency = document.querySelector('#currency')?.value || 'INR';
        const pricePerAttendee = currency === 'INR' ? pricingINR : pricingUSD;
        const baseAmount = count * pricePerAttendee;
        
        let gstAmount = 0;
        let processingAmount = 0;
        let totalFee = baseAmount;
        let gstLabel = 'GST (18%)';
        
        // Get GST state and GST required values
        const gstRequired = document.getElementById('gst_required')?.value || '0';
        const gstState = document.getElementById('gst_state')?.value || '';
        const organizerState = '{{ config("constants.GST_STATE", "Karnataka") }}';
        const cgstRate = {{ config('constants.CGST_RATE', 9) }};
        const sgstRate = {{ config('constants.SGST_RATE', 9) }};
        
        if (currency === 'INR') {
            // For INR: Check if same state as organizer for CGST+SGST, otherwise IGST
            if (gstRequired === '1' && gstState && gstState.toLowerCase().trim() === organizerState.toLowerCase().trim()) {
                // Same state as organizer (Karnataka) - use CGST + SGST
                const cgstAmount = (baseAmount * cgstRate) / 100;
                const sgstAmount = (baseAmount * sgstRate) / 100;
                gstAmount = cgstAmount + sgstAmount;
                gstLabel = `CGST (${cgstRate}%) + SGST (${sgstRate}%)`;
            } else {
                // Different state or no GST invoice required - use IGST
                gstAmount = (baseAmount * gstRate) / 100;
                gstLabel = 'IGST (18%)';
            }
            processingAmount = ((baseAmount + gstAmount) * indProcessingCharge) / 100;
            totalFee = baseAmount + gstAmount + processingAmount;
        } else {
            // For USD: Add IGST (18%) and Processing Charge
            gstAmount = (baseAmount * gstRate) / 100;
            gstLabel = 'IGST (18%)';
            processingAmount = ((baseAmount + gstAmount) * intProcessingCharge) / 100;
            totalFee = baseAmount + gstAmount + processingAmount;
        }
        
        const currencySymbol = currency === 'INR' ? '₹' : '$';
        
        // Format numbers with commas
        const formatNumber = (num) => num.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        
        // Update the display if there are attendees
        if (count > 0) {
            // Update desktop table cells
            document.getElementById('attendeeCount').textContent = count;
            document.getElementById('ratePerAttendee').textContent = `${currencySymbol}${formatNumber(pricePerAttendee)}`;
            document.getElementById('registrationFee').textContent = `${currencySymbol}${formatNumber(baseAmount)}`;
            document.getElementById('gstLabel').textContent = gstLabel;
            document.getElementById('gstAmount').textContent = `${currencySymbol}${formatNumber(gstAmount)}`;
            document.getElementById('processingCharge').textContent = `${currencySymbol}${formatNumber(processingAmount)}`;
            document.getElementById('totalAmount').textContent = `${currencySymbol}${formatNumber(totalFee)}`;
            
            // Update mobile view elements
            document.getElementById('attendeeCountMobile').textContent = count;
            document.getElementById('ratePerAttendeeMobile').textContent = `${currencySymbol}${formatNumber(pricePerAttendee)}`;
            document.getElementById('registrationFeeMobile').textContent = `${currencySymbol}${formatNumber(baseAmount)}`;
            document.getElementById('gstLabelMobile').textContent = gstLabel;
            document.getElementById('gstAmountMobile').textContent = `${currencySymbol}${formatNumber(gstAmount)}`;
            document.getElementById('processingChargeMobile').textContent = `${currencySymbol}${formatNumber(processingAmount)}`;
            document.getElementById('totalAmountMobile').textContent = `${currencySymbol}${formatNumber(totalFee)}`;
            
            // Update attendees list
            const attendeesList = document.getElementById('attendeesList');
            if (attendees.length > 0) {
                attendeesList.innerHTML = '<small class="text-muted"><strong>Attendees:</strong><br>' + 
                    attendees.map(name => `• ${name}`).join('<br>') + '</small>';
            } else {
                attendeesList.innerHTML = '';
            }
            
            // Show the price display
            document.getElementById('priceDisplay').classList.remove('d-none');
        } else {
            // Hide the price display if no attendees
            document.getElementById('priceDisplay').classList.add('d-none');
        }
    }

    // Currency change listener
    const currencySelect = document.getElementById('currency');
    if (currencySelect) {
        currencySelect.addEventListener('change', updateAttendanceSummary);
    }
    
    // GST state change listener - update pricing when state changes
    const gstStateSelect = document.getElementById('gst_state');
    if (gstStateSelect) {
        gstStateSelect.addEventListener('change', updateAttendanceSummary);
    }
    
    // GST required change listener - update pricing when GST invoice option changes
    const gstRequiredSelect = document.getElementById('gst_required');
    if (gstRequiredSelect) {
        gstRequiredSelect.addEventListener('change', updateAttendanceSummary);
    }
    
    // Function to load states for a country
    function loadStatesForAuthorCountry(countryId, authorIndex, existingStateId = null) {
        const stateSelect = document.getElementById(`author_state_${authorIndex}`);
        
        if (!countryId) {
            stateSelect.innerHTML = '<option value="">Select State</option>';
            stateSelect.disabled = false;
            return;
        }
        
        stateSelect.innerHTML = '<option value="">Loading states...</option>';
        stateSelect.disabled = true;
        
        fetch('{{ route("get.states") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ country_id: countryId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load states');
            }
            return response.json();
        })
        .then(data => {
            stateSelect.innerHTML = '<option value="">Select State</option>';
            if (data && data.length > 0) {
                data.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.id;
                    option.textContent = state.name;
                    // Select the existing state if provided
                    if (existingStateId && state.id == existingStateId) {
                        option.selected = true;
                    }
                    stateSelect.appendChild(option);
                });
            }
            stateSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error loading states:', error);
            stateSelect.innerHTML = '<option value="">Error loading states</option>';
            stateSelect.disabled = false;
        });
    }
    
    // Event delegation for dynamically added country selects
    document.getElementById('authorsContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('author-country-select')) {
            const authorIndex = e.target.dataset.authorIndex;
            const countryId = e.target.value;
            loadStatesForAuthorCountry(countryId, authorIndex);
        }
    });
    
    // Initial call to update attendance summary on page load
    updateAttendanceSummary();

    // Function to validate mobile number based on country code
    function validateMobileNumber(mobileInput, countryCode) {
        const mobileNumber = mobileInput.value.replace(/\s/g, '');
        const dialCode = countryCode.replace('+', '');
        
        if (!mobileNumber) {
            return { valid: false, message: 'Mobile number is required.' };
        }
        
        if (dialCode === '91') {
            // India: exactly 10 digits
            if (mobileNumber.length !== 10) {
                return { valid: false, message: 'Invalid Mobile Number.' };
            }
        } else {
            // Other countries: 6-15 digits
            if (mobileNumber.length < 6 || mobileNumber.length > 15) {
                return { valid: false, message: 'Invalid Mobile Number.' };
            }
        }
        
        return { valid: true, message: '' };
    }

    // Function to check if lead author email is unique
    async function checkLeadAuthorEmailUniqueness(email) {
        try {
            const response = await fetch('{{ route("check.author.email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            });
            
            const data = await response.json();
            return data.unique === true;
        } catch (error) {
            console.error('Error checking email uniqueness:', error);
            return true; // Allow submission if check fails
        }
    }

    // Form submission
    document.getElementById('submitForm').addEventListener('click', async function(e) {
        e.preventDefault();
        const form = document.getElementById('posterRegistrationForm');
        
        // Validation
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            
            // Find first invalid field and focus on it
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            
            Swal.fire('Validation Error', 'Please fill all required fields correctly.', 'error');
            return;
        }
        
        // Check lead author
        if (leadAuthorIndex === null || leadAuthorIndex === undefined || leadAuthorIndex < 0) {
            Swal.fire('Validation Error', 'Please select exactly one Lead Author.', 'error');
            return;
        }
        
        // Check lead author email uniqueness
        const leadAuthorEmail = document.getElementById(`author_email_${leadAuthorIndex}`);
        if (leadAuthorEmail && leadAuthorEmail.value) {
            const isUnique = await checkLeadAuthorEmailUniqueness(leadAuthorEmail.value);
            if (!isUnique) {
                leadAuthorEmail.scrollIntoView({ behavior: 'smooth', block: 'center' });
                leadAuthorEmail.focus();
                Swal.fire('Validation Error', 'This email is already registered as a lead author. Please use a different email address.', 'error');
                return;
            }
        }
        
        // Validate mobile numbers for all authors
        let mobileValidationFailed = false;
        document.querySelectorAll('.author-block').forEach(block => {
            const index = block.dataset.authorIndex;
            const mobileInput = document.getElementById(`author_mobile_${index}`);
            const countryCodeInput = document.getElementById(`author_mobile_country_code_${index}`);
            
            if (mobileInput && countryCodeInput) {
                const validation = validateMobileNumber(mobileInput, countryCodeInput.value);
                if (!validation.valid) {
                    mobileValidationFailed = true;
                    mobileInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    mobileInput.focus();
                    mobileInput.classList.add('is-invalid');
                    const feedbackDiv = mobileInput.nextElementSibling?.nextElementSibling;
                    if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                        feedbackDiv.textContent = validation.message;
                        feedbackDiv.style.display = 'block';
                    }
                    Swal.fire('Validation Error', validation.message, 'error');
                    return;
                }
            }
        });
        
        if (mobileValidationFailed) {
            return;
        }
        
        // Check lead author CV upload
        const leadAuthorCvInput = document.getElementById(`author_cv_${leadAuthorIndex}`);
        if (leadAuthorCvInput && !leadAuthorCvInput.files.length) {
            leadAuthorCvInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            Swal.fire('Validation Error', 'Please upload CV (PDF) for the Lead Author.', 'error');
            return;
        }
        
        // Check word count
        const abstract = document.getElementById('abstract').value.trim();
        const words = abstract.split(/\s+/).length;
        if (words > 250) {
            Swal.fire('Validation Error', 'Abstract exceeds 250 words. Please reduce the length.', 'error');
            return;
        }
        
        const submitBtn = this;
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        
        const formData = new FormData(form);
        
        // Combine country code and mobile number for each author
        document.querySelectorAll('.author-block').forEach(block => {
            const index = block.dataset.authorIndex;
            const mobileInput = document.getElementById(`author_mobile_${index}`);
            const countryCodeInput = document.getElementById(`author_mobile_country_code_${index}`);
            
            if (mobileInput && countryCodeInput && mobileInput.value) {
                const countryCode = countryCodeInput.value || '+91';
                const mobileNumber = mobileInput.value.replace(/\s/g, '');
                // Format: +CC-NUMBER (e.g., +91-1234567890)
                const fullPhoneNumber = `${countryCode}-${mobileNumber}`;
                formData.set(`authors[${index}][mobile]`, fullPhoneNumber);
            }
        });
        
        // Ensure lead_author has the correct value (not -1)
        formData.set('lead_author', leadAuthorIndex);
        
        fetch('{{ route("poster.register.newDraft") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                // Try to parse error as JSON, fallback to text
                return response.json().catch(() => {
                    throw new Error('Server error: ' + response.status);
                }).then(errorData => {
                    // Handle Laravel validation errors
                    if (errorData.errors) {
                        const errorMessages = Object.values(errorData.errors).flat();
                        const errorList = errorMessages.map(msg => `• ${msg}`).join('<br>');
                        throw new Error(errorList);
                    }
                    throw new Error(errorData.message || 'Validation failed. Please check the form.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    Swal.fire('Success', 'Form submitted successfully!', 'success');
                }
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            // Display error with HTML support for lists
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: error.message || 'An error occurred. Please try again.',
                confirmButtonText: 'OK'
            });
        });
    });
    
    // =============================================
    // GST Invoice Section JavaScript
    // =============================================
    
    const gstRequired = document.getElementById('gst_required');
    const gstFields = document.getElementById('gst_fields');
    const gstinFullWidth = document.getElementById('gstin_full_width');
    const gstRequiredFullWidth = document.getElementById('gst_required_full_width');
    const validateGstBtn = document.getElementById('validateGstBtn');
    const gstLoading = document.getElementById('gst_loading');
    const gstinInput = document.getElementById('gstin_input');
    const gstValidationMessage = document.getElementById('gst_validation_message');
    const contactName = document.getElementById('contact_name');
    const contactEmail = document.getElementById('contact_email');
    const contactPhone = document.getElementById('contact_phone');
    
    // Initialize intl-tel-input for contact phone
    if (contactPhone && typeof window.intlTelInput !== 'undefined') {
        const itiContactPhone = window.intlTelInput(contactPhone, {
            initialCountry: 'in',
            preferredCountries: ['in', 'us', 'gb'],
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: 'off',
        });
        
        contactPhone.addEventListener('countrychange', function() {
            const selectedCountryData = itiContactPhone.getSelectedCountryData();
            const countryCodeInput = document.getElementById('contact_phone_country_code');
            if (countryCodeInput && selectedCountryData && selectedCountryData.dialCode) {
                countryCodeInput.value = '+' + selectedCountryData.dialCode;
            }
        });
    }
    
    // Function to handle GST required change
    function handleGstRequiredChange() {
        const gstLegalNameInput = document.getElementById('gst_legal_name_input');
        const gstAddressInput = document.getElementById('gst_address_input');
        const gstStateSelect = document.getElementById('gst_state');
        const gstinLabel = document.getElementById('gstin_label');
        const gstLegalNameLabel = document.getElementById('gst_legal_name_label');
        const gstAddressLabel = document.getElementById('gst_address_label');
        const gstStateLabel = document.getElementById('gst_state_label');
        const hintText = document.getElementById('gstin_hint_text');
        
        if (gstRequired.value === '1') {
            // Show GST fields
            if (gstFields) gstFields.style.display = 'block';
            if (gstinFullWidth) gstinFullWidth.style.display = 'block';
            if (validateGstBtn) validateGstBtn.style.display = 'inline-flex';
            if (hintText) hintText.style.display = 'inline-block';
            
            // Make GST fields required
            if (gstinInput) gstinInput.setAttribute('required', 'required');
            if (gstLegalNameInput) gstLegalNameInput.setAttribute('required', 'required');
            if (gstAddressInput) gstAddressInput.setAttribute('required', 'required');
            if (gstStateSelect) gstStateSelect.setAttribute('required', 'required');
            if (contactName) contactName.setAttribute('required', 'required');
            if (contactEmail) contactEmail.setAttribute('required', 'required');
            if (contactPhone) contactPhone.setAttribute('required', 'required');
            
            // Add required-field class to labels
            if (gstinLabel && !gstinLabel.classList.contains('required-field')) gstinLabel.classList.add('required-field');
            if (gstLegalNameLabel && !gstLegalNameLabel.classList.contains('required-field')) gstLegalNameLabel.classList.add('required-field');
            if (gstAddressLabel && !gstAddressLabel.classList.contains('required-field')) gstAddressLabel.classList.add('required-field');
            if (gstStateLabel && !gstStateLabel.classList.contains('required-field')) gstStateLabel.classList.add('required-field');
            
            // Layout adjustments
            if (gstRequiredFullWidth) gstRequiredFullWidth.className = 'col-md-4 mb-2';
            if (gstinFullWidth) gstinFullWidth.className = 'col-md-8 mb-2';
            
            // Remove invalid class from GSTIN field when shown (user hasn't entered anything yet)
            if (gstinInput) {
                gstinInput.classList.remove('is-invalid');
            }
            
            // Set up validation listeners for GST fields
            if (typeof window.setupGstFieldValidation === 'function') {
                window.setupGstFieldValidation();
            }
            
            // Validate GST fields immediately when shown (skip GSTIN - it will be validated on blur/submit)
            setTimeout(function() {
                // Remove invalid class from GSTIN if it exists
                if (gstinInput) {
                    gstinInput.classList.remove('is-invalid');
                }
                // Validate other fields
                if (gstLegalNameInput) validateSingleField(gstLegalNameInput);
                if (gstAddressInput) validateSingleField(gstAddressInput);
                if (gstStateSelect) validateSingleField(gstStateSelect);
                if (contactName) validateSingleField(contactName);
                if (contactEmail) validateSingleField(contactEmail);
                if (contactPhone) validateSingleField(contactPhone);
            }, 150);
        } else {
            // Hide GST fields
            if (gstFields) gstFields.style.display = 'none';
            if (gstinFullWidth) gstinFullWidth.style.display = 'none';
            if (validateGstBtn) validateGstBtn.style.display = 'none';
            if (hintText) hintText.style.display = 'none';
            
            // Remove required attributes
            if (gstinInput) {
                gstinInput.removeAttribute('required');
                gstinInput.classList.remove('is-invalid');
            }
            if (gstLegalNameInput) {
                gstLegalNameInput.removeAttribute('required');
                gstLegalNameInput.classList.remove('is-invalid');
            }
            if (gstAddressInput) {
                gstAddressInput.removeAttribute('required');
                gstAddressInput.classList.remove('is-invalid');
            }
            if (gstStateSelect) {
                gstStateSelect.removeAttribute('required');
                gstStateSelect.classList.remove('is-invalid');
            }
            if (contactName) {
                contactName.removeAttribute('required');
                contactName.classList.remove('is-invalid');
            }
            if (contactEmail) {
                contactEmail.removeAttribute('required');
                contactEmail.classList.remove('is-invalid');
            }
            if (contactPhone) {
                contactPhone.removeAttribute('required');
                contactPhone.classList.remove('is-invalid');
            }
            
            // Remove required-field class from labels
            if (gstinLabel) gstinLabel.classList.remove('required-field');
            if (gstLegalNameLabel) gstLegalNameLabel.classList.remove('required-field');
            if (gstAddressLabel) gstAddressLabel.classList.remove('required-field');
            if (gstStateLabel) gstStateLabel.classList.remove('required-field');
            
            // Layout adjustments
            if (gstRequiredFullWidth) gstRequiredFullWidth.className = 'col-md-4 mb-2';
        }
    }
    
    // Initialize GST required change handler
    if (gstRequired) {
        gstRequired.addEventListener('change', handleGstRequiredChange);
        // Initialize on page load
        handleGstRequiredChange();
    }
    
    // Auto uppercase GSTIN input
    if (gstinInput) {
        gstinInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }
    
    // GST validation via button
    if (validateGstBtn && gstinInput) {
        validateGstBtn.addEventListener('click', function() {
            const gstin = gstinInput.value.trim().toUpperCase();
            
            // Validate format
            if (gstin.length !== 15) {
                gstValidationMessage.innerHTML = '<div class="alert alert-warning py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle"></i> GSTIN must be 15 characters</div>';
                return;
            }
            
            // Validate pattern
            const gstPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            if (!gstPattern.test(gstin)) {
                gstValidationMessage.innerHTML = '<div class="alert alert-warning py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle"></i> Invalid GSTIN format</div>';
                return;
            }
            
            // Show loading
            validateGstBtn.disabled = true;
            gstLoading.classList.remove('d-none');
            gstValidationMessage.innerHTML = '';
            
            // Make API call
            fetch('{{ route("tickets.validate-gst") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ gstin: gstin })
            })
            .then(response => {
                const status = response.status;
                return response.json().then(data => ({ status, data }));
            })
            .then(({ status, data }) => {
                gstLoading.classList.add('d-none');
                validateGstBtn.disabled = false;
                
                if (data.success) {
                    // Auto-fill form fields and make them read-only
                    const legalNameInput = document.getElementById('gst_legal_name_input');
                    const addressInput = document.getElementById('gst_address_input');
                    const stateSelect = document.getElementById('gst_state');
                    
                    if (data.gst.company_name && legalNameInput) {
                        legalNameInput.value = data.gst.company_name;
                        legalNameInput.setAttribute('readonly', 'readonly');
                        legalNameInput.style.backgroundColor = '#e9ecef';
                    }
                    if (data.gst.billing_address && addressInput) {
                        addressInput.value = data.gst.billing_address;
                        addressInput.setAttribute('readonly', 'readonly');
                        addressInput.style.backgroundColor = '#e9ecef';
                    }
                    if (data.gst.state_name && stateSelect) {
                        const apiStateName = String(data.gst.state_name).trim();
                        const stateOption = Array.from(stateSelect.options).find(opt => {
                            const optText = String(opt.text).trim().toLowerCase();
                            const optValue = String(opt.value).trim().toLowerCase();
                            const apiState = apiStateName.toLowerCase();
                            return optText === apiState || optValue === apiState;
                        });
                        
                        if (stateOption) {
                            stateSelect.value = stateOption.value;
                            stateSelect.dispatchEvent(new Event('change', { bubbles: true }));
                            stateSelect.style.backgroundColor = '#e9ecef';
                            stateSelect.disabled = false;
                        }
                    }
                    
                    gstValidationMessage.innerHTML = '<div class="alert alert-success py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-check-circle"></i> GST validated successfully.</div>';
                } else if (status === 429 || data.limit_exceeded) {
                    // Rate limit exceeded - enable manual entry
                    gstValidationMessage.innerHTML = '<div class="alert alert-warning py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>';
                    enableManualGstEntry();
                } else {
                    // Error or not found - enable manual entry
                    gstValidationMessage.innerHTML = '<div class="alert alert-info py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-info-circle"></i> ' + (data.message || 'GST not found. Please fill details manually.') + '</div>';
                    enableManualGstEntry();
                }
            })
            .catch(error => {
                gstLoading.classList.add('d-none');
                validateGstBtn.disabled = false;
                console.error('GST validation error:', error);
                gstValidationMessage.innerHTML = '<div class="alert alert-warning py-1 px-2 mb-0" style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle"></i> Error validating GST. Please fill details manually.</div>';
                enableManualGstEntry();
            });
        });
    }
    
    // Function to enable manual GST entry
    function enableManualGstEntry() {
        const legalNameInput = document.getElementById('gst_legal_name_input');
        const addressInput = document.getElementById('gst_address_input');
        const stateSelect = document.getElementById('gst_state');
        
        if (legalNameInput) {
            legalNameInput.removeAttribute('readonly');
            legalNameInput.style.backgroundColor = '';
        }
        if (addressInput) {
            addressInput.removeAttribute('readonly');
            addressInput.style.backgroundColor = '';
        }
        if (stateSelect) {
            stateSelect.disabled = false;
            stateSelect.style.backgroundColor = '';
        }
    }
    
    // ============================================
    // Real-time Field Validation (Red Border)
    // ============================================
    
    // Helper function to check if email is valid
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Function to validate a single field in real-time
    function validateSingleField(field) {
        // Skip GSTIN field - it will be validated on form submit or when Validate button is clicked
        if (field.id === 'gstin_input') {
            return;
        }
        
        // Skip hidden fields
        if (field.type === 'hidden') {
            return;
        }
        
        // Skip disabled fields (but allow readonly fields to be validated)
        if (field.disabled) {
            return;
        }
        
        // Check if field is visible
        const isVisible = field.offsetParent !== null;
        if (!isVisible) {
            return;
        }
        
        // Skip if field is not required
        if (!field.hasAttribute('required')) {
            return;
        }
        
        const fieldValue = field.value;
        const feedback = field.nextElementSibling;
        
        // Handle checkboxes and radio buttons
        if (field.type === 'checkbox' || field.type === 'radio') {
            const name = field.name;
            const form = field.closest('form');
            const checked = form.querySelector(`input[name="${name}"]:checked`);
            if (!checked) {
                field.classList.add('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            } else {
                field.classList.remove('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }
            return;
        }
        
        // Handle select fields
        if (field.tagName === 'SELECT') {
            if (!fieldValue || !fieldValue.trim()) {
                field.classList.add('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                } else {
                    const newFeedback = document.createElement('div');
                    newFeedback.className = 'invalid-feedback';
                    newFeedback.textContent = '';
                    field.parentElement.appendChild(newFeedback);
                }
            } else {
                field.classList.remove('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }
            return;
        }
        
        // Handle text inputs, textareas, etc.
        if (!fieldValue || !fieldValue.trim()) {
            field.classList.add('is-invalid');
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            } else {
                const newFeedback = document.createElement('div');
                newFeedback.className = 'invalid-feedback';
                newFeedback.textContent = '';
                field.parentNode.insertBefore(newFeedback, field.nextSibling);
            }
        } else {
            field.classList.remove('is-invalid');
            
            // Additional validations
            if (field.type === 'email' && !isValidEmail(fieldValue)) {
                field.classList.add('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Please enter a valid email address.';
                }
            } else {
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }
        }
    }
    
    // Set up validation listeners for a field
    function setupFieldValidation(field) {
        if (!field) {
            return;
        }
        
        const blurHandler = function() {
            validateSingleField(this);
        };
        const changeHandler = function() {
            validateSingleField(this);
        };
        const inputHandler = function() {
            validateSingleField(this);
        };
        
        // Validate field on blur (when user leaves the field)
        field.removeEventListener('blur', blurHandler);
        field.addEventListener('blur', blurHandler);
        
        // Validate field on change (for select, radio, checkbox)
        field.removeEventListener('change', changeHandler);
        field.addEventListener('change', changeHandler);
        
        // Validate field on input (for real-time feedback)
        field.removeEventListener('input', inputHandler);
        field.addEventListener('input', inputHandler);
    }
    
    // Set up validation for all required fields in the form
    const posterForm = document.getElementById('posterRegistrationForm');
    if (posterForm) {
        posterForm.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
            setupFieldValidation(field);
        });
        
        // Set up validation for dynamically shown GST fields
        window.setupGstFieldValidation = function() {
            const gstinInput = document.getElementById('gstin_input');
            const gstLegalNameInput = document.getElementById('gst_legal_name_input');
            const gstAddressInput = document.getElementById('gst_address_input');
            const gstStateSelect = document.getElementById('gst_state');
            const contactNameInput = document.getElementById('contact_name');
            const contactEmailInput = document.getElementById('contact_email');
            const contactPhoneInput = document.getElementById('contact_phone');
            
            if (gstinInput) setupFieldValidation(gstinInput);
            if (gstLegalNameInput) setupFieldValidation(gstLegalNameInput);
            if (gstAddressInput) setupFieldValidation(gstAddressInput);
            if (gstStateSelect) setupFieldValidation(gstStateSelect);
            if (contactNameInput) setupFieldValidation(contactNameInput);
            if (contactEmailInput) setupFieldValidation(contactEmailInput);
            if (contactPhoneInput) setupFieldValidation(contactPhoneInput);
        };
    }
    
    // Initial validation: Mark all empty required fields as invalid immediately on page load
    if (posterForm) {
        setTimeout(function() {
            posterForm.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
                // Skip hidden and disabled fields
                if (field.type === 'hidden' || field.disabled) {
                    return;
                }
                
                // Check if field is visible
                const isVisible = field.offsetParent !== null;
                if (!isVisible) {
                    return;
                }
                
                // Validate field immediately on page load - fields will show red if empty
                validateSingleField(field);
            });
        }, 300);
    }
});
</script>
@endpush
@endsection
