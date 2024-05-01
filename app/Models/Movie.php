<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
     * 新しい映画を作成する
     * ジャンルが存在しない場合は新しく作成する
     * もし映画の作成に失敗したら、ジャンルも作成しない
     * 
     * @param array $attributes
     * @return \App\Models\Movie
     */
    public static function create(array $attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            return static::query()->create($attributes);
        });
    }

    /**
     * 映画情報を更新する
     * ジャンルが存在しない場合は新しく作成する
     * もし映画の更新に失敗したら、ジャンルも作成しない
     * 
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        return DB::transaction(function () use ($attributes, $options) {
            return parent::update($attributes, $options);
        });
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
