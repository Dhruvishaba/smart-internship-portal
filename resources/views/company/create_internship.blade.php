@extends('layouts.app')

@section('content')

<div style="max-width:800px;margin:auto;padding:30px;
            background:white;border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,0.1);">

    <h2>🎓 Post New Internship</h2>

    @php
        $today = date('Y-m-d');
    @endphp


    <!-- SUCCESS -->
    @if(session('success'))
        <div style="color:green;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif


    <!-- ERROR -->
    @if ($errors->any())
        <div style="color:red;margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('internships.store') }}">
        @csrf

        <!-- Title -->
        <div style="margin-top:15px;">
            <label>Internship Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title') }}"
                   class="form-control"
                   placeholder="e.g. Laravel Developer Intern"
                   required>
        </div>

        <!-- Description -->
        <div style="margin-top:15px;">
            <label>Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="4"
                      required>{{ old('description') }}</textarea>
        </div>

        <!-- Required Skills -->
        <div style="margin-top:15px;">
            <label>Required Skills (comma separated)</label>
            <input type="text"
                   name="required_skills"
                   value="{{ old('required_skills') }}"
                   class="form-control"
                   placeholder="laravel, php, mysql, javascript"
                   required>
<small style="color:gray;">
    Example: laravel, php, mysql  
    Enter skills separated by comma.
</small>

@if(session('error'))
    <div style="color:red;margin-top:5px;">
        {{ session('error') }}
    </div>
@endif
        </div>

        <!-- Duration -->
        <div style="margin-top:15px;">
            <label>Duration</label>
            <input type="text"
                   name="duration"
                   value="{{ old('duration') }}"
                   class="form-control"
                   placeholder="3 Months"
                   required>
        </div>

        <!-- Start Date -->
        <div style="margin-top:15px;">
            <label>Start Date</label>
            <input type="date"
                   name="start_date"
                   value="{{ old('start_date') }}"
                   class="form-control"
                   min="{{ $today }}"
                   required>
        </div>

        <!-- End Date -->
        <div style="margin-top:15px;">
            <label>End Date</label>
            <input type="date"
                   name="end_date"
                   value="{{ old('end_date') }}"
                   class="form-control"
                   min="{{ $today }}"
                   required>
        </div>

        <!-- Stipend -->
        <div style="margin-top:15px;">
            <label>Stipend (₹)</label>
            <input type="number"
                   name="stipend"
                   value="{{ old('stipend') }}"
                   class="form-control"
                   placeholder="5000"
                   required>
        </div>

        <!-- Address -->
        <div style="margin-top:15px;">
            <label>Internship Location</label>
            <textarea name="address"
                      class="form-control"
                      rows="3"
                      required>{{ old('address') }}</textarea>
        </div>

        <!-- Eligibility -->
        <div style="margin-top:15px;">
            <label>Eligibility</label>
            <textarea name="eligibility"
                      class="form-control"
                      rows="3"
                      required>{{ old('eligibility') }}</textarea>
        </div>

        <!-- Deadline -->
        <div style="margin-top:15px;">
            <label>Application Deadline</label>
            <input type="date"
                   name="application_deadline"
                   value="{{ old('application_deadline') }}"
                   class="form-control"
                   min="{{ $today }}"
                   required>
        </div>

        <!-- Spots -->
        <div style="margin-top:15px;">
            <label>Available Spots</label>
            <input type="number"
                   name="spots_available"
                   value="{{ old('spots_available') }}"
                   class="form-control"
                   min="1"
                   required>
        </div>

        <button type="submit"
            style="margin-top:25px;background:#28a745;color:white;
                   padding:10px 25px;border:none;border-radius:5px;">
            🚀 Post Internship
        </button>

    </form>

</div>

@endsection