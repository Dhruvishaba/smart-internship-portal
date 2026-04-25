@extends('layouts.admin')

@section('content')

<h2>All Applications</h2>

<table border="1" width="100%" cellpadding="10" cellspacing="0">

    <tr style="background:#eee;">
        <th>ID</th>
        <th>Student</th>
        <th>Email</th>
        <th>Internship</th>
        <th>Company</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($applications as $app)
    <tr>

        <td>{{ $app->id }}</td>

        <td>{{ $app->student->name ?? '' }}</td>

        <td>{{ $app->student->user->email ?? '' }}</td>

        <td>{{ $app->internship->title ?? '' }}</td>

        <td>{{ $app->internship->company->company_name ?? '' }}</td>

        <td>{{ $app->status }}</td>

        <td>

            <!-- Approve -->
            <form action="{{ route('admin.application.approve',$app->id) }}" 
                  method="POST" 
                  style="display:inline;">
                @csrf
                <button style="background:green;color:white;border:none;padding:5px 10px;">
                    Approve
                </button>
            </form>

            <!-- Reject -->
            <form action="{{ route('admin.application.reject',$app->id) }}" 
                  method="POST" 
                  style="display:inline;">
                @csrf
                <button style="background:orange;color:white;border:none;padding:5px 10px;">
                    Reject
                </button>
            </form>

            <!-- Delete -->
            <form action="{{ route('admin.application.delete',$app->id) }}" 
                  method="POST" 
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button style="background:red;color:white;border:none;padding:5px 10px;">
                    Delete
                </button>
            </form>

        </td>

    </tr>
    @endforeach

</table>

@endsection