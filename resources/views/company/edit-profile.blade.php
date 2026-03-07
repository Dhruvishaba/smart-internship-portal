@extends('layouts.app')

@section('content')

<div style="max-width:700px;margin:auto;background:white;padding:30px;border-radius:12px;box-shadow:0 0 15px rgba(0,0,0,0.1);">

    <h2 style="margin-bottom:20px;">✏ Edit Company Profile</h2>

    <form method="POST" action="{{ route('company.profile.update') }}">
        @csrf

        @php
            $company = auth()->user()->company;
        @endphp

        <label>Company Name</label>
        <input type="text" name="company_name"
               value="{{ $company->company_name ?? auth()->user()->name }}"
               style="width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:6px;">

        <label>Address</label>
        <textarea name="address"
                  style="width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:6px;">{{ $company->address ?? '' }}</textarea>

        <label>Contact Number</label>
        <input type="text" name="contact_number"
               value="{{ $company->contact_number ?? '' }}"
               style="width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:6px;">

        <label>Technology</label>
        <input type="text" name="technology"
               value="{{ $company->technology ?? '' }}"
               style="width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:6px;">

        <label>Internship Type</label>
        <select name="internship_type"
                style="width:100%;padding:10px;margin-bottom:20px;border:1px solid #ccc;border-radius:6px;">
            <option value="Paid" {{ ($company->internship_type ?? '') == 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="Free" {{ ($company->internship_type ?? '') == 'Free' ? 'selected' : '' }}>Free</option>
        </select>

        <button type="submit"
                style="background:#28a745;color:white;padding:10px 20px;border:none;border-radius:6px;">
            Update Profile
        </button>

    </form>

</div>

@endsection