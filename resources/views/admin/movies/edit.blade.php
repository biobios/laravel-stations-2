<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画情報編集</title>
</head>
<body>
    <h1>映画情報編集</h1>
    <form action="/admin/movies/{{ $movie->id }}/update" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $movie->id }}">
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ $movie->title }}">
            <span style="color: red;">@error('title'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="image_url">画像URL</label>
            <input type="text" name="image_url" id="image_url" value="{{ $movie->image_url }}">
            <span style="color: red;">@error('image_url'){{ $message }}@enderror</span>
        </div>
        <div>
            <lavel for="genre">ジャンル</lavel>
            <input type="text" name="genre" id="genre" value="{{ $movie->genre->name }}">
            <span style="color: red;">@error('genre'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="published_year">公開年</label>
            <input type="number" name="published_year" id="published_year" value="{{ $movie->published_year }}">
            <span style="color: red;">@error('published_year'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="is_showing">上映中</label>
            <input type="checkbox" name="is_showing" id="is_showing" @if ($movie->is_showing) checked @endif>
            <span style="color: red;">@error('is_showing'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="description">概要</label>
            <textarea name="description" id="description">{{ $movie->description }}</textarea>
            <span style="color: red;">@error('description'){{ $message }}@enderror</span>
        </div>
        <button type="submit">更新</button>
    </form>
</body>
</html>