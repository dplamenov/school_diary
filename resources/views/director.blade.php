@extends('layout.layout')
@section('title', 'Director')
@section('container')
    <p>You`re login as director with full access</p>
    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('director/addteacher')}}">Add Teacher</a>

    <h2>List of teacher</h2>
    <table style="border: 1px">
        <tr>
            <th>Name</th>
            <th>Subject(s)</th>
        </tr>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{$teacher['name']}}</td>
                <td>{{$teacher['subject']}}</td>
            </tr>
        @endforeach
    </table>


@endsection