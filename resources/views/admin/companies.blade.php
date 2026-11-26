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
        <th>Status</th>
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

        <!-- ✅ STATUS -->
        <td>
            @if($company->user && $company->user->status == 'active')
                <span style="color:green;font-weight:bold;">Active</span>
            @else
                <span style="color:red;font-weight:bold;">Inactive</span>
            @endif
        </td>

        <td>

            <!-- 🔴 DEACTIVATE -->
            @if($company->user && $company->user->status == 'active')
                <a href="{{ route('admin.company.deactivate',$company->id) }}"
                   onclick="return confirm('Deactivate this company?')"
                   style="background:orange;color:white;padding:5px 10px;text-decoration:none;margin-right:5px;">
                   Deactivate
                </a>
            @else
            <!-- 🟢 ACTIVATE -->
                <a href="{{ route('admin.company.activate',$company->id) }}"
                   onclick="return confirm('Activate this company?')"
                   style="background:green;color:white;padding:5px 10px;text-decoration:none;margin-right:5px;">
                   Activate
                </a>
            @endif


        </td>

    </tr>
    @endforeach

</table>

@endsection