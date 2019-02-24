<html lang="bg">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
</head>
<body style="zoom: 120%">
<p id="time">{{date('d.m.Y H:i:s')}}</p>
@section('container')
@show

@extends('layout.footer')