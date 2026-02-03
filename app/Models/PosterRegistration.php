<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosterRegistration extends Model
{
    protected $fillable = [
        'tin_no',
        'pin_no',
        'token',
        'sector',
        'currency',
        'poster_category',
        'abstract_title',
        'abstract',
        'extended_abstract_path',
        'extended_abstract_original_name',
        'authors',
        'lead_author_index',
        'presenter_index',
        'lead_author_name',
        'lead_author_email',
        'lead_author_mobile',
        'presentation_mode',
        'attendee_count',
        'base_amount',
        'gst_amount',
        'igst_rate',
        'igst_amount',
        'cgst_rate',
        'cgst_amount',
        'sgst_rate',
        'sgst_amount',
        'processing_fee',
        'processing_rate',
        'total_amount',
        'publication_permission',
        'authors_approval',
        'payment_status',
        'payment_method',
        'payment_transaction_id',
        'payment_date',
        'status',
        // GST Invoice fields
        'gst_required',
        'gstin',
        'gst_legal_name',
        'gst_address',
        'gst_state',
        'gst_country',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_phone_country_code',
    ];

    protected $casts = [
        'authors' => 'array',
        'publication_permission' => 'boolean',
        'authors_approval' => 'boolean',
        'base_amount' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'igst_rate' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'cgst_rate' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'processing_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    /**
     * Get all authors for this poster registration
     */
    public function posterAuthors(): HasMany
    {
        return $this->hasMany(PosterAuthor::class, 'poster_registration_id');
    }

    /**
     * Get the lead author for this poster registration
     */
    public function leadAuthor()
    {
        return $this->hasOne(PosterAuthor::class, 'poster_registration_id')
            ->where('is_lead_author', true);
    }

    /**
     * Get the presenter for this poster registration
     */
    public function presenter()
    {
        return $this->hasOne(PosterAuthor::class, 'poster_registration_id')
            ->where('is_presenter', true);
    }
}
