<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$movie->title}} 座席表</title>
</head>
<body>
    <h1>{{$movie->title}} 座席表</h1>
    <table>
        <tbody>
            @foreach ($sheetsByGrid as $row)
                <tr>
                    @foreach ($row as $sheet)
                        <td>
                            <a href="/movies/{{$movie->id}}/schedules/{{$schedule->id}}/reservations/create?date={{$schedule->start_time_date}}&sheet_id={{$sheet->id}}">
                                {{ $sheet->location_string }}
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
