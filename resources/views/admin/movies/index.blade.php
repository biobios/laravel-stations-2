<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画一覧</title>
</head>
<body>
    <h1>映画一覧</h1>
    <table>
        <thead>
            <tr>
                <th>タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中</th>
                <th>概要</th>
                <th>登録日時</th>
                <th>更新日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->image_url }}</td>
                    <td>{{ $movie->published_year }}</td>
                    @if ($movie->is_showing)
                        <td>上映中</td>
                    @else
                        <td>上映予定</td>
                    @endif
                    <td>{{ $movie->description }}</td>
                    <td>{{ $movie->created_at }}</td>
                    <td>{{ $movie->updated_at }}</td>
                    <td>
                        <a href="/admin/movies/{{ $movie->id }}/edit">編集</a>
                        <form action="/admin/movies/{{ $movie->id }}/destroy" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>