@extends('layout')

@section('title')
新規予約
@endsection

@section('content')

<h1>新規予約</h1>
<form action="/admin/reservations" method="post">
    @csrf
    <label for="user_id">ユーザー</label>
    <select name="user_id" id="user_id">
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}} : {{$user->email}}</option>
        @endforeach
    </select>
    <span style="color:red">{{$errors->first('user_id')}}</span>
    <label for="schedule_id">スケジュール</label>
    <select name="schedule_id" id="schedule_id">
        @foreach ($schedules as $schedule)
            <option value="{{$schedule->id}}">{{$schedule->movie->title}} : {{$schedule->start_time}}</option>
        @endforeach
    </select>
    <span style="color:red">{{$errors->first('schedule_id')}}</span>
    <label for="sheet_id">座席</label>
    <select name="sheet_id" id="sheet_id">
        @foreach ($sheets as $sheet)
            <option value="{{$sheet->id}}">{{$sheet->location_string}}</option>
        @endforeach
    </select>
    <span style="color:red">{{$errors->first('sheet_id')}}</span>
    <label for="name">名前</label>
    <input type="text" name="name" id="name">
    <span style="color:red">{{$errors->first('name')}}</span>
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email">
    <span style="color:red">{{$errors->first('email')}}</span>
    <button type="submit">予約</button>
</form>
@endsection