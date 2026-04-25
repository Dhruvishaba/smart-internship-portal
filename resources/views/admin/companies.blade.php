@extends('layouts.admin')

@section('content')

<h2>All Companies</h2>

<table border="1" width="100%" cellpadding="10" cellspacing="0">

    <tr style="background:#eee;">
        <th>ID</th>
        <th>Company Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Technology</th>
        <th>Internship Type</th>
        <th>Action</th>
    </tr>

    @foreach($companies as $company)
    <tr>

        <td>{{ $company->id }}</td>

        <td>{{ $company->company_name }}</td>

        <td>{{ $company->user->email ?? '' }}</td>

        <td>{{ $company->contact_number }}</td>

        <td>{{ $company->address }}</td>

        <td>{{ $company->technology }}</td>

        <td>{{ $company->internship_type }}</td>

        <td>

            <a href="{{ route('admin.delete.company',$company->id) }}"
               onclick="return confirm('Delete company?')"
               style="background:red;color:white;padding:5px 10px;text-decoration:none;">
               Delete
            </a>

        </td>

    </tr>
    @endforeach

</table>

@endsection