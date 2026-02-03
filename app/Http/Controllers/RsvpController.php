<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Events;
use App\Models\Country;
use App\Models\ExportLog;
use App\Mail\RsvpConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class RsvpController extends Controller
{
    /**
     * Show the RSVP form (public)
     */
    public function showForm(Request $request, $eventSlug = null)
    {
        // Get event if slug provided
        $event = null;
        if ($eventSlug) {
            $event = Events::where('slug', $eventSlug)->orWhere('id', $eventSlug)->first();
        }

        // Get all countries from database
        $countries = Country::orderBy('name')->get(['id', 'name', 'code']);

        // Get organization types from constants
        $organizationTypes = config('constants.organization_types', []);

        // Get pre-filled data from query params (for event-specific RSVPs)
        $eventIdentity = $request->query('event_identity', '');
        $rsvpLocation = $request->query('location', '');
        $eventDate = $request->query('date', '');
        $eventTime = $request->query('time', '');

        return view('rsvp.form', compact(
            'event',
            'countries',
            'organizationTypes',
            'eventIdentity',
            'rsvpLocation',
            'eventDate',
            'eventTime'
        ));
    }

    /**
     * Submit the RSVP form (public)
     */
    public function submit(Request $request)
    {
        // Verify reCAPTCHA if enabled
        $recaptchaResponse = $request->input('g-recaptcha-response');
        if (!$this->verifyRecaptcha($recaptchaResponse)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['recaptcha' => 'reCAPTCHA verification failed. Please try again.']);
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'org' => 'required|string|max:255',
            'desig' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:rsvps,email',
            'phone_country_code' => 'nullable|string|max:10',
            'mob' => 'required|string|min:6|max:20|regex:/^[0-9]+$/',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'association_name' => 'required|string|max:255',
            'registration_type' => 'required|string|max:255',
            'registration_type_other' => 'required_if:registration_type,Other|nullable|string|max:255',
            'comment' => 'nullable|string|max:2000',
            'event_identity' => 'nullable|string|max:255',
            'rsvp_location' => 'nullable|string|max:255',
            'ddate' => 'nullable|date',
            'ttime' => 'nullable|string|max:50',
            'event_id' => 'nullable|exists:events,id',
        ], [
            'name.required' => 'Name is required.',
            'org.required' => 'Organization/Institution/University name is required.',
            'desig.required' => 'Designation is required.',
            'email.required' => 'Email ID is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email has already been registered for RSVP.',
            'mob.required' => 'Contact number is required.',
            'mob.min' => 'Contact number must be at least 6 digits.',
            'mob.regex' => 'Contact number must contain only numbers.',
            'city.required' => 'City is required.',
            'country.required' => 'Country is required.',
            'association_name.required' => 'Please enter your Association Name.',
            'registration_type.required' => 'Please select a Registration Type.',
            'registration_type_other.required_if' => 'Please specify your Registration Type.',
        ]);

        try {
            // Prepare full name with title
            $fullName = $validated['name'];
            if (!empty($validated['title'])) {
                $fullName = $validated['title'] . ' ' . $fullName;
            }

            // Build participant string (can be customized based on requirements)
            $participant = $fullName;
            if (!empty($validated['org'])) {
                $participant .= ', ' . $validated['org'];
            }

            // Create RSVP
            $rsvp = Rsvp::create([
                'event_id' => $validated['event_id'] ?? null,
                'title' => $validated['title'] ?? null,
                'name' => $fullName,
                'org' => $validated['org'],
                'desig' => $validated['desig'],
                'email' => $validated['email'],
                'phone_country_code' => $validated['phone_country_code'] ?? null,
                'mob' => $validated['mob'],
                'city' => $validated['city'],
                'country' => $validated['country'],
                'participant' => $participant,
                'comment' => $validated['comment'] ?? null,
                'ddate' => $validated['ddate'] ?? null,
                'ttime' => $validated['ttime'] ?? null,
                'event_identity' => $validated['event_identity'] ?? null,
                'rsvp_location' => $validated['rsvp_location'] ?? null,
                'association_id' => null,
                'association_name' => $validated['association_name'],
                'registration_type' => $validated['registration_type'],
                'registration_type_other' => $validated['registration_type_other'] ?? null,
                'source_url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send confirmation email to user and BCC recipients
            try {
                $bccEmails = config('constants.admin_emails.bcc', []);
                
                $mail = Mail::to($rsvp->email);
                
                if (!empty($bccEmails)) {
                    $mail->bcc($bccEmails);
                }
                
                $mail->send(new RsvpConfirmationMail($rsvp));
                
                Log::info('RSVP confirmation email sent', [
                    'rsvp_id' => $rsvp->id,
                    'email' => $rsvp->email,
                    'bcc' => $bccEmails,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send RSVP confirmation email', [
                    'rsvp_id' => $rsvp->id,
                    'email' => $rsvp->email,
                    'error' => $e->getMessage(),
                ]);
                // Don't fail the submission if email fails
            }

            return redirect()->route('rsvp.thankyou')
                ->with('success', 'Thank you for your RSVP! We look forward to seeing you.')
                ->with('rsvp_id', $rsvp->id);

        } catch (\Exception $e) {
            Log::error('RSVP submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while submitting your RSVP. Please try again.']);
        }
    }

    /**
     * Show thank you page
     */
    public function thankyou(Request $request)
    {
        $rsvp = null;
        
        // First try to get from session (after form submission)
        if (session('rsvp_id')) {
            $rsvp = Rsvp::find(session('rsvp_id'));
        }
        
        // If no session, check for query parameter (for testing/direct access)
        if (!$rsvp && $request->has('id')) {
            $rsvp = Rsvp::find($request->get('id'));
        }
        
        return view('rsvp.thankyou', compact('rsvp'));
    }

    /**
     * Verify Google reCAPTCHA response
     */
    private function verifyRecaptcha($recaptchaResponse)
    {
        // If disabled via config, always pass
        if (!config('constants.RECAPTCHA_ENABLED', false)) {
            return true;
        }

        $siteKey = config('services.recaptcha.site_key');
        $projectId = config('services.recaptcha.project_id');
        $apiKey = config('services.recaptcha.api_key');
        $expectedAction = 'rsvp_submit';

        $projectId = trim($projectId, "' \"");

        if (empty($siteKey) || empty($projectId) || empty($apiKey)) {
            Log::warning('reCAPTCHA config missing for RSVP');
            return false;
        }

        if (empty($recaptchaResponse)) {
            Log::warning('reCAPTCHA token not provided by client');
            return false;
        }

        $url = sprintf(
            'https://recaptchaenterprise.googleapis.com/v1/projects/%s/assessments?key=%s',
            $projectId,
            $apiKey
        );

        try {
            $response = Http::timeout(10)->post($url, [
                'event' => [
                    'token' => $recaptchaResponse,
                    'expectedAction' => $expectedAction,
                    'siteKey' => $siteKey,
                ],
            ]);

            $result = $response->json();

            if (!$response->successful()) {
                Log::warning('reCAPTCHA Enterprise API error for RSVP', [
                    'status' => $response->status(),
                    'response' => $result,
                ]);
                return false;
            }

            $tokenProps = $result['tokenProperties'] ?? null;

            if (!$tokenProps || ($tokenProps['valid'] ?? false) !== true) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error for RSVP', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    // ==================== ADMIN METHODS ====================

    /**
     * Display a listing of RSVPs (admin)
     */
    public function index(Request $request)
    {
        $query = Rsvp::with(['event']);

        // Search functionality
        $search = $request->get('search', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('org', 'like', "%{$search}%")
                  ->orWhere('mob', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('event_identity', 'like', "%{$search}%")
                  ->orWhere('association_name', 'like', "%{$search}%");
            });
        }

        // Filter by association name
        if ($request->has('association_name') && $request->association_name !== '') {
            $query->where('association_name', $request->association_name);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSortFields = ['created_at', 'name', 'email', 'org', 'city', 'country', 'ddate'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $rsvps = $query->paginate($perPage);
        $rsvps->appends($request->query());

        // Get filter options - organization types from constants
        $organizationTypes = config('constants.organization_types', []);

        return view('rsvp.index', compact('rsvps', 'search', 'organizationTypes'));
    }

    /**
     * Show the specified RSVP (admin)
     */
    public function show($id)
    {
        $rsvp = Rsvp::with(['event'])->findOrFail($id);

        return view('rsvp.show', compact('rsvp'));
    }

    /**
     * Preview RSVP confirmation email (admin)
     */
    public function previewEmail($id)
    {
        $rsvp = Rsvp::with(['event'])->findOrFail($id);
        $mailable = new RsvpConfirmationMail($rsvp);

        return $mailable->render();
    }

    /**
     * Resend RSVP confirmation email (admin)
     */
    public function resendEmail(Request $request, $id)
    {
        $rsvp = Rsvp::with(['event'])->findOrFail($id);

        try {
            Mail::to($rsvp->email)->send(new RsvpConfirmationMail($rsvp));
            Log::info('RSVP confirmation email resent by admin', ['rsvp_id' => $rsvp->id, 'email' => $rsvp->email]);
            $message = 'Confirmation email sent successfully to ' . $rsvp->email;
        } catch (\Exception $e) {
            Log::error('RSVP resend email failed', ['rsvp_id' => $rsvp->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->back()->with('success', $message);
    }

    /**
     * Export RSVPs to CSV with log
     */
    public function export(Request $request)
    {
        $query = Rsvp::query();

        // Apply same filters as index method
        $search = $request->get('search', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('org', 'like', "%{$search}%")
                  ->orWhere('mob', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($request->has('association_name') && $request->association_name !== '') {
            $query->where('association_name', $request->association_name);
        }
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $rsvps = $query->orderBy('created_at', 'desc')->get();
        $filename = 'rsvps_' . date('Y-m-d_H-i-s') . '.csv';

        // Log export
        ExportLog::logExport(
            'rsvps',
            $rsvps->count(),
            $filename,
            [
                'search' => $search,
                'association_id' => $request->association_id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]
        );

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($rsvps) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Sr No', 'Name', 'Organization', 'Designation', 'Email',
                'Mobile', 'City', 'Country', 'Participant', 'Comment',
                'Date', 'Time', 'Event Identity', 'RSVP Location',
                'Association Name', 'Created At'
            ]);

            $srno = 1;
            foreach ($rsvps as $rsvp) {
                fputcsv($file, [
                    $srno++,
                    $rsvp->name,
                    $rsvp->org,
                    $rsvp->desig,
                    $rsvp->email,
                    $rsvp->phone_country_code ? '+' . $rsvp->phone_country_code . '-' . $rsvp->mob : $rsvp->mob,
                    $rsvp->city,
                    $rsvp->country,
                    $rsvp->participant,
                    $rsvp->comment,
                    $rsvp->ddate ? $rsvp->ddate->format('Y-m-d') : '',
                    $rsvp->ttime,
                    $rsvp->event_identity,
                    $rsvp->rsvp_location,
                    $rsvp->association_name,
                    $rsvp->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete RSVP
     */
    public function destroy($id)
    {
        $rsvp = Rsvp::findOrFail($id);
        $rsvp->delete();

        return redirect()->route('admin.rsvps.index')->with('success', 'RSVP deleted successfully.');
    }
}
