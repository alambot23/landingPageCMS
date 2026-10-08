<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $guarded = [];

    public static function semua(): array
    {
        return Cache::rememberForever('pengaturan', fn () => static::pluck('value', 'key')->all());
    }

    public static function simpan(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::lupakan();
    }

    public static function lupakan(): void
    {
        Cache::forget('pengaturan');
    }
}
