@extends('layouts.admin')

@section('content')

<h2>Welcome Admin</h2>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:20px;">

    <div style="background:white;padding:20px;border-radius:5px;">
        <h3>{{ $students }}</h3>
        <p>Total Students</p>
    </div>

    <div style="background:white;padding:20px;border-radius:5px;">
        <h3>{{ $companies }}</h3>
        <p>Total Companies</p>
    </div>

    <div style="background:white;padding:20px;border-radius:5px;">
        <h3>{{ $internships }}</h3>
        <p>Total Internships</p>
    </div>

    <div style="background:white;padding:20px;border-radius:5px;">
        <h3>{{ $applications }}</h3>
        <p>Total Applications</p>
    </div>

</div>

@endsection