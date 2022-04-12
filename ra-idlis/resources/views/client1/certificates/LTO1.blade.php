@extends('main')
@section('content')
@include('client1.cmp.__issuance')
<body>
	<style>
		@font-face {
			font-family: NewGothicCenturySchoolBook;
			src: url({{ asset('ra-idlis/public/fonts/NewCenturySchoolbook.ttf') }});
		}
		@font-face {
			font-family: ArialUnicodeMs;
			src: url({{ asset('ra-idlis/public/fonts/ARIALUNI.TTF') }});
		}
		.watermarked {
			position: relative;
		}
		.watermarked:after {
			content: "";
			display: block;
			width: 90%;
			height: 100%;
			position: absolute;
			top: 0px;
			left: 0px;
			background-image: url("{{asset('ra-idlis/public/img/watermark/hfsrb.png')}}");
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			opacity: 0.25;
			z-index: 0;
			-webkit-print-color-adjust: exact;
		}
		.heading { font-family: "Arial Unicode MS", "Lucida Sans Unicode", "DejaVu Sans", "Quivira", "Symbola", "Code2000", ;
			 font-size: 60px;}
		.auth { font-family: "Arial Unicode MS", "Lucida Sans Unicode", "DejaVu Sans", "Quivira", "Symbola", "Code2000", ;
			 font-size: 18px;}
	    .director { font-family: "Arial Unicode MS", "Lucida Sans Unicode", "DejaVu Sans", "Quivira", "Symbola", "Code2000", ;
			 font-size: 21px;}
		.pos { font-family: "Arial Unicode MS", "Lucida Sans Unicode", "DejaVu Sans", "Quivira", "Symbola", "Code2000", ;
			 font-size: 20px;}
		.contl {font-family: Century Gothic; font-size: 18px}
		.contr {font-family: Century Gothic; font-size: 20px}
	</style>
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
						<span class="card-title text-center font-weight-bold" style="font-family: Arial;font-size: 14pt"><center><strong>{{((isset($director->certificateName)) ? $director->certificateName : "CURRENT_OWNER")}}</strong></center></span>
						{{-- <h5 class="card-title text-center">((isset($subUserTbl)) ? $subUserTbl[0]->rgn_desc : 'REGION')</h5> --}}
						{{-- <h6 class="card-subtitle mb-2 text-center text-muted text-small">doholrs@gmail.com</h6> --}}
					</div>
					<div class="col-md-3 hide-div">
						&nbsp;
						{{-- <img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: left; max-height: 118px; padding-left: 20px;"> --}}
					</div>
				</div>
			</div>
			<div class="card-body " style="width: 100%;">
			<div class="{{$retTable[0]->assignedRgn == 'hfsrb'? 'watermarked': ''}}">
				<br>
				<span class="  heading" ><center><strong>LICENSE TO OPERATE</strong></center></span><br>
				<!-- <span class="card-title text-center" style="font-family: ArialUnicodeMs;font-size: 42pt"><center><strong>LICENSE TO OPERATE</strong></center></span><br> -->
				
				<div class="row">	
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Owner
					</div>
					<div class="col-md-1" style="display: inline">
						:
					</div>
					<div class="col-md-6 contr" style="float:left;display: inline;">
						{{((isset($retTable[0]->owner)) ? $retTable[0]->owner : "CURRENT_OWNER")}}
					</div>	
				</div>
				{{-- <div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Operated/Managed <br>
						   by (if applicable)
					</div>
					<div class="col-md-1" style="display: inline">
						<br><center>:</center></div>
					<div class="col-md-6 contr" style="float:left;display: inline;">
						&nbsp;
					</div>
				</div> --}}
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Name of Facility
					</div>
					<div class="col-md-1" style="display: inline">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						<strong>{{((isset($retTable[0]->facilityname)) ? $retTable[0]->facilityname : "CURRENT_FACILITY")}}</strong>
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl">
						Type of Health Facility
					</div>
					<div class="col-md-1" style="display: inline">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						{{((isset($facname)) ? strtoupper($facname)  : "No Health Service")}}
						<!-- {{((isset($facilityTypeId)) ? $facilityTypeId : "No Health Service")}} -->
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl">
						Service Capability
					</div>
					<div class="col-md-1" style="display: inline">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
					<script>
						
						</script>
						{{--((isset($services->facname)) ? $services->facname : "No Health Service")--}}

						@php
						$str = $newservices;
						$pattern = '/hospital/i';


						$sc = preg_replace($pattern, ' ', $str);
						
						@endphp
						{{ $sc  }}
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Classification
					</div>
					<div class="col-md-1" style="display: inline">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						@if(isset($retTable[0]->funcid))
							{{$retTable[0]->funcid == 1 ? 'General': 'Special'}}
						@else
						"NOT DEFINED"
						@endif


						<!-- {{((isset($retTable[0]->funcid)) ? $retTable[0]->funcid : "NOT DEFINED")}} -->
						<!-- {{((isset($retTable[0]->classname)) ? $retTable[0]->classname : "NOT DEFINED")}} -->
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Location
					</div>
					<div class="col-md-1" style="display: inline">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">

				{{--	{{((isset($retTable[0])) ?
						 (
							 ($retTable[0]->street_name ? ucwords(strtolower($retTable[0]->street_name)).', ' : ' ')
						 
						 .
						($retTable[0]->street_number ?  ucwords(strtolower($retTable[0]->street_number)).', ' : '' ).ucwords(strtolower($retTable[0]->brgyname)).', '.ucwords(strtolower($retTable[0]->cmname)).', '.ucwords(strtolower($retTable[0]->provname)).' '.$retTable[0]->rgn_desc) : 'No Location.')}}
					
						--}}

						@php
$loc =
(
							 ($retTable[0]->street_name ? ucwords(strtolower($retTable[0]->street_name)).', ' : ' ')
						 
						 .
						($retTable[0]->street_number ?  ucwords(strtolower($retTable[0]->street_number)).', ' : '' ).ucwords(strtolower($retTable[0]->brgyname)).', '.ucwords(strtolower($retTable[0]->cmname)).', '.ucwords(strtolower($retTable[0]->provname)).' '.strtoupper($retTable[0]->rgn_desc));

$stringloc = preg_replace_callback('/\b(?=[LXIVCDM]+\b)([a-z]+)\b/i', 
function($matches) {
    return strtoupper($matches[0]);
}, $loc);	

@endphp




					{{((isset($retTable[0])) ?
						$stringloc
						
						: 'No Location.')}}
					<!-- {{((isset($retTable[0])) ? (ucfirst(strtolower($retTable[0]->street_name)).', '.ucfirst(strtolower($retTable[0]->street_number)).', '.ucfirst(strtolower($retTable[0]->brgyname)).', '.ucfirst(strtolower($retTable[0]->cmname)).', '.ucfirst(strtolower($retTable[0]->provname)).' '.ucfirst(strtolower($retTable[0]->rgn_desc))) : 'No Location.')}} -->
						<!-- {{ucwords(((isset($retTable[0])) ? ($retTable[0]->rgn_desc.', '.$retTable[0]->provname.', '.$retTable[0]->cmname.', '.$retTable[0]->brgyname.', '. $retTable[0]->street_number. $retTable[0]->street_name.' '.$retTable[0]->street_number) : "CURRENT_LOCATION"))}} -->
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				@php
						$pad_length = 4;
						$pad_char = 0;
						$str_type = 'd';

						$format = "%{$pad_char}{$pad_length}{$str_type}";
						$formatted_str = sprintf($format, $retTable[0]->appid);


						$sercap = preg_replace('/\s*/', '', $sc);
         			    $sercap = strtolower($sercap);

						 $disercap = $sercap == 'level1' ? 'H1' :  ($sercap == 'level2' ? 'H2' :  ($sercap == 'level3' ? 'H3' : ' '));

						@endphp
						
				@isset($retTable[0]->facmdesc)
				{{-- <div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Institutional Character
					</div>
					<div class="col-md-1" style="display: inline;float: left">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						<strong>{{((isset($retTable[0]->facmdesc)) ? $retTable[0]->facmdesc : "CURRENT_FACILITY")}}</strong>
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>	 --}}
				{{-- last update: 11/20/2019 by atty. Flores --}}
				@endisset
				
				@if(isset($otherDetails[1]) && $otherDetails[1])
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Authorized Bed Capacity
					</div>
					<div class="col-md-1" style="display: inline;float: left">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
			
						<strong>{{((isset($retTable[0]->noofbed)) ? $retTable[0]->noofbed : "NA")}}</strong>
						<!-- <strong>{{((isset($otherDetails[0]->noofbed)) ? $otherDetails[0]->noofbed : "NA")}}</strong> -->
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
					@if($disercap == 'level3' && isset($retTable[0]->noofdialysis) && $retTable[0]->noofdialysis > 0)
						<div class="row">
								<div class="col-md-1"  >&nbsp;</div>
							<div class="col-md-4 contl" >
								Authorized Dialysis Station
							</div>
							<div class="col-md-1" style="display: inline;float: left">
								:</div>
							<div class="col-md-5 contr" style="float:left;display: inline;">
							
								<strong>{{((isset($retTable[0]->noofdialysis)) ? $retTable[0]->noofdialysis : "NA")}}</strong>
								<!-- <strong>{{((isset($retTable[0]->noofstation)) ? $retTable[0]->noofstation : "NA")}}</strong> -->
							</div>
							<div class="col-md-1" style="display: inline">
								&nbsp;</div>
						</div>
					@endif
				@endif

				 <div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Authorized Ambulance Unit
					</div>
					<div class="col-md-1" style="display: inline;float: left">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
					{{--foreach($amb as $ambServ => $val){
									if($ambServ == 1){
										echo '1, '.$val . ' ' . $ambServ;
									}
								}--}}
								
						@php
							//	if($ambType1[$i] == '2'){
								//	echo ((int)$i + 1).', Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i];
							//		echo ((int)$i + 1).', Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i];
							//		echo "<br>";
									
							//	}
							@endphp

					@if(isset($retTable[0]->plate_number) && isset($retTable[0]->ambtyp))
						@php
							$type = json_decode($retTable[0]->typeamb);
							$ambType = json_decode($retTable[0]->ambtyp);
							$ambType1 = json_decode($retTable[0]->ambtyp);
							$plateNum = json_decode($retTable[0]->plate_number);
							$owner = json_decode($retTable[0]->ambOwner);

						
							
							

							$i=0;
							foreach($ambType1 as $atval){
								
						
								if($i != 0){
									if($ambType1[$i] == '2'){
										echo ' Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i];
									//	echo ((int)$i).', Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i];
										
									}else{
										echo ' Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i].' ,Owner: '.$owner[$i];
									//	echo ((int)$i).', Type '. $type[$i].' ,Plate No. ' .  $plateNum[$i].' ,Owner: '.$owner[$i];
									}
									echo "<br>";
							}

								$i++;
							}

							
						@endphp

					
						@endif

						
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>	
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						License Number
					</div>
					<div class="col-md-1" style="display: inline;float: left">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						<!-- {{$retTable[0]->licenseNo}} -->
						
						{{$retTable[0]->rgnid.'-'.$formatted_str.'-'.date('y', strtotime(str_replace('-','/', $retTable[0]->t_date))).'-'. $disercap.'-'.($retTable[0]->ocid == 'G'? '1':'2') }}
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>
				<div class="row">
						<div class="col-md-1"  >&nbsp;</div>
					<div class="col-md-4 contl" >
						Validity of License
					</div>
					<div class="col-md-1" style="display: inline;float: left">
						:</div>
					<div class="col-md-5 contr" style="float:left;display: inline;">
						<!-- @if(isset($otherDetails[0]) && isset($otherDetails[0]->valto))
						{{Date('F j, Y',strtotime($otherDetails[0]->valfrom))}} - {{Date('F j, Y',strtotime($otherDetails[0]->valto))}}
						@endif -->
						
						{{date('F j, Y', strtotime($retTable[0]->approvedDate))}} – {{date('F j, Y',  strtotime($otherDetails[0]->valto))}}
						<!-- {{Date('F j, Y',strtotime($retTable[0]->approvedDate))}} - {{date('F j, Y', strtotime("Last day of December", strtotime($retTable[0]->approvedDate)))}} -->
					
					</div>
					<div class="col-md-1" style="display: inline">
						&nbsp;</div>
				</div>

				{{-- @if($retTable[0]->noofsatellite > 0)
					<div class="row">
							<div class="col-md-1"  >&nbsp;</div>
						<div class="col-md-3" style="font-family: Century Gothic; font-size: 11pt">
							FDA Status
						</div>
						<div class="col-md-1" style="display: inline;float: left">
							:</div>
						<div class="col-md-5" style="float:left;display: inline;font-family: Century Gothic; font-size: 13">
							{{($retTable[0]->FDAstatus == null ? 'Not Yet Evaluated' :($retTable[0]->FDAstatus == 'A') ? 'FDA Certified' : 'FDA Certification Rejected')}}
						</div>
						<div class="col-md-1" style="display: inline">
							&nbsp;</div>
					</div>
					@if($retTable[0]->FDAstatus == 'A' && isset($retTable[0]->fdacoc))
					<div class="row">
							<div class="col-md-1"  >&nbsp;</div>
						<div class="col-md-3" >
							COC Number
						</div>
						<div class="col-md-1" style="display: inline;float: left">
							:</div>
						<div class="col-md-5" style="float:left;display: inline;">
							{{$retTable[0]->fdacoc}}
						</div>
						<div class="col-md-1" style="display: inline">
							&nbsp;</div>
					</div>
					@endif
				@endif --}}
					@if((count($addons) > 0)  || ($disercap != 'level3' && isset($retTable[0]->noofdialysis) && $retTable[0]->noofdialysis > 0) )
					<div class="row mt-3">
							<div class="col-md-1"  >&nbsp;</div>
						<div class="col-md-4 contl" >
							Other Services Offered
						</div>
					</div>
					<div class="row">
							<div class="col-md-1"  >&nbsp;</div>
							<script>
								console.log('{{$retTable[0]->addonDesc}}')
							</script>
						<div class="col-md-5 pl-5 mt-3 contr" >
						@if($disercap != 'level3' && isset($retTable[0]->noofdialysis) && $retTable[0]->noofdialysis > 0)
										{{((isset($retTable[0]->noofdialysis)) ? $retTable[0]->noofdialysis : "NA")}} Dialysis Station, 	
							@endif
						<!-- <div class="col-md-3 pl-5 mt-3 contr" > -->
							@foreach($addons as $add)
								@php
								$ons = json_decode($retTable[0]->addonDesc);
								$exadd = 'no';
								$aowner = ' ';
									foreach($ons as $o){
										if($o->facid_name  == $add && $o->servtyp == 1){
											$exadd = 'yes';
											$aowner = $o->servowner;
										}
									}
								@endphp
										@if($exadd == 'yes')
										{{$add}} (Owner: {{$aowner}})
										@else
										{{$add}}
										@endif
										
									
							@endforeach
						</div>
					</div>
					@endif


				<div class="row">
					<div class="col-md-5">
						<p class="text-muted text-small" style="float: left; margin-top: 80px;">
							{{-- <iframe src="{{asset('ra-idlis/resources/views/client1/qrcode/index.php')}}?data={{asset('client1/certificates/view/external/')}}/{{$retTable[0]->appid}}" style="border: none !important; height: 150px; width: 150px;"></iframe> --}}
							<iframe src="{!!url('qrcode/'.$retTable[0]->appid )!!}" style="border: none !important; height: 230px; width: 260px;"></iframe>
						</p>
					</div>
					<div class="col-md-7">
						<br><br><br>
						<div class="row">
							{{-- <div class="col-md-5">&nbsp;</div> --}}
							<div class="col-md-12 auth" >
								<strong>By Authority of the Secretary of Health:</strong>
							</div>
						</div><br><br>
						<div class="row">
							{{-- <div class="col-md-4">&nbsp;</div> --}}
							<div class="col-md-12 director" >
								<strong ><center>{{ucwords($director->directorInRegion)}}</center></strong>
							</div>
						</div>
						<div class="row">
							{{-- <div class="col-md-4">&nbsp;</div> --}}
							<div class="col-md-12 pos">
								<center><b>{{$director->pos}}</b></center>
							</div>
						</div>
						<br><br><br>
					</div>
				</div>
				<!-- <h5 class="text-uppercase text-center text-muted">By Authority of the Secretary of Health:</h5>
				<br><br><br>
				<h6 class="text-uppercase text-center"><strong>{{--((isset($sec_name)) ? $sec_name->sec_name : 'DIRECTOR')--}}</strong></h6>
				<p class="text-small text-center text-muted">Director IV</p> -->

			</div>
			</div>
			<div class="card-footer">
			
			<center>
			<b><hr/></b>
				<br/>
			<i><b style="font-family: Cambria, Georgia, serif; font-size: 18px">This license is renewable annually and subject to suspension or revocation if the hospital is found violating RA 4226 and related
issuances.</b></i></center>
<br/><br/>
				<p class="text-muted text-small" style="float: right; padding: 0; margin: 0;">© All Rights Reserved {{date('Y')}}</p>
			</div>
		</div><br>
	</div>
</body>
@endsection