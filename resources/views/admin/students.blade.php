@extends('layouts.admin')

@section('content')

<h2>All Students</h2>

<table border="1" width="100%" cellpadding="10" cellspacing="0">

    <tr style="background:#eee;">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Address</th>
        <th>Skills</th>
        <th>Status</th>
        <th>Registered At</th>
        <th>Action</th>
    </tr>

    @foreach($students as $student)
    <tr>

        <td>{{ $student->id }}</td>

        <td>{{ $student->name }}</td>

        <td>{{ $student->user->email ?? '' }}</td>

        <td>{{ $student->mobile }}</td>

        <td>{{ $student->address }}</td>

        <td>{{ $student->skills }}</td>

        <!-- ✅ STATUS -->
        <td>
            @if($student->user && $student->user->status == 'active')
                <span style="color:green;font-weight:bold;">Active</span>
            @else
                <span style="color:red;font-weight:bold;">Inactive</span>
            @endif
        </td>

        <td>{{ $student->created_at }}</td>

        <td>

            <!-- 🔴 DEACTIVATE -->
            @if($student->user && $student->user->status == 'active')
                <a href="{{ route('admin.student.deactivate',$student->id) }}"
                   onclick="return confirm('Deactivate this student?')"
                   style="background:orange;color:white;padding:5px 10px;text-decoration:none;margin-right:5px;">
                   Deactivate
                </a>
            @else
            <!-- 🟢 ACTIVATE -->
                <a href="{{ route('admin.student.activate',$student->id) }}"
                   onclick="return confirm('Activate this student?')"
                   style="background:green;color:white;padding:5px 10px;text-decoration:none;margin-right:5px;">
                   Activate
                </a>
            @endif

        </td>

    </tr>
    @endforeach

</table>

@endsection