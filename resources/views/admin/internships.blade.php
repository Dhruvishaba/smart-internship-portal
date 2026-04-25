@extends('layouts.admin')

@section('content')

<h2>All Internships</h2>

<table border="1" width="100%" cellpadding="10" cellspacing="0">

    <tr style="background:#eee;">
        <th>ID</th>
        <th>Title</th>
        <th>Company</th>
        <th>Skills</th>
        <th>Duration</th>
        <th>Stipend</th>
        <th>Location</th>
        <th>Deadline</th>
        <th>Action</th>
    </tr>

    @foreach($internships as $internship)
    <tr>

        <td>{{ $internship->id }}</td>

        <td>{{ $internship->title }}</td>

        <td>{{ $internship->company->company_name ?? '' }}</td>

        <td>{{ $internship->required_skills }}</td>

        <td>{{ $internship->duration }}</td>

        <td>{{ $internship->stipend }}</td>

        <td>{{ $internship->address }}</td>

        <td>{{ $internship->application_deadline }}</td>

        <td>

            <a href="{{ route('admin.delete.internship',$internship->id) }}"
               onclick="return confirm('Delete internship?')"
               style="background:red;color:white;padding:5px 10px;text-decoration:none;">
               Delete
            </a>

        </td>

    </tr>
    @endforeach

</table>

@endsection