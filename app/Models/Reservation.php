<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\User;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'schedule_id',
        'sheet_id',
        'user_id',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
