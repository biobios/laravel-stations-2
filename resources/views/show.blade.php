@extends('layout')

@section('title')
    {{$movie->title}}
@endsection

@section('content')
    <h1>{{$movie->title}}</h1>
    <div>
        <img src="{{$movie->image_url}}" alt="{{$movie->title}}">
    </div>
    <p>公開年：{{$movie->published_year}}</p>
    <p>{{$movie->description}}</p>

    <h2>上映スケジュール</h2>
    <table>
        <thead>
            <tr>
                <th>開始時間</th>
                <th>終了時間</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{$schedule->start_time}}</td>
                    <td>{{$schedule->end_time}}</td>
                    <td><button onclick="location.href='/movies/{{$movie->id}}/schedules/{{$schedule->id}}/sheets?date={{$schedule->start_time_date}}'">座席を予約する</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection