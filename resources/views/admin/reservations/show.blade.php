@extends('admin.layout')

@section('title')
    予約編集
@endsection

@section('content')
<h1>予約編集</h1>
<form action="/admin/reservations/{{$reservation->id}}" method="post">
    @csrf
    @method('PATCH')
    <label for="schedule_id">スケジュール</label>
    <select name="schedule_id" id="schedule_id">
        @foreach ($schedules as $schedule)
            <option value="{{$schedule->id}}" @if($schedule->id == $reservation->schedule_id) selected @endif>{{$schedule->movie->title}} : {{$schedule->start_time}}</option>
        @endforeach
    </select>
    <span style="color:red">{{$errors->first('schedule_id')}}</span>
    <label for="sheet_id">座席</label>
    <select name="sheet_id" id="sheet_id">
        @foreach ($sheets as $sheet)
            <option value="{{$sheet->id}}" @if($sheet->id == $reservation->sheet_id) selected @endif>{{$sheet->location_string}}</option>
        @endforeach
    </select>
    <span style="color:red">{{$errors->first('sheet_id')}}</span>
    <label for="name">名前</label>
    <input type="text" name="name" id="name" value="{{$reservation->name}}">
    <span style="color:red">{{$errors->first('name')}}</span>
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email" value="{{$reservation->email}}">
    <span style="color:red">{{$errors->first('email')}}</span>
    <button type="submit">予約</button>
</form>

<form action="/admin/reservations/{{$reservation->id}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">予約を削除する</button>
</form>
@endsection