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
                    <td><a href="">Edit</a></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection