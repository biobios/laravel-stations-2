@extends('layout')

@section('title')
{{$movie->title}} 予約
@endsection


@section('content')
<h1>{{$movie->title}} 予約</h1>
<p>以下の内容で予約しますか？</p>
<p>映画: {{$movie->title}}</p>
<p>日時: {{$schedule->start_time_date}} {{$schedule->start_time_time}}~</p>
<p>座席: {{$sheet->getFormattedLocationString('A-1')}}</p>
<p>おなまえ: {{$user->name}}</p>
<p>メールアドレス: {{$user->email}}</p>
<form action="/reservations/store" method="post">
    @csrf
    <input type="hidden" name="movie_id" value="{{$movie->id}}">
    <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
    <input type="hidden" name="date" value="{{$schedule->start_time_date}}">
    <input type="hidden" name="sheet_id" value="{{$sheet->id}}">
    <button type="submit">予約</button>
</form>
@endsection