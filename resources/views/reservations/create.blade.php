@extends('layout')

@section('title')
{{$movie->title}} 予約
@endsection


@section('content')
<h1>{{$movie->title}} 予約</h1>
<form action="/reservations/store" method="post">
    @csrf
    <input type="hidden" name="movie_id" value="{{$movie->id}}">
    <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
    <input type="hidden" name="date" value="{{$schedule->start_time_date}}">
    <input type="hidden" name="sheet_id" value="{{$sheet->id}}">
    <label for="name">名前</label>
    <input type="text" name="name" id="name">
    <span style="color:red">{{$errors->first('name')}}</span>
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email">
    <span style="color:red">{{$errors->first('email')}}</span>
    <button type="submit">予約</button>
</form>
@endsection