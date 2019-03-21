@extends('layout.layout')
@section('title')
    School info
@endsection
@section('container')
    @if(count($config) > 0)
        <table>
            @foreach($config as $value)
                <tr>
                    <td>{{$value['_key']}}</td>
                    <td>{{$value['value']}}</td>
                    <td><a href="{{url('director/edit/' . $value['id'])}}">Edit</a></td>
                </tr>
            @endforeach
        </table>
    @endif
    <p>Count of teacher: {{$teacher_count}}</p>
    <p>Count of subject: {{$subject_count}}</p>
@endsection