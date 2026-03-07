@extends('layouts.app')

@section('content')

<div style="max-width:1000px;margin:auto;background:white;padding:30px;border-radius:10px">

<h2>Student Applications</h2>

<table border="1" cellpadding="10" width="100%">
<tr>
    <th>Student Name</th>
    <th>Email</th>
    <th>Internship</th>
    <th>Status</th>
</tr>

@foreach($applications as $app)

<tr>
    <td>{{ $app->student->name }}</td>
    <td>{{ $app->student->email }}</td>
    <td>{{ $app->internship->title }}</td>
    <td>{{ $app->status }}</td>
</tr>

@endforeach

</table>

</div>

@endsection