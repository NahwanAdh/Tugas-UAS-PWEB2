<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Cek apakah ada booking lain yang bentrok pada lapangan, tanggal,
     * dan rentang jam yang sama. Hanya status pending/approved yang dianggap aktif.
     */
    public static function hasConflict(int $fieldId, string $date, string $start, string $end, ?int $excludeId = null): bool
    {
        $query = self::where('field_id', $fieldId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($start, $end) {
                // Bentrok jika rentang waktu baru overlap dengan rentang yang sudah ada
                $q->where('start_time', '<', $end)
                  ->where('end_time', '>', $start);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
