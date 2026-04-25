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

        <td>{{ $student->created_at }}</td>

        <td>

            <a href="{{ route('admin.delete.student',$student->id) }}"
               onclick="return confirm('Delete student?')"
               style="background:red;color:white;padding:5px 10px;text-decoration:none;">
               Delete
            </a>

        </td>

    </tr>
    @endforeach

</table>

@endsection