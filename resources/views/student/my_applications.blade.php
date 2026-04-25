@extends('layouts.app')

@section('content')

<div style="max-width:900px;margin:auto;padding:30px;">

<h2>📄 My Internship Applications</h2>

<table border="1" cellpadding="10" width="100%" style="background:white;margin-top:20px;">

<tr>
<th>Internship</th>
<th>Company</th>
<th>Status</th>
<th>Applied Date</th>
</tr>

@forelse($applications as $app)

<tr>

<td>{{ $app->internship->title }}</td>

<td>{{ $app->internship->company_name }}</td>

<td>

@if(strtolower($app->status) == 'hired')

<span style="color:green;font-weight:bold;">🎉 Selected</span>

@elseif(strtolower($app->status) == 'rejected')

<span style="color:red;font-weight:bold;">Rejected</span>

@else

<span style="color:orange;font-weight:bold;">Pending</span>

@endif

</td>

<td>{{ $app->created_at->format('d M Y') }}</td>

</tr>

@empty

<tr>
<td colspan="4">No applications yet.</td>
</tr>

@endforelse

</table>

</div>

@endsection