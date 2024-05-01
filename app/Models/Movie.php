<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Schedule;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'published_year',
        'description',
        'is_showing',
        'genre_id',
        'genre',
    ];

    protected $appends = [
        'genre',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * タイトルか概要にキーワードを含む映画を検索する
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByKeyword($query, $keyword)
    {
        return $query->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%');
    }

    public function scopeFilterByIsShowing($query, $is_showing)
    {
        return $query->where('is_showing', $is_showing);
    }

    // public function __set($key, $value)
    // {
    //     // genreだったら、genre_idに変換する
    //     if ($key === 'genre'){
    //         $genre = Genre::firstOrCreate(['name' => $value]);
    //         $this->genre_id = $genre->id;
    //         return;
    //     }

    //     parent::__set($key, $value);
    // }

    public function setGenreAttribute($value)
    {
        $genre = Genre::firstOrCreate(['name' => $value]);
        $this->attributes['genre_id'] = $genre->id;
    }

    public function getScreeningStatusAttribute()
    {
        return $this->is_showing ? '上映中' : '上映予定';
    }
}
