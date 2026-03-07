@extends('layouts.app')

@section('content')

<div style="max-width:800px;margin:auto;padding:30px;
            background:white;border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,0.1);">

    <h2>🎓 Post New Internship</h2>

    @php
        $company = auth()->user()->company;
    @endphp

    <form method="POST" action="{{ route('internships.store') }}">
        @csrf

        <!-- Title -->
        <div style="margin-top:15px;">
            <label>Internship Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <!-- Description -->
        <div style="margin-top:15px;">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <!-- Required Skills -->
        <div style="margin-top:15px;">
            <label>Required Skills</label>
            <input type="text" name="required_skills" class="form-control" required>
        </div>

        <!-- Duration -->
        <div style="margin-top:15px;">
            <label>Duration (e.g. 3 Months)</label>
            <input type="text" name="duration" class="form-control" required>
        </div>

        <!-- Start Date -->
        <div style="margin-top:15px;">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <!-- End Date -->
        <div style="margin-top:15px;">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <!-- Stipend -->
        <div style="margin-top:15px;">
            <label>Stipend</label>
            <input type="text" name="stipend" class="form-control" placeholder="e.g. ₹5000/month or Unpaid" required>
        </div>

        <!-- Address -->
        <div style="margin-top:15px;">
            <label>Internship Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <!-- Eligibility -->
        <div style="margin-top:15px;">
            <label>Eligibility</label>
            <textarea name="eligibility" class="form-control" required></textarea>
        </div>

        <!-- Application Deadline -->
        <div style="margin-top:15px;">
            <label>Application Deadline</label>
            <input type="date" name="application_deadline" class="form-control" required>
        </div>

        <!-- Spots Available -->
        <div style="margin-top:15px;">
            <label>Spots Available</label>
            <input type="number" name="spots_available" class="form-control" required>
        </div>

        <hr style="margin:30px 0;">

        <h4>🏢 Company Details</h4>

        <!-- Company Name -->
        <div style="margin-top:15px;">
            <label>Company Name</label>
            <input type="text" name="company_name"
                   value="{{ $company->company_name ?? auth()->user()->name }}"
                   class="form-control">
        </div>

        <!-- Company Technology -->
        <div style="margin-top:15px;">
            <label>Company Technology</label>
            <input type="text" name="company_technology"
                   value="{{ $company->technology ?? '' }}"
                   class="form-control">
        </div>

        <!-- Company Contact -->
        <div style="margin-top:15px;">
            <label>Company Contact</label>
            <input type="text" name="company_contact"
                   value="{{ $company->contact_number ?? '' }}"
                   class="form-control">
        </div>

        <button type="submit"
            style="margin-top:25px;background:#28a745;color:white;
                   padding:10px 25px;border:none;border-radius:5px;">
            Post Internship
        </button>

    </form>

</div>

@endsection