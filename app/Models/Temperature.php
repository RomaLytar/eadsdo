<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    protected $table = 'temperatures';

    protected $fillable = [
        'city',
        'country_code',
        'temperature',
        'recorded_at',
    ];
    protected $casts = [
        'temperature' => 'float',
        'recorded_at' => 'date:Y-m-d',
    ];
    public $timestamps = false;

    /**
     * Создать запись о температуре.
     */
    public static function createFromApiData(array $data): self
    {
        return self::create([
            'city' => $data['name'],
            'country_code' => $data['sys']['country'],
            'temperature' => $data['main']['temp'],
            'recorded_at' => now()->format('Y-m-d'),
        ]);
    }
}
