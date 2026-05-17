<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProofOfDelivery extends Model
{
    protected $fillable = [
        'delivery_id',
        'pod_code',
        'recipient_name',
        'recipient_signature_path',
        'pod_document_path',
        'photo_path',
        'delivery_time',
        'notes',
        'uploaded_by',
        'uploaded_at',
    ];

    protected $casts = [
        'delivery_time' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function uploadedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
