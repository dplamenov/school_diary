<html lang="bg">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    @section('script')
    @show

    <title>
        @section('title')
        @show
    </title>
</head>
<body style="zoom: 120%">
<p>{{date('d.m.Y H:i:s')}}</p>
@section('container')
@show

@extends('layout.footer')