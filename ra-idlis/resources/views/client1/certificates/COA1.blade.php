@extends('main')
@section('content')
@include('client1.cmp.__issuance')
<body>
	<div class="container mt-5">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-3 hide-div">
						<img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: right; max-height: 118px; padding-left: 20px;">
					</div>
					<div class="col-md-6">
						<span class="card-title text-center font-weight-bold" style="font-family: Arial;font-size: 12pt"><center><strong>Republic of the Philippines</strong></center></span>
						<span class="card-title text-center font-weight-bold" style="font-family: Arial;font-size: 13pt"><center><strong>DEPARTMENT OF HEALTH</strong></center></span>
						<span class="card-title text-center font-weight-bold" style="font-family: Arial;font-size: 14pt"><center><strong>{{((isset($director->certificateName)) ? $director->certificateName : 'REGION')}}</strong></center></span>
						{{-- <h5 class="card-title text-center">((isset($subUserTbl)) ? $subUserTbl[0]->rgn_desc : 'REGION')</h5> --}}
						{{-- <h6 class="card-subtitle mb-2 text-center text-muted text-small">doholrs@gmail.com</h6> --}}
					</div>
					<div class="col-md-3 hide-div">
						&nbsp;
						{{-- <img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: left; max-height: 118px; padding-left: 20px;"> --}}
					</div>
				</div>
			</div>
			<div class="card-body">
				<br>
				<span class="card-title text-center" style="font-family: Cambria;font-size: 33pt"><center><strong>CERTIFICATE OF ACCREDITATION</strong></center></span><br>
				<br>
				<br>
				<div class="row">	
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Owner
					</div>
					<div class="col-md-6" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
						:&nbsp;&nbsp;&nbsp;{{((isset($retTable[0]->owner)) ? $retTable[0]->owner : "CURRENT_OWNER")}}
					</div>	
				</div>
				<!-- <div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Operated/Managed <br>
						   by (if applicable)
					</div>
					<div class="col-md-6" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
						<br>:&nbsp;
					</div>
				</div> -->
				<div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Name of Facility 
					</div>
					<div class="col-md-5" style="float:left;display: inline;font-family:  Arial; font-size: 13pt">
						:&nbsp;&nbsp;&nbsp;<strong><strong>{{((isset($retTable[0]->facilityname)) ? $retTable[0]->facilityname : "CURRENT_FACILITY")}}</strong></strong>
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Type of Facility
					</div>
					<div class="col-md-5" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
						:&nbsp;&nbsp;&nbsp;{{((isset($facilityTypeId)) ? $facilityTypeId : "No Health Service")}}
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family:Arial; font-size: 12pt">
						Location
					</div>
					<div class="col-md-5" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
						 :&nbsp;&nbsp;&nbsp;{{((isset($retTable[0])) ? ($retTable[0]->rgn_desc.', '.$retTable[0]->provname.', '.$retTable[0]->cmname.', '.$retTable[0]->brgyname.', '.$retTable[0]->street_name.' '.$retTable[0]->street_number) : "CURRENT_LOCATION")}}
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Accreditation Number
					</div>
					<div class="col-md-5" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
						:&nbsp;&nbsp;&nbsp;4A-290-1719-LW-1
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>	
				<div class="row">
					<div class="col-md-2" style="">&nbsp;</div>
					<div class="col-md-3" style="font-family: Arial; font-size: 12pt">
						Validity of Accreditation 
					</div>
					<div class="col-md-5" style="float:left;display: inline;font-family: Arial; font-size: 13pt">
					:&nbsp;&nbsp;&nbsp;{{date('F j, Y', strtotime($retTable[0]->approvedDate))}} – {{'December 31, '. date('Y', strtotime('+1 years' ,  strtotime($retTable[0]->approvedDate)))}}
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>	
				<br><br><br>
				<div class="row">
					<div class="col-md-6"></div>
					<div class="col-md-6">
						<p class="text-uppercase " style="font-family: Cambria;font-size: 12pt;"><strong>By Authority of the Secretary of Health:</strong></p>
						<br><br><br><br>
						 <p class="text-uppercase"  style="font-family: Cambria;font-size: 16pt;"><strong>{{$director->directorInRegion}}{{-- ATTY. NICOLAS B. LUTERO III, CESO III --}} </strong></p>
						<p class="text-small" style="font-family: Cambria;font-size: 14pt;">
							<strong style="margin-left: 7em;">{{$director->pos}}</strong></p>
					</div>
				</div>
				<br><br><br><br><br><br><br><br>
			</div>
			<div class="card-footer">
				<p class="text-muted text-small" style="float: left; padding: 0; margin: 0;">
					{{-- <iframe src="{{asset('ra-idlis/resources/views/client1/qrcode/index.php')}}?data={{asset('client1/certificates/view/external/')}}/{{$retTable[0]->appid}}" style="border: none !important; height: 150px; width: 150px;"></iframe> --}}
					<iframe src="{!!url('qrcode/'.$retTable[0]->appid )!!}" style="border: none !important; height: 230px; width: 260px;"></iframe>
				</p>
				<p class="text-muted text-small" style="float: right; padding: 0; margin: 0;">© All Rights Reserved {{date('Y')}}</p>
			</div>
		</div><br>
	</div>
</body>
@endsection