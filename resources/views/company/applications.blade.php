@extends('layouts.app')

@section('content')

<div style="max-width:1100px;margin:auto;background:white;padding:30px;border-radius:10px">

<h2>Student Applications</h2>

@if($applications->count() == 0)

<p style="color:gray;">No applications received yet.</p>

@else

<table border="1" cellpadding="10" width="100%" style="border-collapse:collapse;">

<tr style="background:#f4f6f9;">
<th>Student Name</th>
<th>Email</th>
<th>Internship</th>
<th>Student Skills</th>
<th>Required Skills</th>
<th>Missing Skills</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($applications as $app)

@php

$studentSkills = $app->student->skills ?? [];
$requiredSkills = $app->internship->required_skills ?? [];

if(!is_array($studentSkills)){
    $studentSkills = explode(',', $studentSkills);
}

if(!is_array($requiredSkills)){
    $requiredSkills = explode(',', $requiredSkills);
}

$missingSkills = array_diff($requiredSkills, $studentSkills);

@endphp

<tr>

<td>{{ $app->student->name ?? 'N/A' }}</td>

<td>{{ $app->student->email ?? 'N/A' }}</td>

<td>{{ $app->internship->title ?? 'N/A' }}</td>

<td>

@if(count($studentSkills) > 0)
{{ implode(', ', $studentSkills) }}
@else
<span style="color:red;">No Skills</span>
@endif

</td>

<td>

@if(count($requiredSkills) > 0)
{{ implode(', ', $requiredSkills) }}
@endif

</td>

<td>

@if(count($missingSkills) > 0)
<span style="color:red;">
{{ implode(', ', $missingSkills) }}
</span>
@else
<span style="color:green;">All Skills Matched</span>
@endif

</td>

<td>

@if($app->status == 'pending')
<span style="color:orange;font-weight:bold;">Pending</span>

@elseif($app->status == 'hired')
<span style="color:green;font-weight:bold;">Hired</span>

@elseif($app->status == 'rejected')
<span style="color:red;font-weight:bold;">Rejected</span>

@endif

</td>

<td>

@if($app->status == 'pending')

<form action="{{ route('company.accept',$app->id) }}" method="POST" style="display:inline;">
@csrf
<button type="submit" 
style="background:green;color:white;border:none;padding:6px 10px;border-radius:5px;">
Accept
</button>
</form>

<form action="{{ route('company.reject',$app->id) }}" method="POST" style="display:inline;">
@csrf
<button type="submit" 
style="background:red;color:white;border:none;padding:6px 10px;border-radius:5px;">
Reject
</button>
</form>

@else

<span style="color:gray;">Action Completed</span>

@endif

</td>

</tr>

@endforeach

</table>

@endif

</div>

@endsection