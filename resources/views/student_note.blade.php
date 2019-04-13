@extends('layout.layout')
@section('title')
    Notes
@endsection
@section('container')
    @if(count($notes) > 0)

    @else
        <p>No notes.</p>
    @endif
@endsection