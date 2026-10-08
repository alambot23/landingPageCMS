<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $guarded = [];
    protected $casts = [
        'mulai'   => 'datetime',
        'selesai' => 'datetime',
    ];

    /** Acara yang belum lewat, paling dekat lebih dulu. */
    public function scopeMendatang($query)
    {
        return $query->where(function ($q) {
            $q->where('mulai', '>=', now()->startOfDay())
              ->orWhere('selesai', '>=', now());
        })->orderBy('mulai');
    }

    /** Tautan "Tambah ke Google Calendar". */
    public function getGoogleCalendarUrlAttribute(): string
    {
        $mulai = $this->mulai->copy()->utc();
        $selesai = ($this->selesai ?? $this->mulai->copy()->addHours(2))->copy()->utc();

        return 'https://calendar.google.com/calendar/render?' . http_build_query([
            'action'   => 'TEMPLATE',
            'text'     => $this->judul,
            'dates'    => $mulai->format('Ymd\THis\Z') . '/' . $selesai->format('Ymd\THis\Z'),
            'details'  => (string) $this->deskripsi,
            'location' => (string) $this->lokasi,
        ]);
    }
}
