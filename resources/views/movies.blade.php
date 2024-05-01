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
    <form action="/movies" method="get">
        <input type="text" name="keyword" value="{{ $search->keyword }}">
        <input type="radio" name="is_showing" value="all" {{ $search->doFilterByKeyword ? '' : 'checked' }}>
        <label>すべて</label>
        <input type="radio" name="is_showing" value="0" {{ $search->is_showing === "0" ? 'checked' : '' }}>
        <label>上映予定</label>
        <input type="radio" name="is_showing" value="1" {{ $search->is_showing === "1" ? 'checked' : '' }}>
        <label>上映中</label>
        <button type="submit">検索</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>タイトル</th>
                <th>画像URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->image_url }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movies->links() }}
</body>
</html>