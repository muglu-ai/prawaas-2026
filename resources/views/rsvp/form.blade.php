@extends('rsvp.layout')

@section('title', 'RSVP Form')

@push('styles')
<style>
    /* SweetAlert Custom Styling */
    .swal2-popup {
        border-radius: 15px;
    }

    .swal2-title {
        color: #333;
        font-weight: 600;
    }

    .swal2-content {
        color: #666;
    }

    .swal2-confirm {
        background-color: #20b2aa !important;
        border-color: #20b2aa !important;
    }

    .swal2-confirm:hover {
        background-color: #1a9b94 !important;
        border-color: #1a9b94 !important;
    }

    .swal2-error {
        border-color: #dc3545;
    }

    .swal2-icon.swal2-error .swal2-x-mark {
        color: #dc3545;
    }

    .form-hint {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
        <h2><i class="fas fa-calendar-check me-2"></i>RSVP Form</h2>
        <p>{{ $event->event_name ?? config('constants.EVENT_NAME', 'Event') }} {{ $event->event_year ?? config('constants.EVENT_YEAR', date('Y')) }}</p>
    </div>

    <div class="form-body">
        <!-- Progress Indicator -->
        <div class="progress-container">
            <div class="step-indicator">
                <div class="step-item active">
                    <div class="step-number">1</div>
                    <div class="step-label">Your Information</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
            <div class="progress-bar-custom">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        {{-- Section Header --}}
        <div class="mb-4">
            <h4 class="section-title"><i class="fas fa-user"></i> Provide Your Information</h4>
        </div>

        <form action="{{ route('rsvp.submit') }}" method="POST" id="rsvpForm">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id ?? '' }}">
            @if($eventIdentity)
                <input type="hidden" name="event_identity" value="{{ $eventIdentity }}">
            @endif
            @if($rsvpLocation)
                <input type="hidden" name="rsvp_location" value="{{ $rsvpLocation }}">
            @endif
            @if($eventDate)
                <input type="hidden" name="ddate" value="{{ $eventDate }}">
            @endif
            @if($eventTime)
                <input type="hidden" name="ttime" value="{{ $eventTime }}">
            @endif

            <!-- Name -->
            <div class="form-section">
                <label class="form-label">Name <span class="required">*</span></label>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <select name="title" class="form-select">
                            <option value="">-Title-</option>
                            <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                            <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                            <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                            <option value="Dr" {{ old('title') == 'Dr' ? 'selected' : '' }}>Dr</option>
                            <option value="Prof" {{ old('title') == 'Prof' ? 'selected' : '' }}>Prof</option>
                        </select>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               placeholder="Name" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Organisation / Institution / University Name -->
            <div class="form-section">
                <label class="form-label">Organization / Institution / University Name <span class="required">*</span></label>
                <input type="text" 
                       name="org" 
                       class="form-control" 
                       placeholder="Organization / Institution / University Name" 
                       value="{{ old('org') }}" 
                       required>
                @error('org')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Designation -->
            <div class="form-section">
                <label class="form-label">Designation <span class="required">*</span></label>
                <input type="text" 
                       name="desig" 
                       class="form-control" 
                       placeholder="Designation" 
                       value="{{ old('desig') }}" 
                       required>
                @error('desig')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Id -->
            <div class="form-section">
                <label class="form-label">Email Id <span class="required">*</span></label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="Email Id" 
                       value="{{ old('email') }}" 
                       required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Number -->
            <div class="form-section">
                <label class="form-label">Contact Number <span class="required">*</span></label>
                <input type="tel" 
                       name="mob" 
                       id="mob" 
                       class="form-control" 
                       value="{{ old('mob') }}" 
                       placeholder=""
                       maxlength="15"
                       pattern="[0-9]*"
                       inputmode="numeric"
                       required>
                <input type="hidden" name="phone_country_code" id="phone_country_code">
                <div class="form-hint text-primary">+Country Code-Contact Number(xxx-xxxxxxxxx)</div>
                @error('mob')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- City -->
            <div class="form-section">
                <label class="form-label">City <span class="required">*</span></label>
                <input type="text" 
                       name="city" 
                       class="form-control" 
                       placeholder="City" 
                       value="{{ old('city') }}" 
                       required>
                @error('city')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Country -->
            <div class="form-section">
                <label class="form-label">Country <span class="required">*</span></label>
                <select name="country" id="country" class="form-select" required>
                    <option value="">-- Select Country --</option>
                    @foreach($countries ?? [] as $country)
                        <option value="{{ $country->name }}" {{ old('country', 'India') == $country->name ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Your Association / Organisation Type -->
            <div class="form-section">
                <label class="form-label">Your Association / Organisation Type <span class="required">*</span></label>
                <select name="association_id" id="association_id" class="form-select" required>
                    <option value="">Select Association Name</option>
                    @foreach($associations ?? [] as $association)
                        <option value="{{ $association->id }}" {{ old('association_id') == $association->id ? 'selected' : '' }}>
                            {{ $association->name }}
                        </option>
                    @endforeach
                </select>
                @error('association_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Comment (Optional) -->
            <div class="form-section">
                <label class="form-label">Comment</label>
                <textarea name="comment" 
                          class="form-control" 
                          rows="4" 
                          maxlength="2000" 
                          placeholder="Enter your comment (optional)">{{ old('comment') }}</textarea>
                <div class="char-counter" id="charCounter">2000 characters remaining</div>
                @error('comment')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- reCAPTCHA (Enterprise v3 - invisible) -->
            @if(config('constants.RECAPTCHA_ENABLED', false))
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            @error('recaptcha')
                <div class="error-message">{{ $message }}</div>
            @enderror
            @endif

            <!-- Submit Button -->
            <div class="form-section">
                <button type="submit" class="btn-submit" id="submitBtn">
                    SUBMIT RSVP <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show validation errors via SweetAlert if any
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const errors = @json($errors->all());
            let errorMessage = '<ul style="text-align: left; margin: 10px 0;">';
            errors.forEach(function(error) {
                errorMessage += '<li>' + error + '</li>';
            });
            errorMessage += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
                confirmButtonText: 'OK',
                confirmButtonColor: '#1e3a5f',
                width: '600px'
            });
        });
    @endif

    // Initialize intl-tel-input
    const phoneInput = document.getElementById('mob');
    const phoneCountryCode = document.getElementById('phone_country_code');
    let iti = null;

    if (phoneInput) {
        phoneInput.placeholder = '';
        
        iti = window.intlTelInput(phoneInput, {
            initialCountry: 'in',
            preferredCountries: ['in', 'us', 'gb'],
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: 'off',
        });

        phoneInput.placeholder = '';
        
        setTimeout(function() {
            phoneInput.placeholder = '';
        }, 100);
        setTimeout(function() {
            phoneInput.placeholder = '';
        }, 300);

        // Restrict input to numbers only
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length > 15) {
                value = value.substring(0, 15);
            }
            if (e.target.value !== value) {
                e.target.value = value;
            }
        });

        phoneInput.addEventListener('keypress', function(e) {
            if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        phoneInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const numbers = paste.replace(/[^0-9]/g, '');
            const currentValue = phoneInput.value.replace(/[^0-9]/g, '');
            const newValue = (currentValue + numbers).substring(0, 15);
            phoneInput.value = newValue;
        });

        phoneInput.addEventListener('countrychange', function() {
            const countryData = iti.getSelectedCountryData();
            phoneCountryCode.value = countryData.dialCode;
            phoneInput.placeholder = '';
        });

        const initialCountryData = iti.getSelectedCountryData();
        phoneCountryCode.value = initialCountryData.dialCode;
    }

    // Character counter for comments
    const commentTextarea = document.querySelector('textarea[name="comment"]');
    const charCounter = document.getElementById('charCounter');
    const maxLength = 2000;

    if (commentTextarea && charCounter) {
        function updateCharCounter() {
            const remaining = maxLength - commentTextarea.value.length;
            charCounter.textContent = remaining + ' characters remaining';
            
            charCounter.classList.remove('warning', 'danger');
            if (remaining < 100) {
                charCounter.classList.add('danger');
            } else if (remaining < 200) {
                charCounter.classList.add('warning');
            }
        }

        commentTextarea.addEventListener('input', updateCharCounter);
        updateCharCounter();
    }

    // Form submission
    const form = document.getElementById('rsvpForm');
    const submitBtn = document.getElementById('submitBtn');

    // Client-side validation function
    function validateForm() {
        const errors = [];

        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                const label = form.querySelector(`label[for="${field.id}"]`) || 
                             field.closest('.form-section')?.querySelector('.form-label');
                const fieldName = label ? label.textContent.replace('*', '').trim() : field.name;
                errors.push(`${fieldName} is required.`);
            }
        });

        // Validate email format
        const emailField = form.querySelector('input[name="email"]');
        if (emailField && emailField.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value.trim())) {
                errors.push('Please enter a valid email address.');
            }
        }

        // Validate phone number
        if (iti) {
            if (!iti.isValidNumber()) {
                errors.push('Please enter a valid contact number.');
            }
        }

        return errors;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Client-side validation
        const validationErrors = validateForm();
        if (validationErrors.length > 0) {
            let errorMessage = '<ul style="text-align: left; margin: 10px 0; padding-left: 20px;">';
            validationErrors.forEach(function(error) {
                errorMessage += '<li>' + error + '</li>';
            });
            errorMessage += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
                confirmButtonText: 'OK',
                confirmButtonColor: '#1e3a5f',
                width: '600px'
            });
            return;
        }

        // Update phone country code before submit
        if (iti) {
            const countryData = iti.getSelectedCountryData();
            phoneCountryCode.value = countryData.dialCode;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

        @if(config('constants.RECAPTCHA_ENABLED', false))
        // Execute reCAPTCHA
        const siteKey = '{{ config('services.recaptcha.site_key') }}';
        
        if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && siteKey) {
            try {
                grecaptcha.enterprise.ready(function() {
                    grecaptcha.enterprise.execute(siteKey, { action: 'rsvp_submit' })
                        .then(function(token) {
                            if (!token) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'reCAPTCHA Error',
                                    text: 'Failed to get reCAPTCHA token. Please refresh and try again.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1e3a5f'
                                });
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = 'SUBMIT RSVP <i class="fas fa-arrow-right ms-2"></i>';
                                return;
                            }
                            
                            let tokenInput = form.querySelector('input[name="g-recaptcha-response"]');
                            if (!tokenInput) {
                                tokenInput = document.createElement('input');
                                tokenInput.type = 'hidden';
                                tokenInput.name = 'g-recaptcha-response';
                                form.appendChild(tokenInput);
                            }
                            tokenInput.value = token;

                            form.submit();
                        })
                        .catch(function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'reCAPTCHA Error',
                                text: 'reCAPTCHA verification failed. Please refresh the page and try again.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#1e3a5f'
                            });
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'SUBMIT RSVP <i class="fas fa-arrow-right ms-2"></i>';
                        });
                });
            } catch (err) {
                form.submit();
            }
        } else {
            form.submit();
        }
        @else
        form.submit();
        @endif
    });

    // Update progress bar
    function updateProgress() {
        const formElement = document.getElementById('rsvpForm');
        const inputs = formElement.querySelectorAll('input[required], select[required], textarea[required]');
        let filled = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                filled++;
            }
        });
        const progress = (filled / inputs.length) * 100;
        document.getElementById('progressFill').style.width = progress + '%';
    }

    form.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', updateProgress);
        element.addEventListener('change', updateProgress);
    });
    updateProgress();
</script>
@endpush
