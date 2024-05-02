<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'movie_id',
        'screen_id',
        'start_time_date',
        'start_time_time',
        'end_time_date',
        'end_time_time',
    ];

    protected $appends = [
        'start_time_date',
        'start_time_time',
        'end_time_date',
        'end_time_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->start_time = new Carbon();
        $this->end_time = new Carbon();
    
        parent::__construct($attributes);
    }

    /**
     * 
     */
    public function save(array $options = [])
    {
        return DB::transaction(function () use ($options) {

            $saved = parent::save($options);
            if (!$saved) return false;

            $sql = Schedule::where('id', '<>', $this->id)
            ->where('screen_id', $this->screen_id)
            ->where('start_time', '<', $this->end_time->format('Y-m-d H:i:s'))
            ->where('end_time', '>', $this->start_time->format('Y-m-d H:i:s'));

            if($sql->exists()) {

                throw new HttpResponseException(
                    redirect()->back()
                        ->withInput()
                        ->withErrors(['screen_id' => 'スケジュールが重複しています'])
                );
            }

            return true;
        });
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function getStartTimeDateAttribute()
    {
        return $this->start_time->format('Y-m-d');
    }

    public function getStartTimeTimeAttribute()
    {
        return $this->start_time->format('H:i');
    }

    public function getEndTimeDateAttribute()
    {
        return $this->end_time->format('Y-m-d');
    }

    public function getEndTimeTimeAttribute()
    {
        return $this->end_time->format('H:i');
    }

    public function setStartTimeDateAttribute($value)
    {
        $date_v = new Carbon($value);
        $this->attributes['start_time'] = $this->start_time->setDate($date_v->year, $date_v->month, $date_v->day);
    }

    public function setStartTimeTimeAttribute($value)
    {
        $time_v = new Carbon($value);
        $this->attributes['start_time'] = $this->start_time->setTime($time_v->hour, $time_v->minute);
    }

    public function setEndTimeDateAttribute($value)
    {
        $date_v = new Carbon($value);
        $this->attributes['end_time'] = $this->end_time->setDate($date_v->year, $date_v->month, $date_v->day);
    }

    public function setEndTimeTimeAttribute($value)
    {
        $time_v = new Carbon($value);
        $this->attributes['end_time'] = $this->end_time->setTime($time_v->hour, $time_v->minute);
    }
}
