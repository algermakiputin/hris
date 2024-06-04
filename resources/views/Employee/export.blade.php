<link rel="stylesheet" type="text/css" href="{{ asset('download/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/chosen.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-loading.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">  

<div class="page-title">
	<div class="title_left">
    <h3>{{ ucfirst($profile->first_name) . ' ' . ucfirst($profile->last_name) }}</h3>
	</div> 
</div> 

<table class="table table-stripped">
    <tr>
        <th colspan="2"><i class="fa fa-pencil"></i> Personal Details</th>
    </tr>
    <tr>
        <td>Gender</td>
        <td>{{ $profile->gender == 1 ? 'Male' : 'Female'}}</td>
    </tr>
    <tr>
        <td>Birthday:</td>
        <td>{{ $profile->birthday }}</td>
    </tr>
    <tr>
        <td>Age:</td>
        <td>{{ $age }}</td>
    </tr>
    <tr>
        <td>Email:</td>
        <td>{{ $profile->email_address }}</td>
    </tr>
    <tr>
        <td>Mobile Number:</td>
        <td>{{ $profile->mobile }}</td>
    </tr>
    <tr>
        <td>Telephone:</td>
        <td>{{ $profile->telephone ? $profile->telephone : 'N/A' }}</td>
    </tr>
    <tr>
        <td>Marital Status:</td>
        <td>{{ ucfirst($profile->marital_status) }}</td>
    </tr>
    <tr>
        <td>Education Level:</td>
        <td>{{ $profile->education }}</td>
    </tr> 
    <tr>
        <td>Religious Affiliation:</td>
        <td>{{ $profile->religiousAffiliation }}</td>
    </tr>
    <tr>
        <td>Height:</td>
        <td>{{ $profile->height }}</td>
    </tr>
    <tr>
        <td>Weight:</td>
        <td>{{ $profile->weight }}</td>
    </tr>
    <tr>
        <td>Blood Type:</td>
        <td>{{ $profile->bloodType }}</td>
    </tr>
    <tr>
        <td>Tin:</td>
        <td>{{ $profile->tin }}</td>
    </tr>
    <tr>
        <td>SSS:</td>
        <td>{{ $profile->sss }}</td>
    </tr>
    <tr>
        <td>Philhealth:</td>
        <td>{{ $profile->philhealth }}</td>
    </tr>
    <tr>
        <td>Citizenship:</td>
        <td>{{ $profile->citizenship }}</td>
    </tr>
    <tr>
        <td>Unit:</td>
        <td>{{ $profile->unit }}</td>
    </tr>
</table>
<table class="table">
    <tr>
        <th colspan="2"><i class="fa fa-briefcase"></i> Employment Details</th>
    </tr>
    <tr>
        <td>Campus:</td>
        <td>{{ ucfirst($profile->campus_name) }}</td>
    </tr>
    <tr>
        <td>School/Office:</td>
        <td>{{ ucwords($profile->department_name) }}</td>
    </tr>
    <tr>
        <td>Designation:</td>
        <td>{{ ucfirst($profile->role_name) }}</td>
    </tr>
    <tr>
        <td>Employment Type:</td>
        <td>{{ $profile->employment_type === 1 ? "Full Time" : "Part Time" }}</td>
    </tr>
    <tr>
        <td>Tenure:</td>
        <td>{{ $profile->tenure }}</td>
    </tr>
    <tr>
        <td>Salary:</td>
        <td>{{ config('config.currency') . number_format((float)$profile->salary) }}</td>
    </tr>
    <tr>
        <td>Date Joining:</td>
        <td>{{ $profile->date_joining }}</td>
    </tr>
    <tr>
        <td>Employment Status:</td>
        <td>{{ $profile->employment_status }}</td>
    </tr>
    <tr>
        <td>Designation:</td>
        <td>{{ $profile->designation2 }}</td>
    </tr>
    <tr class="{{ $profile->designation2 !== 'Faculty' ? 'hide' : '' }}">
        <td>Academic Rank:</td>
        <td>{{ $profile->academic_rank }}</td>
    </tr>
    <tr class="{{ $profile->designation2 !== 'Employee' ? 'hide' : '' }}">
        <td>Administrative Rank:</td>
        <td>{{ $profile->administrative_rank }}</td>
    </tr>
    <tr>
        <td>Honorarium:</td>
        <td>{{ $profile->honorarium }}</td>
    </tr>
    <tr>
        <td>Honorarium Expiry:</td>
        <td>{{ $profile->honorarium_expiry }}</td>
    </tr>
</table>
<table class="table table-stripped table-hover" id="educational-background" width="100%">
    <thead>
        <th width="10%">Level</th>
        <th width="20%">School</th>
        <th width="20%">Degree</th>
        <th width="20%">Year Graduated</th>
        <th width="10%">Highes Grade/Level/Units Earned(if not graduated)</th>
        <th width="10%">Inclusive dates of attendance from - to</th>
        <th width="10%">Scholarship/Academic honors received</th> 
    </thead>
    <tbody>  
        <tr>
            <td>Elementary</td>
            <td>{{ isset($elementary->school) ? $elementary->school : '' }}</td>
            <td>{{ isset($elementary->degree) ? $elementary->degree : ''  }}</td>
            <td>{{ isset($elementary->year) ? $elementary->year : '' }}</td>
            <td>{{ isset($elementary->highestGrade) ? $elementary->highestGrade : '' }}</td>
            <td>{{ isset($elementary->inclusiveDates) ? $elementary->inclusiveDates : '' }}</td>
            <td>{{ isset($elementary->scholarship) ? $elementary->scholarship : '' }}</td>
        </tr>  
        <tr>
            <td>Secondary</td>
            <td>{{ isset($secondary->school) ? $secondary->school : '' }}</td>
            <td>{{ isset($secondary->degree) ? $secondary->degree : '' }}</td>
            <td>{{ isset($secondary->year) ? $secondary->year : '' }}</td>
            <td>{{ isset($secondary->highestGrade) ? $secondary->highestGrade : '' }}</td>
            <td>{{ isset($secondary->inclusiveDates) ? $secondary->inclusiveDates : '' }}</td>
            <td>{{ isset($secondary->scholarship) ? $secondary->scholarship : '' }}</td>
        </tr>
        <tr>
            <td>Vocational/Trade Course</td>
            <td>{{ isset($vocational->school) ? $vocational->school : '' }}</td>
            <td>{{ isset($vocational->degree) ? $vocational->degree : '' }}</td>
            <td>{{ isset($vocational->year) ? $vocational->year : '' }}></td>
            <td>{{ isset($vocational->highestGrade) ? $vocational->highestGrade : '' }}</td>
            <td>{{ isset($vocational->inclusiveDates) ? $vocational->inclusiveDates : '' }}</td>
            <td>{{ isset($vocational->scholarship) ? $vocational->scholarship : '' }}</td>
        </tr>
        <tr>
            <td>College</td>
            <td>{{ isset($college->school) ? $college->school : '' }}</td>
            <td>{{ isset($college->degree) ? $college->degree : '' }}</td>
            <td>{{ isset($college->year) ? $college->year : ''  }}</td>
            <td>{{ isset($college->highestGrade) ? $college->highestGrade : '' }}</td>
            <td>{{ isset($college->inclusiveDates) ? $college->inclusiveDates :'' }}</td>
            <td>{{ isset($college->scholarship) ? $college->scholarship : '' }}</td>
        </tr>
        <tr>
            <td>Graduate Studies</td>
            <td>{{ isset($graduate->school) ? $graduate->school : '' }}</td>
            <td>{{ isset($college->degree) ? $college->degree : '' }}</td>
            <td>{{ isset($college->year) ? $college->year : '' }}</td>
            <td>{{ isset($college->highestGrade) ? $college->highestGrade : '' }}</td>
            <td>{{ isset($college->inclusiveDates) ? $college->inclusiveDates : '' }}</td>
            <td>{{ isset($college->scholarship) ? $college->scholarship : '' }}</td>
        </tr>                  
    </tbody>
</table>
<div>
    <div class="card">
        <div class="card-header"><b>Involvement In Other Educational Or Professional Organization</b> </div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="involvement-list-table">
                <thead>
                    <th>Organization Name</th>
                    <th>Organization Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Position</th> 
                </thead>
                <tbody>
                @if($profile->involvement)
                    @foreach($profile->involvement as $involvement)
                    <tr>
                        <td>{{ isset($involvement->organization) ? $involvement->organization : '' }}</td>
                        <td>{{ isset($involvement->address) ? $involvement->address : '' }}</td>
                        <td>{{ isset($involvement->from) ? $involvement->from : '' }}</td>
                        <td>{{ isset($involvement->to) ? $involvement->to : '' }}</td>
                        <td>{{ isset($involvement->position) ? $involvement->position : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>  
<div>
    <div class="card">
        <div class="card-header"><b>Involvement In Other CIVIC (Non Government/People) Voluntary Organization</b></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="voluntary-list-table">
                <thead>
                    <th>Organization Name</th>
                    <th>Organization Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Position</th> 
                </thead>
                <tbody>
                @if($profile->voluntary)
                    @foreach($profile->voluntary as $voluntary)
                    <tr>
                        <td>{{ isset($voluntary->organization) ? $voluntary->organization : '' }}</td>
                        <td>{{ isset($voluntary->address) ? $voluntary->address : '' }}</td>
                        <td>{{ isset($voluntary->from) ? $voluntary->from : '' }}</td>
                        <td>{{ isset($voluntary->to) ? $voluntary->to : '' }}</td>
                        <td>{{ isset($voluntary->position) ? $voluntary->position : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div> 
<div class="card">
    <div class="card-header"><b>Work Experience</b></div>
    <div class="card-body">
        <table class="table table-stripped table-hover" id="work-list-table">
            <thead>
                <th>From</th>
                <th>To</th>
                <th>Position Title</th>
                <th>Company/Office</th>
                <th>Monthly Salary</th>
                <th>Status of Employment</th>
                <th>Length of Service</th>
            </thead>
            <tbody>
            @if($profile->work)
                @foreach($profile->work as $work)
                <tr>
                    <td>{{ $work->from }}</td>
                    <td>{{ $work->to }}</td>
                    <td>{{ $work->title }}</td>
                    <td>{{ $work->company }}</td>
                    <td>{{ $work->salary }}</td>
                    <td>{{ $work->employmentStatus }}</td>
                    <td>{{ $work->service }}</td> 
                </tr>
                @endforeach
            @else 
                <tr><td colspan="7">No data available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header"><b>Other Information</b></div>
    <div class="card-body">
        <form action="{{ url('employeeInfo/store') }}" method="POST" id="work-exp-form">
            @csrf
            @method('post')
            <input type="hidden" value="{{ $profile->id }}" name="id" />
            <table class="table">
                <tr>
                    <th>Special Skills/Hobbies</th>
                    <th>Non-Academic Distinction/Recognition/Awards</th>
                </tr>
                <tr>
                    <td>{{ $profile->hobbies }}</td>
                    <td>{{ $profile->awards }}</td>
                </tr>
            </table> 
        </form>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header"><b>Civil Service Eligiblity</b></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="civil-service-table">
                <thead>
                    <th>Career Service</th>
                    <th>Rating</th>
                    <th>Date of Examination</th>
                    <th>Place of Examination</th>
                    <th>Number</th>
                    <th>Date of Release</th> 
                </thead>
                <tbody>
                @if($profile->civil_service)
                    @foreach($profile->civil_service as $civilService)
                    <tr>
                        <td>{{ isset($civilService->careerService) ? $civilService->careerService : '' }}</td>
                        <td>{{ isset($civilService->rating) ? $civilService->rating : '' }}</td>
                        <td>{{ isset($civilService->date) ? $civilService->date :'' }}</td>
                        <td>{{ isset($civilService->place) ? $civilService->place : '' }}</td>
                        <td>{{ isset($civilService->numbe) ? $civilService->number : '' }}</td>
                        <td>{{ property_exists($civilService, 'releaseDate') ? $civilService->releaseDate : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<div>
    <div class="card">
        <div class="card-header"><b>Training Program</b> </div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="training-list-table">
                <thead>
                    <th>Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>No. of Hours</th>
                    <th>Conducted/Sponsored By</th> 
                </thead>
                <tbody>
                @if($profile->training)
                    @foreach($profile->training as $training)
                    <tr>
                        <td>{{ $training->trainingTitle }}</td>
                        <td>{{ $training->trainingFrom }}</td>
                        <td>{{ $training->trainingTo }}</td>
                        <td>{{ $training->trainingHours }}</td>
                        <td>{{ $training->trainingSponsor }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header"><b>Other Information</b></div>
        <div class="card-body">
            <form action="{{ url('employeeInfo/store') }}" method="POST">
                @csrf
                @method('post') 
                <table class="table">
                    <tr>
                        <th>Special Skills/Hobbies</th>
                        <th>Non-Academic Distinction/Recognition/Awards</th>
                    </tr>
                    <tr>
                        <td>{{ $profile->hobbies }}</td>
                        <td>{{ $profile->awards }}</td>
                    </tr>
                </table> 
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><b>Family Background</b></div>
    <div class="card-body">
        <legend>Spouse</legend>
        <table class="table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <td>{{ isset($profile->familyBackground->spouseFname) ? $profile->familyBackground->spouseFname : '' }}</td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td>{{ isset($profile->familyBackground->spouseLname) ? $profile->familyBackground->spouseLname : '' }}</td>
                </tr>
                <tr>
                    <th>Middle Name</th>
                    <td>{{ isset($profile->familyBackground->spouseMname) ? $profile->familyBackground->spouseMname : '' }}</td>
                </tr>
                <tr>
                    <th>Occupation Name</th>
                    <td>{{ isset($profile->familyBackground->spouseOccupation) ? $profile->familyBackground->spouseOccupation : '' }}</td>
                </tr>
                <tr>
                    <th>Employer</th>
                    <td>{{ isset($profile->familyBackground->spouseEmployer) ? $profile->familyBackground->spouseEmployer : '' }}</td>
                </tr>
                <tr>
                    <th>Employer/Bus Tel.No.</th>
                    <td>{{ isset($profile->familyBackground->spouseEmployerContact) ? $profile->familyBackground->spouseEmployerContact : '' }}</td>
                </tr>
                <tr>
                    <th>Contact No.</th>
                    <td>{{ isset($profile->familyBackground->spouseContact) ? $profile->familyBackground->spouseContact : '' }}</td>
                </tr>
            </thead>
        </table>
        <br />
        <legend>Child</legend>
        <table class="table" id="child-table">
        <thead>
            <tr>
                <th>Name of Child</th>
                <th>Date of Birth</th> 
            </tr>
        </thead>
        <tbody>
            <?php if(isset($profile->familyBackground->childNames)): ?>
                <?php foreach($profile->familyBackground->childNames as $key=>$child): ?>
                <tr>
                    <td><input type="text" value="{{ $child }}" class="form-control" name="child-name[]" /></td>
                    <td><input type="text" value="{{ $profile->familyBackground->childDob[$key] }}" class="form-control" name="child-dob[]" /></td> 
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <table class="table">
        <tr>
            <th>Father First Name</th>
            <td>{{ isset($profile->familyBackground->fatherFname) ? $profile->familyBackground->fatherFname : '' }}</td>
        </tr>
        <tr>
            <th>Father Last Name</th>
            <td>{{ isset($profile->familyBackground->fatherLname) ? $profile->familyBackground->fatherLname : '' }}</td>
        </tr>
        <tr>
            <th>Father Middle Name</th>
            <td>{{ isset($profile->familyBackground->fatherMname) ? $profile->familyBackground->fatherMname : '' }}</td>
        </tr>
        <tr>
            <th>Mother First Name</th>
            <td>{{ isset($profile->familyBackground->motherFname) ? $profile->familyBackground->motherFname : '' }}</td>
        </tr>
        <tr>
            <th>Mother Last Name</th>
            <td>{{ isset($profile->familyBackground->motherLname) ? $profile->familyBackground->motherLname : '' }}</td>
        </tr>
        <tr>
            <th>Mother Middle Name</th>
            <td>{{ isset($profile->familyBackground->motherMname) ? $profile->familyBackground->motherMname : '' }}</td>
        </tr>
    </table>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>