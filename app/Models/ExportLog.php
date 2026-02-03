<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'export_type',
        'file_name',
        'filters',
        'record_count',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'filters' => 'array',
        'record_count' => 'integer',
    ];

    /**
     * Get the user who performed the export
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an export action
     */
    public static function logExport(
        string $exportType,
        int $recordCount,
        ?string $fileName = null,
        ?array $filters = null
    ): self {
        $user = auth()->user();
        
        return self::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'Unknown',
            'user_email' => $user?->email,
            'export_type' => $exportType,
            'file_name' => $fileName,
            'filters' => $filters,
            'record_count' => $recordCount,
            'status' => 'completed',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
