@extends('layouts.admin')

@section('content')

<h2>Admin Reports</h2>

<div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

    <a href="{{ route('admin.reports.export','students') }}" 
       style="background:blue;color:white;padding:8px 12px;text-decoration:none;">
        Export Students
    </a>

    <a href="{{ route('admin.reports.export','companies') }}" 
       style="background:green;color:white;padding:8px 12px;text-decoration:none;">
        Export Companies
    </a>

    <a href="{{ route('admin.reports.export','internships') }}" 
       style="background:orange;color:white;padding:8px 12px;text-decoration:none;">
        Export Internships
    </a>

    <a href="{{ route('admin.reports.export','applications') }}" 
       style="background:red;color:white;padding:8px 12px;text-decoration:none;">
        Export Applications
    </a>

    <a href="{{ route('admin.reports.export','approved') }}" 
       style="background:darkgreen;color:white;padding:8px 12px;text-decoration:none;">
        Export Approved
    </a>

    <a href="{{ route('admin.reports.export','rejected') }}" 
       style="background:brown;color:white;padding:8px 12px;text-decoration:none;">
        Export Rejected
    </a>

</div>

<hr>

<h3>Recent Applications</h3>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

    <tr style="background:#eee;">
        <th>ID</th>
        <th>Student</th>
        <th>Email</th>
        <th>Internship</th>
        <th>Company</th>
        <th>Status</th>
        <th>Applied At</th>
    </tr>

    @foreach($applications as $app)
    <tr>
        <td>{{ $app->id }}</td>

        <td>
            {{ $app->student->name ?? '' }}
        </td>

        <td>
            {{ $app->student->user->email ?? '' }}
        </td>

        <td>
            {{ $app->internship->title ?? '' }}
        </td>

        <td>
            {{ $app->internship->company->company_name ?? '' }}
        </td>

        <td>
            {{ $app->status }}
        </td>

        <td>
            {{ $app->created_at }}
        </td>
    </tr>
    @endforeach

</table>

@endsection