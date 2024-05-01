<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画詳細</title>
</head>
<body>
    <h1>{{$movie->title}}</h1>
    <div>
        <img src="{{$movie->image_url}}" alt="{{$movie->title}}">
    </div>
    <p>公開状況：{{$movie->screening_status}}</p>
    <p>公開年：{{$movie->published_year}}</p>
    <p>{{$movie->description}}</p>
    <table>
        <thead>
            <tr>
                <th>開始時間</th>
                <th>終了時間</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movie->schedules as $schedule)
                <tr>
                    <td>{{$schedule->start_time}}</td>
                    <td>{{$schedule->end_time}}</td>
                    <td><a href="/admin/schedules/{{ $schedule->id }}/edit">編集</a></td>
                </tr>
            @endforeach
        </tbody>
</body>
</html>