<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール一覧</title>
</head>
<body>
    <h1>スケジュール一覧</h1>
    @foreach ($moviesWithSchedules as $movie)
        @if ($movie->schedules->isNotEmpty())
            <h2>{{ $movie->title }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>開始時間</th>
                        <th>終了時間</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movie->schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>
</html>