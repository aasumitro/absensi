<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const ACCEPTED_ATTENDANCE_CLAIM_MODE = ['QRCODE_SCAN', 'PICTURE'];

    public const CLAIM_MODE_QRCODE = 'QRCODE_SCAN';

    public const CLAIM_MODE_PICTURE = 'PICTURE';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'absent_type_id',
        'device_id',
        'department_id',
        'attachment_out_id',
        'attachment_id',
        'type',
        'status',
        'date',
        'datetime_in',
        'datetime_out',
        'timestamp_in',
        'timestamp_out',
        'overdue',
        'overtime',
        'by',
        'latitude',
        'longitude'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }

    public function absentType(): BelongsTo
    {
        return $this->belongsTo(AbsentType::class);
    }
}
