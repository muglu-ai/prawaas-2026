<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    protected $table = 'rsvps';

    protected $fillable = [
        'event_id',
        'title',
        'name',
        'org',
        'desig',
        'email',
        'phone_country_code',
        'mob',
        'city',
        'country',
        'participant',
        'comment',
        'ddate',
        'ttime',
        'event_identity',
        'rsvp_location',
        'association_id',
        'association_name',
        'source_url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'ddate' => 'date',
    ];

    /**
     * Get the event for this RSVP
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class, 'event_id');
    }

    /**
     * Get the association for this RSVP
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ticket\TicketAssociation::class, 'association_id');
    }

    /**
     * Get full phone number with country code
     */
    public function getFullPhoneAttribute(): string
    {
        if ($this->phone_country_code) {
            return '+' . $this->phone_country_code . '-' . $this->mob;
        }
        return $this->mob ?? '';
    }

    /**
     * Get formatted date and time
     */
    public function getFormattedDateTimeAttribute(): string
    {
        $parts = [];
        if ($this->ddate) {
            $parts[] = $this->ddate->format('d M Y');
        }
        if ($this->ttime) {
            $parts[] = $this->ttime;
        }
        return implode(' at ', $parts);
    }
}
