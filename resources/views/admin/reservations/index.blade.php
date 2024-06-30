@extends('admin.layout')

@section('title')
    予約一覧
@endsection

@section('content')
<h1>予約一覧</h1>
<table>
    <thead>
        <tr>
            <th>予約ID</th>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>映画名</th>
            <th>開始時間</th>
            <th>座席</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
            <tr>
                <td>{{$reservation->id}}</td>
                <td>{{$reservation->user->name}}</td>
                <td>{{$reservation->user->email}}</td>
                <td>{{$reservation->schedule->movie->title}}</td>
                <td>{{$reservation->schedule->start_time}}</td>
                <td>{{$reservation->sheet->getFormattedLocationString("A1")}}</td>
                <td>
                    <button onclick="location.href='/admin/reservations/{{$reservation->id}}'">編集</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection