@extends('layout.layout')
@section('title')
    Notes
@endsection
@section('container')
    @if(count($notes) > 0)
        <table>
            <tr>
                <th>Note</th>
                <th>Teacher</th>
            </tr>

        @foreach($notes as $note)
            <tr>
                <td>
                    {{$note->note}}
                </td>
                <td>
                    {{$note->teacher}}
                </td>
            </tr>
        @endforeach
        </table>
    @else
        <p>No notes.</p>
    @endif
@endsection