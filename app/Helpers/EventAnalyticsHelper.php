<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class EventAnalyticsHelper
{
    public static function getEventAnalytics()
    {
        // Replace with actual database queries based on your table structure
        return [
            
            'total_event_delegates' => self::getTotalEventDelegates(),
            'total_normal_registered' => self::getTotalNormalRegistered(),
            'total_sponsors_registered' => self::getTotalSponsorsRegistered(),
            'total_exhibitor_registered' => self::getTotalExhibitorRegistered(),
            'total_speaker_registered' => self::getTotalSpeakerRegistered(),
            'total_invitee_registered' => self::getTotalInviteeRegistered(),
            'total_complimentary' => self::getTotalComplimentary(),
            'total_unpaid' => self::getTotalUnpaid(),
            'total_paid' => self::getTotalPaid(),
            'total_high_risk' => self::getTotalHighRisk(),
            'total_visitor_pass' => self::getTotalVisitorPass(),
            'total_enquiries' => self::getTotalEnquiries(),
        ];
    }

    /**
     * Get delegate registration analytics for dashboard
     * Includes breakdowns by category, nationality, payment status, and days access
     */
    public static function getDelegateRegistrationAnalytics()
    {
        return [
            'by_category' => self::getDelegatesByCategory(),
            'by_nationality' => self::getDelegatesByNationality(),
            'by_payment_status' => self::getDelegatesByPaymentStatus(),
            'by_days_access' => self::getDelegatesByDaysAccess(),
            'summary' => self::getDelegateSummary(),
        ];
    }

    /**
     * Get delegate counts grouped by registration category
     */
    private static function getDelegatesByCategory()
    {
        return DB::table('ticket_registration_categories as trc')
            ->leftJoin('ticket_registrations as tr', 'trc.id', '=', 'tr.registration_category_id')
            ->leftJoin('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->where('trc.is_active', 1)
            ->select(
                'trc.id as category_id',
                'trc.name as category_name',
                DB::raw('COUNT(DISTINCT td.id) as total_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN tr.nationality = "national" OR tr.nationality = "Indian" OR tr.nationality IS NULL THEN td.id END) as national_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN tr.nationality = "international" OR (tr.nationality IS NOT NULL AND tr.nationality != "national" AND tr.nationality != "Indian") THEN td.id END) as international_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status = "paid" OR to.payment_status = "complimentary" THEN td.id END) as paid_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status IS NULL OR to.payment_status = "pending" OR to.payment_status = "cancelled" THEN td.id END) as unpaid_delegates')
            )
            ->groupBy('trc.id', 'trc.name', 'trc.sort_order')
            ->orderBy('trc.sort_order')
            ->get();
    }

    /**
     * Get delegate counts grouped by nationality
     */
    private static function getDelegatesByNationality()
    {
        return DB::table('ticket_registrations as tr')
            ->join('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->select(
                DB::raw('CASE 
                    WHEN tr.nationality = "national" OR tr.nationality = "Indian" OR tr.nationality IS NULL THEN "National" 
                    ELSE "International" 
                END as nationality'),
                DB::raw('COUNT(DISTINCT td.id) as total_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status = "paid" OR to.payment_status = "complimentary" THEN td.id END) as paid_delegates'),
                DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status IS NULL OR to.payment_status = "pending" OR to.payment_status = "cancelled" THEN td.id END) as unpaid_delegates')
            )
            ->groupBy(DB::raw('CASE 
                WHEN tr.nationality = "national" OR tr.nationality = "Indian" OR tr.nationality IS NULL THEN "National" 
                ELSE "International" 
            END'))
            ->get();
    }

    /**
     * Get delegate counts grouped by payment status
     */
    private static function getDelegatesByPaymentStatus()
    {
        $paid = DB::table('ticket_registrations as tr')
            ->join('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->join('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->whereIn('to.payment_status', ['paid', 'complimentary'])
            ->count(DB::raw('DISTINCT td.id'));

        $unpaid = DB::table('ticket_registrations as tr')
            ->join('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->where(function ($query) {
                $query->whereNull('to.payment_status')
                    ->orWhereIn('to.payment_status', ['pending', 'cancelled']);
            })
            ->count(DB::raw('DISTINCT td.id'));

        return [
            'paid' => $paid,
            'unpaid' => $unpaid,
            'total' => $paid + $unpaid,
        ];
    }

    /**
     * Get delegate counts grouped by days access
     */
    private static function getDelegatesByDaysAccess()
    {
        // Get all event days
        $eventDays = DB::table('event_days')
            ->select('id', 'label', 'date')
            ->orderBy('sort_order')
            ->orderBy('date')
            ->get();

        $result = [];
        
        foreach ($eventDays as $day) {
            // Count delegates who have access to this day through their ticket type
            $delegateCount = DB::table('tickets as t')
                ->join('ticket_delegates as td', 't.delegate_id', '=', 'td.id')
                ->join('ticket_types as tt', 't.ticket_type_id', '=', 'tt.id')
                ->leftJoin('ticket_type_day_access as ttda', 'tt.id', '=', 'ttda.ticket_type_id')
                ->leftJoin('ticket_registrations as tr', 'td.registration_id', '=', 'tr.id')
                ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
                ->where(function ($query) use ($day) {
                    $query->where('tt.all_days_access', 1)
                        ->orWhere('ttda.event_day_id', $day->id);
                })
                ->where('t.status', '!=', 'cancelled')
                ->select(
                    DB::raw('COUNT(DISTINCT td.id) as total'),
                    DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status = "paid" OR to.payment_status = "complimentary" THEN td.id END) as paid'),
                    DB::raw('COUNT(DISTINCT CASE WHEN to.payment_status IS NULL OR to.payment_status = "pending" OR to.payment_status = "cancelled" THEN td.id END) as unpaid')
                )
                ->first();

            $result[] = [
                'day_id' => $day->id,
                'day_label' => $day->label,
                'day_date' => $day->date,
                'total_delegates' => $delegateCount->total ?? 0,
                'paid_delegates' => $delegateCount->paid ?? 0,
                'unpaid_delegates' => $delegateCount->unpaid ?? 0,
            ];
        }

        return $result;
    }

    /**
     * Get summary totals for delegate registration
     */
    private static function getDelegateSummary()
    {
        $total = DB::table('ticket_delegates')->count();
        
        $paid = DB::table('ticket_registrations as tr')
            ->join('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->join('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->whereIn('to.payment_status', ['paid', 'complimentary'])
            ->count(DB::raw('DISTINCT td.id'));

        $national = DB::table('ticket_registrations as tr')
            ->join('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->where(function ($query) {
                $query->where('tr.nationality', 'national')
                    ->orWhere('tr.nationality', 'Indian')
                    ->orWhereNull('tr.nationality');
            })
            ->count(DB::raw('DISTINCT td.id'));

        return [
            'total_delegates' => $total,
            'paid_delegates' => $paid,
            'unpaid_delegates' => $total - $paid,
            'national_delegates' => $national,
            'international_delegates' => $total - $national,
        ];
    }

    /**
     * Get poster registration analytics
     */
    public static function getPosterAnalytics()
    {
        $total = DB::table('poster_registrations')->count();
        $paid = DB::table('poster_registrations')->where('payment_status', 'paid')->count();
        $pending = DB::table('poster_registrations')->where('payment_status', 'pending')->count();
        
        // By currency (Indian vs International)
        $inr = DB::table('poster_registrations')->where('currency', 'INR')->count();
        $usd = DB::table('poster_registrations')->where('currency', 'USD')->count();
        
        // Revenue
        $revenueINR = DB::table('poster_registrations')
            ->where('payment_status', 'paid')
            ->where('currency', 'INR')
            ->sum('total_amount') ?? 0;
            
        $revenueUSD = DB::table('poster_registrations')
            ->where('payment_status', 'paid')
            ->where('currency', 'USD')
            ->sum('total_amount') ?? 0;
        
        // By sector
        $bySector = DB::table('poster_registrations')
            ->select(
                'sector',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid'),
                DB::raw('SUM(CASE WHEN payment_status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->groupBy('sector')
            ->orderBy('total', 'desc')
            ->get();
        
        // By presentation mode
        $byMode = DB::table('poster_registrations')
            ->select(
                'presentation_mode',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid'),
                DB::raw('SUM(CASE WHEN payment_status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->groupBy('presentation_mode')
            ->orderBy('total', 'desc')
            ->get();
        
        return [
            'total' => $total,
            'paid' => $paid,
            'pending' => $pending,
            'indian' => $inr,
            'international' => $usd,
            'revenue_inr' => $revenueINR,
            'revenue_usd' => $revenueUSD,
            'by_sector' => $bySector,
            'by_mode' => $byMode,
        ];
    }

    /**
     * Get visa clearance request analytics
     */
    public static function getVisaAnalytics()
    {
        $total = DB::table('visa_clearance_requests')->whereNull('deleted_at')->count();
        
        // By status
        $byStatus = DB::table('visa_clearance_requests')
            ->whereNull('deleted_at')
            ->select(
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        
        // By nationality
        $byNationality = DB::table('visa_clearance_requests')
            ->whereNull('deleted_at')
            ->select(
                'nationality',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('nationality')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        return [
            'total' => $total,
            'pending' => $byStatus['pending'] ?? 0,
            'approved' => $byStatus['approved'] ?? 0,
            'rejected' => $byStatus['rejected'] ?? 0,
            'processing' => $byStatus['processing'] ?? 0,
            'by_nationality' => $byNationality,
        ];
    }

    /**
     * Get recent export logs
     */
    public static function getExportLogs($limit = 10)
    {
        return DB::table('export_logs')
            ->select('export_logs.*')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private static function getTotalEventDelegates()
    {
        // Total delegates across all types - sum of all delegate categories
        $normalDelegatesArray = self::getTotalNormalRegistered();
        $normalDelegatesTotal = array_sum($normalDelegatesArray);
        $sponsorDelegates = self::getTotalSponsorsRegistered();
        $exhibitorDelegates = self::getTotalExhibitorRegistered();
        $speakerDelegates = self::getTotalSpeakerRegistered();
        $inviteeDelegates = self::getTotalInviteeRegistered();
        $complimentaryDelegates = self::getTotalComplimentary();
        $visitorPassDelegates = self::getTotalVisitorPass();
        
        return $normalDelegatesTotal + $sponsorDelegates + $exhibitorDelegates + 
               $speakerDelegates + $inviteeDelegates + $complimentaryDelegates + 
               $visitorPassDelegates;
    }

    private static function getTotalNormalRegistered()
    {
        // Get registration categories and count delegates for each category
        $results = [];
        
        // Get all registration categories with their delegate counts
        $categories = DB::table('ticket_registration_categories as trc')
            ->leftJoin('ticket_registrations as tr', function($join) {
                $join->on('trc.id', '=', 'tr.registration_category_id');
            })
            ->leftJoin('ticket_delegates as td', function($join) {
                $join->on('tr.id', '=', 'td.registration_id');
            })
            ->where('trc.is_active', 1)
            ->select('trc.name', DB::raw('COUNT(DISTINCT td.id) as delegate_count'))
            ->groupBy('trc.id', 'trc.name', 'trc.sort_order')
            ->orderBy('trc.sort_order')
            ->get();
            
        foreach ($categories as $category) {
            $results[$category->name] = (int)$category->delegate_count;
        }
        
        // If no categories found or all counts are 0, show basic count
        if (empty($results) || array_sum($results) == 0) {
            $totalDelegates = DB::table('ticket_delegates')->count();
            $results = ['Total Delegate Registration' => $totalDelegates];
        }
        
        return $results;
    }

    private static function getTotalSponsorsRegistered()
    {
        return DB::table('attendees')
            ->where('badge_category', 'sponsor')
            ->where('status', 'approved')
            ->count();
    }

    private static function getTotalExhibitorRegistered()
    {
        // Count approved applications from both exhibitor-registration and startup-zone
        $exhibitorCount = DB::table('applications')
            ->where('application_type', 'exhibitor-registration')
            ->where('submission_status', 'approved')
            ->count();
            
        $startupCount = DB::table('applications')
            ->where('application_type', 'startup-zone')
            ->where('submission_status', 'approved')
            ->count();
            
        return $exhibitorCount + $startupCount;
    }

    private static function getTotalSpeakerRegistered()
    {
        return DB::table('attendees')
            ->where('badge_category', 'speaker')
            ->where('status', 'approved')
            ->count();
    }

    private static function getTotalInviteeRegistered()
    {
        return DB::table('attendees')
            ->where('badge_category', 'invitee')
            ->where('status', 'approved')
            ->count();
    }

    private static function getTotalComplimentary()
    {
        return DB::table('complimentary_delegates')->count();
    }

    private static function getTotalUnpaid()
    {
        // Count invoices that don't have successful payments
        return DB::table('invoices as i')
            ->leftJoin('payments as p', 'i.id', '=', 'p.invoice_id')
            ->where(function($query) {
                $query->whereNull('p.id')
                      ->orWhere('p.status', '!=', 'successful');
            })
            ->count();
    }

    private static function getTotalPaid()
    {
        // Count invoices with successful payments
        return DB::table('invoices as i')
            ->join('payments as p', 'i.id', '=', 'p.invoice_id')
            ->where('p.status', 'successful')
            ->count();
    }

    private static function getTotalHighRisk()
    {
        // Return 0 as high risk column may not exist in attendees table
        return 0;
    }

    private static function getTotalVisitorPass()
    {
        return DB::table('attendees')
            ->where('registration_type', 'visitor')
            ->orWhere('badge_category', 'visitor')
            ->count();
    }

    private static function getTotalEnquiries()
    {
        return DB::table('enquiries')->count();
    }
}