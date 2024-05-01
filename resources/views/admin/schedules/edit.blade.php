<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール編集</title>
</head>
<body>
    <h1>スケジュール編集</h1>
    <form action="/admin/schedules/{{ $schedule->id }}/update" method="post">
        @csrf
        @method('PATCH')
        <input type="hidden" name="movie_id" value="{{ $schedule->movie_id }}">
        <div>
            <label for="start_time_date">開始日</label>
            <input type="date" name="start_time_date" id="start_time_date" value="{{ $schedule->start_time_date }}">
            <span style="color: red;">@error('start_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="start_time">開始時間</label>
            <input type="time" name="start_time" id="start_time" value="{{ $schedule->start_time }}">
            <span style="color: red;">@error('start_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="end_time_date">終了日</label>
            <input type="date" name="end_time_date" id="end_time_date" value="{{ $schedule->end_time_date }}">
            <span style="color: red;">@error('end_time'){{ $message }}@enderror</span>
        </div>
        <div>
            <label for="end_time">終了時間</label>
            <input type="time" name="end_time" id="end_time" value="{{ $schedule->end_time }}">
            <span style="color: red;">@error('end_time'){{ $message }}@enderror</span>
        </div>
        <button type="submit">更新</button>
    </form>
    <form action="/admin/schedules/{{ $schedule->id }}/destroy" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
    </form>
</body>
</html>