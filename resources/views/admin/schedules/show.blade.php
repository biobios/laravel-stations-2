<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール</title>
</head>
<body>
    <h1>{{$schedule->movie->title}}</h1>
    <div>
        <img src="{{$schedule->movie->image_url}}" alt="{{$schedule->movie->title}}">
    </div>
    <p>公開年：{{$schedule->movie->published_year}}</p>
    <p>{{$schedule->movie->description}}</p>
    <p>開始時間：{{$schedule->start_time}}</p>
    <p>終了時間：{{$schedule->end_time}}</p>
    <a href="/admin/schedules/{{ $schedule->id }}/edit">編集</a>
</body>
</html>