<html lang="bg">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    @section('script')
    @show

    <title>
        @section('title')
        @show
    </title>
    <script>

        jQuery(document).ready(function () {
            setInterval(function () {
                getTime()
            }, 1000);
        });

        function getTime() {
            jQuery.ajax({
                url: "{{ url('system/gettime') }}",
                method: 'get',
                success: function (result) {
                    jQuery('#time').text(result);
                }
            });
        }
    </script>
    <style type="text/css">
        input[type=submit]{
            border: 0;
            padding: 3px;
            background: palegreen;
        }
    </style>
</head>
<body style="zoom: 120%">
<p id="time">{{date('d.m.Y H:i:s')}}</p>
@section('container')
@show

@extends('layout.footer')