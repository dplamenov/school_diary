@extends('layout.layout')
@section('title', 'Student')
@section('container')

    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('parent/register/' . $user_data['tid'])}}">Register parent</a>
    <a href="">All note</a>
    <p>Hello, {{explode(' ',$name)[1]}}</p>
    <p>Your class is {{$class}}</p>
    @if(count($notes) > 0)
        <h2>Unsigned note</h2>
        <table>

            @foreach($notes as $note)
                <tr>
                    <td>{{$note->note}}</td>
                    <td>{{$note->teacher}}</td>
                    <td><a href="">Signed</a></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection