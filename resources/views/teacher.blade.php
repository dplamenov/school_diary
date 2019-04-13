@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
    @if($default_password == 1)
        <p style="color: red;font-weight: bold">Change password from <a style="font-weight: bold; color: red;text-decoration: none  " href="{{url('changepassword')}}">here</a>.</p>
    @endif
    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('changepassword')}}">Change password</a>
    <p>Hello, {{explode(' ', $name)[1]}}</p>

    <div>
        @if(count($class) > 0 or count($classes) >0)
            <p>You teach the following classes:</p>
            @php($_class = '')
            @foreach($class as $item)
                @php($_class  = $item->class_name)
                <p><a href="{{url('class/' . $item->class_id)}}">{{$item->class_name}}</a> - Your class</p>
            @endforeach
            @foreach($classes as $class)
                @if($_class != $class->class_name)
                    <p><a href="{{url('class/' . $class->class_id)}}">{{$class->class_name}}</a></p>
                @endif
            @endforeach
        @else
            <p>You don`t teach.</p>
        @endif

    </div>
@endsection