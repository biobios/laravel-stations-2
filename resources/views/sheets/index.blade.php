<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>シート一覧</title>
</head>
<body>
    <h1>シート一覧</h1>
    <table>
        <tbody>
            @foreach ($sheetsByGrid as $row)
                <tr>
                    @foreach ($row as $sheet)
                        <td>{{ $sheet->location_string }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
