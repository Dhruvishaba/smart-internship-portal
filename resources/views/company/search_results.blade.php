@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h3>Search Results</h3>

    @if($students->count() > 0)

        @foreach($students as $student)

        <div class="card p-4 mb-4">

            <h4>{{ $student->name }}</h4>

            <hr>

            <p><strong>Email:</strong> {{ $student->user->email ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $student->address }}</p>

            <p><strong>Skills:</strong> 
                {{ is_array($student->skills) ? implode(', ', $student->skills) : $student->skills }}
            </p>

        </div>

        @endforeach

    @else

        <p>No students found</p>

    @endif

</div>

@endsection