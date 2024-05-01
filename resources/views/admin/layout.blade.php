<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
</head>
<body>
    @if(session('message'))
        <div>
            {{session('message')}}
        </div>
    @endif
    <header>
        <h1>管理画面</h1>
        <nav>
            <ul>
                <li><a href="/admin/movies">映画一覧</a></li>
                <li><a href="/admin/schedules">スケジュール一覧</a></li>
                <li><a href="/admin/reservations">予約一覧</a></li>
            </ul>
        </nav>
    </header>
    @yield('content')
</body>