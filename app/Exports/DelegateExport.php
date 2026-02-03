<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DelegateExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;
    protected $paymentStatus;

    public function __construct($search = '', $paymentStatus = '')
    {
        $this->search = $search;
        $this->paymentStatus = $paymentStatus;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Based on the dashboard controller, we need to query from ticket_registrations
        $query = \DB::table('ticket_registrations as tr')
            ->join('ticket_registration_categories as trc', 'tr.registration_category_id', '=', 'trc.id')
            ->leftJoin('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->leftJoin('invoices as inv', 'tr.id', '=', 'inv.registration_id')
            ->leftJoin('payments as p', function($join) {
                $join->on('inv.id', '=', 'p.invoice_id')
                     ->where('p.status', '=', 'successful');
            })
            ->where('trc.is_active', 1);

        // Apply search filters if provided
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('tr.company_name', 'like', "%{$this->search}%")
                  ->orWhere('to.order_no', 'like', "%{$this->search}%")
                  ->orWhere('tr.gstin', 'like', "%{$this->search}%");
            });
        }

        // Apply payment status filter if provided
        if ($this->paymentStatus) {
            if ($this->paymentStatus == 'Paid') {
                $query->havingRaw('COUNT(p.id) > 0');
            } else {
                $query->havingRaw('COUNT(p.id) = 0');
            }
        }

        $results = $query->select(
                'tr.id as registration_id',
                'tr.created_at as registration_date',
                'tr.industry_sector as sector',
                'tr.organisation_type as organisation_type',
                'to.order_no as tin_number',
                'tr.company_name as company_name',
                'tr.company_city as _company_city',
                'tr.company_state as _company_state',
                'tr.company_country as _company_country',
                'tr.company_phone as company_phone',
                // 'tr.company_email as company_email',
                'tr.registration_type as registration_type',
                'trc.name as registration_category',
                \DB::raw('COALESCE(MAX(p.payment_method), "Not Specified") as mode_of_payment'),
                \DB::raw('CASE WHEN COUNT(p.id) > 0 THEN "Paid" ELSE "Not Paid" END as payment_status'),
                \DB::raw('CASE WHEN MAX(inv.total_final_price) IS NOT NULL THEN MAX(inv.total_final_price) ELSE 0 END as amount'),
                \DB::raw('CASE WHEN MAX(inv.id) IS NOT NULL THEN CONCAT("INV-", MAX(inv.id)) ELSE "Payment Pending" END as invoice'),
                'tr.gstin as gst_number'
            )
            ->groupBy(
                'tr.id', 'tr.created_at', 'tr.industry_sector', 'tr.organisation_type', 
                'to.order_no', 'tr.company_name', 'tr.registration_type', 
                'trc.name', 'tr.gstin'
            )
            ->orderBy('tr.created_at', 'desc')
            ->get();

        return collect($results);
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // Get the maximum number of complimentary delegates to determine header count
        $maxDelegates = $this->getMaxDelegateCount();
        
        $baseHeaders = [
            'SR.No',
            'Registration Date',
            'Industry Sector',
            'Organisation Type',
            'Organisation Name',
            'Address',
            'City',
            'State',
            'Country',
            'Pin/Zip Code',
            'Organisation Phone/Mobile',
            'Organisation Email',
            'Delegate Type',
            'Registration Category',
            'Group Type',
            'Paymode',
            'Payment Status',
            'TIN Number',
            'PIN / PRN Number',
            'Payment Date',
            'Amount Extension',
            'Amount Per Delegate',
            'Total Selection Amount',
            'Promocode Discount',
            'Group Discount',
            'Processing Charge',
            'GST Amount',
            'IGST Amount',
            'CGST Amount',
            'SGST Amount',
            'Total Amount',
            'Amount Received',
            'Payment Gateway Capture Amount',
            'Payment Gateway Transaction ID',
        ];

        // Dynamic delegate headers based on actual maximum count
        $delegateHeaders = [];
        if ($maxDelegates > 0) {
            $delegateHeaders = array_reduce(range(1, $maxDelegates), function($carry, $i) {
                return array_merge($carry, [
                    "Title of Delegate $i", "First Name of Delegate $i", "Last Name of Delegate $i", "Email of Delegate $i", 
                    "Badge Name of Delegate $i", "Designation of Delegate $i", "Mobile of Delegate $i", "Registration Category of Delegate $i", "Amount of Delegate $i"
                ]);
            }, []);
        }
        
        return array_merge($baseHeaders, $delegateHeaders);
    }

    /**
     * Get the maximum number of ticket delegates across all registrations
     * @return int
     */
    private function getMaxDelegateCount()
    {
        $query = \DB::table('ticket_registrations as tr')
            ->join('ticket_registration_categories as trc', 'tr.registration_category_id', '=', 'trc.id')
            ->leftJoin('ticket_delegates as td', 'tr.id', '=', 'td.registration_id')
            ->leftJoin('ticket_orders as to', 'tr.id', '=', 'to.registration_id')
            ->leftJoin('invoices as inv', 'tr.id', '=', 'inv.registration_id')
            ->leftJoin('payments as p', function($join) {
                $join->on('inv.id', '=', 'p.invoice_id')
                     ->where('p.status', '=', 'successful');
            })
            ->where('trc.is_active', 1);

        // Apply same filters as in collection method
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('tr.company_name', 'like', "%{$this->search}%")
                  ->orWhere('to.order_no', 'like', "%{$this->search}%")
                  ->orWhere('tr.gstin', 'like', "%{$this->search}%");
            });
        }

        if ($this->paymentStatus) {
            if ($this->paymentStatus == 'Paid') {
                $query->havingRaw('COUNT(p.id) > 0');
            } else {
                $query->havingRaw('COUNT(p.id) = 0');
            }
        }

        // Get the maximum count of ticket delegates per registration
        $maxCount = $query->select('tr.id', \DB::raw('COUNT(td.id) as delegate_count'))
                         ->groupBy('tr.id')
                         ->get()
                         ->max('delegate_count') ?? 0;

        return $maxCount;
    }

    /**
    * @param mixed $delegate
    * @return array
    */
    public function map($delegate): array
    {
        static $index = 0;
        static $maxDelegates = null;
        
        // Get max delegate count once
        if ($maxDelegates === null) {
            $maxDelegates = $this->getMaxDelegateCount();
        }
        
        $index++;

        // Fetch ticket_orders for this registration
        $order = \DB::table('ticket_orders')->where('registration_id', $delegate->registration_id)->first();

        $baseData = [
            $index, // SR.No
            $delegate->registration_date ? date('d-M-Y', strtotime($delegate->registration_date)) : 'N/A', // Registration Date
            $delegate->sector ?? 'N/A', // Industry Sector
            $delegate->organisation_type ?? 'N/A', // Organisation Type
            $delegate->company_name ?? 'N/A', // Organisation Name
            $delegate->address ?? 'N/A', // Address
            $delegate->_company_city ?? 'N/A', // City
            $delegate->_company_state ?? 'N/A', // State
            $delegate->_company_country ?? 'N/A', // Country
            $order->postal_code ?? 'N/A', // Pin/Zip Code
            $delegate->company_phone ?? 'N/A', // Organisation Phone/Mobile
            $delegate->company_email ?? 'N/A', // Organisation Email
            $delegate->registration_type ?? 'N/A', // Delegate Type
            $delegate->registration_category ?? 'N/A', // Registration Category
            $delegate->organisation_type ?? 'N/A', // Group Type
            $delegate->mode_of_payment ?? 'N/A', // Paymode
            $delegate->payment_status ?? 'Not Paid', // Payment Status
            $delegate->tin_number ?? 'N/A', // TIN Number
            $delegate->gst_number ?? 'N/A', // PIN / PRN Number
            $order->payment_date ?? '', // Payment Date
            $order->extension_amount ?? '0.00', // Amount Extension
            $order->amount_per_delegate ?? '0.00', // Amount Per Delegate
            $order->subtotal ?? '0.00', // Total Selection Amount
            $order->promocode_discount ?? '0.00', // Promocode Discount
            $order->group_discount_amount ?? '0.00', // Group Discount
            $order->processing_charge_total ?? '0.00', // Processing Charge
            $order->gst_total ?? '0.00', // GST Amount
            $order->igst_total ?? '0.00', // IGST Amount
            $order->cgst_total ?? '0.00', // CGST Amount
            $order->sgst_total ?? '0.00', // SGST Amount
            $delegate->amount ?? '0.00', // Total Amount
            $order->amount_received ?? '0.00', // Amount Received
            $order->gateway_capture_amount ?? '0.00', // Payment Gateway Capture Amount
            $delegate->invoice ?? 'N/A', // Payment Gateway Transaction ID
        ];

        // Dynamic delegate data (only for the maximum number found)
        $delegateData = [];
        if ($maxDelegates > 0) {
            // Get delegates for this registration
            $ticketDelegates = \DB::table('ticket_delegates')
                                 ->where('registration_id', $delegate->registration_id)
                                 ->get();
            
            for ($i = 1; $i <= $maxDelegates; $i++) {
                $del = $ticketDelegates->get($i - 1); // Get delegate at index (i-1)
                
                if ($del) {
                    // If delegate exists, add their data
                    $delegateData = array_merge($delegateData, [
                        $del->salutation ?? 'Mr.', // Title
                        $del->first_name ?? 'N/A', // First Name
                        $del->last_name ?? 'N/A', // Last Name
                        $del->email ?? 'N/A', // Email
                        ($del->first_name ?? '') . ' ' . ($del->last_name ?? ''), // Badge Name
                        $del->job_title ?? 'N/A', // Designation
                        $del->phone ?? 'N/A', // Mobile
                        $delegate->registration_category ?? 'N/A', // Category
                        '0.00', // Amount
                    ]);
                } else {
                    // If no delegate, add empty values
                    $delegateData = array_merge($delegateData, [
                        'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '0.00'
                    ]);
                }
            }
        }

        return array_merge($baseData, $delegateData);
    }

    /**
    * @param Worksheet $sheet
    * @return array
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
            // Set column widths
            'A' => ['width' => 8],
            'B' => ['width' => 20],
            'C' => ['width' => 8],
            'D' => ['width' => 25],
            'E' => ['width' => 30],
            'F' => ['width' => 20],
            'G' => ['width' => 30],
            'H' => ['width' => 15],
            'I' => ['width' => 15],
            'J' => ['width' => 15],
            'K' => ['width' => 12],
            'L' => ['width' => 15],
            'M' => ['width' => 12],
            'N' => ['width' => 25],
            'O' => ['width' => 20],
            'P' => ['width' => 30],
            'Q' => ['width' => 15],
            'R' => ['width' => 15],
            'S' => ['width' => 15],
            'T' => ['width' => 20],
            'U' => ['width' => 20],
            'V' => ['width' => 15],
            'W' => ['width' => 12],
            'X' => ['width' => 15],
            'Y' => ['width' => 15],
            'Z' => ['width' => 12]
        ];
    }
}