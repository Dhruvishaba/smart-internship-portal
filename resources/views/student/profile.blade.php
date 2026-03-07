use Illuminate\Support\Facades\Auth;
@extends('layouts.app')

@section('content')
<div style="max-width:1000px;margin:auto;background:white;padding:35px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.08);">

<h2 style="margin-bottom:30px;font-weight:600;">Student Profile</h2>

@if(session('success'))
<div style="background:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
@csrf

<h4 style="margin-bottom:20px;">Profile Photo</h4>

<div style="text-align:center;margin-bottom:30px;">

@if($profile && $profile->photo)
<img id="photoPreview"
src="{{ asset('storage/'.$profile->photo) }}"
style="width:150px;height:150px;border-radius:50%;object-fit:cover;border:3px solid #007bff;margin-bottom:15px;">
@else
<img id="photoPreview"
src="https://via.placeholder.com/150"
style="width:150px;height:150px;border-radius:50%;object-fit:cover;border:3px solid #007bff;margin-bottom:15px;">
@endif

<br>

<input type="file"
name="photo"
accept="image/*"
class="form-control"
style="width:250px;margin:auto;"
onchange="previewPhoto(event)">

</div>

<h4 style="margin-bottom:20px;">Personal Details</h4>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

<div>
<label>Name</label>
<input type="text" name="name" value="{{ $user->name }}" class="form-control">
</div>

<div>
<label>Gender</label>
<select name="gender" class="form-control">
<option value="Male" {{ ($profile->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
<option value="Female" {{ ($profile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
</select>
</div>

<div>
<label>Mobile</label>
<input type="text" name="mobile" value="{{ $profile->mobile ?? '' }}" class="form-control">
</div>

<div>
<label>Email</label>
<input type="email" name="email" value="{{ $user->email }}" class="form-control">
</div>

<div>
<label>DOB</label>
<input type="date" name="dob" value="{{ $profile->dob ?? '' }}" class="form-control">
</div>

<div>
<label>Address</label>
<input type="text" name="address" value="{{ $profile->address ?? '' }}" class="form-control">
</div>

</div>

<hr style="margin:35px 0;">

<!-- ⭐ NEW SKILLS SECTION -->

<h4 style="margin-bottom:20px;">Skills</h4>

<div style="margin-bottom:30px;">

<label>Add Your Skills (Example: Laravel, PHP, MySQL, JavaScript)</label>

<textarea name="skills"
class="form-control"
rows="4"
placeholder="Enter your technical skills separated by commas">{{ $profile->skills ?? '' }}</textarea>

</div>

<hr style="margin:35px 0;">

<h4 style="margin-bottom:25px;">Educational Details</h4>

<h5 style="margin-bottom:15px;">SSC</h5>

<div style="display:grid;grid-template-columns:1fr 2fr 1fr 1fr;gap:20px;margin-bottom:25px;">
<input type="text" name="ssc_medium" value="{{ $profile->ssc_medium ?? '' }}" class="form-control" placeholder="Medium">
<input type="text" name="ssc_school" value="{{ $profile->ssc_school ?? '' }}" class="form-control" placeholder="School Name">
<input type="text" name="ssc_board" value="{{ $profile->ssc_board ?? '' }}" class="form-control" placeholder="Board">
<input type="text" name="ssc_percentage" value="{{ $profile->ssc_percentage ?? '' }}" class="form-control" placeholder="Percentage / CGPA">
</div>

<h5 style="margin-bottom:15px;">HSC</h5>

<div style="display:grid;grid-template-columns:1fr 2fr 1fr 1fr;gap:20px;margin-bottom:30px;">
<input type="text" name="hsc_medium" value="{{ $profile->hsc_medium ?? '' }}" class="form-control" placeholder="Medium">
<input type="text" name="hsc_school" value="{{ $profile->hsc_school ?? '' }}" class="form-control" placeholder="School Name">
<input type="text" name="hsc_board" value="{{ $profile->hsc_board ?? '' }}" class="form-control" placeholder="Board">
<input type="text" name="hsc_percentage" value="{{ $profile->hsc_percentage ?? '' }}" class="form-control" placeholder="Percentage / CGPA">
</div>

<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:30px;">
<label>Current Program</label>
<input type="text" name="current_program" value="{{ $profile->current_program ?? '' }}" class="form-control" placeholder="Current Program">
<br>
<label>Current Semester</label>
<input type="text" name="current_semester" value="{{ $profile->current_semester ?? '' }}" class="form-control" placeholder="Current Semester">
<br>
<label>Current Semester</label>
<input type="text" name="current_cgpa" value="{{ $profile->current_cgpa ?? '' }}" class="form-control" placeholder="Current CGPA">

</div>
<!-- ================= CERTIFICATIONS ================= --> 
 <h4 style="margin-bottom:20px;">Certifications</h4>
  <div id="certificationContainer"> 
    @php 
    $certifications = isset($profile->certifications)
     ? explode(',', $profile->certifications) 
     : [''];
      @endphp
       @foreach($certifications as $index => $cert)
        <div class="cert-item" style="display:flex;gap:10px;margin-bottom:12px;">
             <span class="cert-number" style="font-weight:600;width:25px;"> {{ $index + 1 }}. </span> 
             <input type="text" name="certifications[]" value="{{ trim($cert) }}" class="form-control" placeholder="Certificate Name">
              <button type="button" onclick="removeCertification(this)" style="background:#dc3545;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;"> Remove </button>
             </div>
              @endforeach 
            </div>
               <button type="button" onclick="addCertification()" style="background:#007bff;color:white;border:none;padding:8px 18px;border-radius:6px;cursor:pointer;margin-bottom:30px;"> + Add Certification </button> 
               <!-- ================= OTHER DETAILS ================= -->
                 <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                     <div> 
                        <label>Seminars</label> 
                        <textarea name="seminars" class="form-control" rows="4">{{ $profile->seminars ?? '' }}</textarea> 
                    </div> 
                    <div>
                         <label>Competition Participation</label>
                          <textarea name="competitions" class="form-control" rows="4">{{ $profile->competitions ?? '' }}</textarea> 
                        </div>
                     </div> 
                     <div style="margin-top:20px;"> 
                        <label>Achievements</label>
                         <textarea name="achievements" class="form-control" rows="4">{{ $profile->achievements ?? '' }}</textarea> 
                        </div>
<hr style="margin:35px 0;">

<h4 style="margin-bottom:15px;">Internship</h4>

<div style="margin-bottom:15px;">
<label style="font-weight:500;">Currently Doing Internship?</label><br>

<label style="margin-right:20px;">
<input type="radio" name="is_interning" value="1"
{{ ($profile->is_interning ?? 0) == 1 ? 'checked' : '' }}> Yes
</label>

<label>
<input type="radio" name="is_interning" value="0"
{{ ($profile->is_interning ?? 0) == 0 ? 'checked' : '' }}> No
</label>
</div>

<div id="positionField" style="display:none;margin-bottom:20px;">
<input type="text"
name="intern_position"
value="{{ $profile->intern_position ?? '' }}"
class="form-control"
placeholder="Your Current Internship Position">
</div>

<button type="submit"
style="background:#007bff;color:white;border:none;padding:12px 35px;border-radius:8px;font-size:16px;cursor:pointer;">
Update Profile
</button>

</form>
</div>

<script>
    function previewPhoto(event)
{
    const reader = new FileReader();

    reader.onload = function(){
        const output = document.getElementById('photoPreview');
        output.src = reader.result;
    }

    reader.readAsDataURL(event.target.files[0]);
}
document.addEventListener('DOMContentLoaded', function () {

const yesRadio = document.querySelector('input[name="is_interning"][value="1"]');
const positionField = document.getElementById('positionField');

function togglePosition() {
positionField.style.display = yesRadio.checked ? 'block' : 'none';
}

yesRadio.addEventListener('change', togglePosition);
document.querySelector('input[name="is_interning"][value="0"]').addEventListener('change', togglePosition);
togglePosition();

});
function updateNumbers()
 {
     document.querySelectorAll('.cert-item').forEach((item, index) =>
      { item.querySelector('.cert-number').innerText = (index + 1) + '.'; });
     } 
    function addCertification()
{
    const container = document.getElementById('certificationContainer');

    const div = document.createElement('div');
    div.classList.add('cert-item');
    div.style.display = 'flex';
    div.style.gap = '10px';
    div.style.marginBottom = '12px';

    div.innerHTML = `
        <span class="cert-number" style="font-weight:600;width:25px;"></span>
        <input type="text" name="certifications[]" class="form-control" placeholder="Certificate Name">
        <button type="button" onclick="removeCertification(this)"
        style="background:#dc3545;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;">
        Remove
        </button>
    `;

    container.appendChild(div);
    updateNumbers();
}
        function removeCertification(button) 
        {
             button.parentElement.remove(); updateNumbers(); 
            } 
            document.addEventListener('DOMContentLoaded', updateNumbers);
</script>

@endsection