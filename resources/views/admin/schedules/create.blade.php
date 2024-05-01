<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール作成</title>
</head>
<body>
    <h1>スケジュール作成</h1>
    <form action="/admin/movies/{{$movie->id}}/schedules/store" method="post">
        @csrf
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <div>
            <label for="start_time_date">開始日</label>
            <input type="date" name="start_time_date" id="start_time_date">
            <span style="color: red;">@error('start_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="start_time_time">開始時間</label>
            <input type="time" name="start_time_time" id="start_time_time">
            <span style="color: red;">@error('start_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="end_time_date">終了日</label>
            <input type="date" name="end_time_date" id="end_time_date">
            <span style="color: red;">@error('end_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="end_time_time">終了時間</label>
            <input type="time" name="end_time_time" id="end_time_time">
            <span style="color: red;">@error('end_time'){{ $message }}@enderror</span>
        </div>
        <button type="submit">登録</button>
    </form>
</body>
</html>