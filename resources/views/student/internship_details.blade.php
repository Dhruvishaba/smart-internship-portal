@extends('layouts.app')

@section('content')

<div style="max-width:900px;margin:auto;background:white;padding:30px;border-radius:10px">

    <h2>{{ $internship->title }}</h2>

    <hr>

    <p><b>Company:</b> {{ $internship->company_name }}</p>

    <p><b>Description:</b> {{ $internship->description }}</p>

    <p><b>Duration:</b> {{ $internship->duration }}</p>

    <p><b>Stipend:</b> ₹{{ $internship->stipend }}</p>

    <p><b>Location:</b> {{ $internship->address }}</p>

    <p><b>Eligibility:</b> {{ $internship->eligibility }}</p>

    <p><b>Deadline:</b> {{ $internship->application_deadline }}</p>

    <p><b>Available Spots:</b> {{ $internship->spots_available }}</p>

    <hr>

    <!-- Required Skills -->
    <h4>Required Skills</h4>

    @if(!empty($requiredSkills) && count($requiredSkills) > 0)

        <ul>
            @foreach($requiredSkills as $skill)
                <li>{{ $skill }}</li>
            @endforeach
        </ul>

    @else
        <p>No skills required</p>
    @endif


    <!-- Internship Closed -->
    @if($isClosed)

        <div style="background:#eee;padding:10px;margin-top:20px;border-radius:5px;">
            Internship Closed
        </div>

    @endif


    <!-- Apply Button -->
    <div style="margin-top:25px">

        @if(!$isClosed)

            <button onclick="checkSkill('{{ $internship->id }}')"
                style="background:green;color:white;padding:10px 20px;border:none;border-radius:5px;">
                Apply Internship
            </button>

        @else

            <button disabled
                style="background:gray;color:white;padding:10px 20px;border:none;border-radius:5px;">
                Cannot Apply
            </button>

        @endif

    </div>

</div>


<!-- Skill Popup -->

<div id="skillPopup" style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;
">

    <div style="
    background:white;
    padding:25px;
    border-radius:10px;
    width:350px;
    text-align:center;
    ">

        <h3 style="color:red;">Skill Not Matched</h3>

        <p id="popupMessage"></p>

        <button onclick="closePopup()"
            style="background:#dc3545;color:white;padding:8px 20px;border:none;border-radius:5px;">
            Close
        </button>

    </div>

</div>


<script>

function checkSkill(id){

    fetch('/student/check-skill/' + id)
    .then(response => response.json())
    .then(data => {

        if(data.status == 'allowed'){

            window.location.href = '/student/apply/' + id;

        }else{

            document.getElementById('popupMessage').innerHTML =
            "Matched Skills: " + data.match + "% <br><br>" +
            "Missing Skills:<br>" + data.missing;

            document.getElementById('skillPopup').style.display = 'flex';
        }

    });
}

function closePopup(){
    document.getElementById('skillPopup').style.display = 'none';
}

</script>

@endsection