@extends('layouts.app')

@section('content')

<div style="max-width:1000px;margin:auto;padding:30px;">

<h2 style="margin-bottom:20px;">📄 My Internship Applications</h2>

<div style="background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);overflow:hidden;">

<table width="100%" style="border-collapse:collapse;">

<thead style="background:#f1f5f9;text-align:left;">
<tr>
<th style="padding:15px;">Internship</th>
<th style="padding:15px;">Company</th>
<th style="padding:15px;">Status</th>
<th style="padding:15px;">Applied Date</th>
</tr>
</thead>

<tbody>

@forelse($applications as $app)

<tr style="border-top:1px solid #e5e7eb;transition:0.2s;">
    
<td style="padding:15px;font-weight:500;">
{{ $app->internship->title }}
</td>

<td style="padding:15px;color:#555;">
{{ $app->internship->company_name }}
</td>

<td style="padding:15px;">

@if(strtolower($app->status) == 'hired')

<span style="
background:#dcfce7;
color:#16a34a;
padding:6px 12px;
border-radius:20px;
font-size:13px;
font-weight:600;">
🎉 Selected
</span>

@elseif(strtolower($app->status) == 'rejected')

<span style="
background:#fee2e2;
color:#dc2626;
padding:6px 12px;
border-radius:20px;
font-size:13px;
font-weight:600;">
Rejected
</span>

@else

<span style="
background:#fef3c7;
color:#d97706;
padding:6px 12px;
border-radius:20px;
font-size:13px;
font-weight:600;">
Pending
</span>

@endif

</td>

<td style="padding:15px;color:#666;">
{{ $app->created_at->format('d M Y') }}
</td>

</tr>

@empty

<tr>
<td colspan="4" style="padding:20px;text-align:center;color:#888;">
No applications yet.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection