@extends('main')
@section('content')
@include('client1.cmp.__issuance')
<body>
<?php

function xucwords($string)
{
	$words = split(" ", $string);
	$newString = array();

	foreach ($words as $word)
	{
		if(!preg_match("/^m{0,4}(cm|cd|d?c{0,3})(xc|xl|l?x{0,3})(ix|iv|v?i{0,3})$/", $word)) {
			$word = ucfirst($word);
		} else {
			$word = strtoupper($word);
		}

		array_push($newString, $word);
	}

	return join(" ", $newString);  
}



?>
	<style>
		ol,li{
			list-style: none;
		}
		.leftHeader{
			font-family: Cambria, Georgia, serif;
			font-size: 12;
		}
		.rightHeader{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12;
		}
		li{
			padding-top: 20px;
		}
	</style>
	<div class="container mt-5">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-3 hide-div">
						<img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: left; max-height: 118px; padding-left: 20px;"><br/><br/><br/><br/><br/><br/>
						<p>Revised 2018 changed signatory</p>
					</div>
					
					<!-- <div class="col-md-9"> -->
<center>
						<h5 class="card-title text-center font-weight-bold">Republic of the Philippines</h5>
						<h4 class="card-title text-uppercase text-center font-weight-bold">Department of Health</h4>
						<h3 class="card-title text-uppercase text-center font-weight-bold">{{((isset($director->certificateName)) ? $director->certificateName : 'REGION')}}</h3>
					</center>
					<!-- </div> -->
					
					
				</div>
			</div>
			<div class="card-body">
				<br>
				<h1 class="text-center">PERMIT TO CONSTRUCT</h1><br>
				<div class="row">
					<div class="col-md-2">
						<p style="float: left;" class="leftHeader">Owner </p><span style="float: right">:</span>
					</div>
					<div class="col-md-8">
						<p  class="rightHeader"><strong>{{((isset($retTable[0]->owner)) ? $retTable[0]->owner : 'No owner')}}</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<p style="float: left;" class="leftHeader">Name of Health Facility </p><span style="float: right">:</span>
					</div>
					<div class="col-md-8">
						<p  class="rightHeader"><strong>{{((isset($retTable[0]->facilityname)) ? strtoupper($retTable[0]->facilityname)  : 'No facility name')}}</strong></p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">
						<p style="float: left;" class="leftHeader">Type of Health Facility </p><span style="float: right">:</span>
					</div>
					<div class="col-md-8">
						<p  class="rightHeader"><strong>{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($retTable[0]->appid)->hgpdesc ?? 'NOT FOUND')}}</strong></p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<p style="float: left;" class="leftHeader">Location </p><span style="float: right">:</span>
					</div>
					<div class="col-md-8">

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
					
						<!-- <p class="rightHeader"><strong>{{((isset($retTable[0])) ? ($retTable[0]->street_name.', '.$retTable[0]->street_number.', '.$retTable[0]->brgyname.', '.$retTable[0]->cmname.', '.$retTable[0]->provname.' '.$retTable[0]->rgn_desc) : 'No Location.')}}</strong></p> -->
						<!-- <p class="rightHeader"><strong>{{((isset($retTable[0])) ? ($retTable[0]->rgn_desc.', '.$retTable[0]->provname.', '.$retTable[0]->cmname.', '.$retTable[0]->brgyname.', '.$retTable[0]->street_name.' '.$retTable[0]->street_number) : 'No Location.')}}</strong></p> -->
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<p style="float: left;" class="leftHeader">Scope of Work </p><span style="float: right">:</span>
					</div>
					<div class="col-md-8">
						<p  class="rightHeader"><strong>
						{{((isset($otherDetails->HFERC_comments)) ? $otherDetails->HFERC_comments : 'Not Specified')}}</strong></p>
					</div>
				</div>
				<br><br>
				<h5>Terms and Conditions</h5>
				<!-- <h5>Terms and Conditions of the DOH-PTC</h5> -->
				<div class="container">
					<ol>
						<li>1. &nbsp;&nbsp;That the construction, alteration, expansion or renovation of a hospital or other health facility is implemented in accordance with:
						<ol>
							<li >1.1&nbsp;&nbsp; Floor Plans prepared by a duy licensed Architect and/or Civil Engineer and approved by the Health Facilities and Services Regulatory Bureau</li>
							<li>1.2&nbsp;&nbsp; Architectural and engineering drawings (based on approved floor plans by the Regional Office), specifications, building permit and fire safety permit prepared by a duly licensed Architect and/or Civil Engineer and approved by the Office of the Building Official and the Bureau of Fire Protection in the locality;</li>
						</ol>
						</li>
						<li>
							2.&nbsp;&nbsp; That the permit to construct and approved floor plans comprise observance of appropriate professional practices, prescribed functional relationships and applicable codes;
						</li>
						<li>
							3.&nbsp;&nbsp; That the permit to construct and approved floor plans are available for ready reference at the construction site;
						</li>
						<li>
							4.&nbsp;&nbsp; That the permit to construct is considered lapsed and fee paid is forfeited when the work authorized by the permit does not commence within 365 days from date of issuance, or is abandoned during the period specified; in which case, another application shall be filed;
						</li>
						<li>
							5.&nbsp;&nbsp; That the submission of progress report/status on the construction both for new and existing health facility required every six (6) months until project completion
						</li>
						<li>
							6.&nbsp;&nbsp; That any addition and/or alteration of scope of work shall be reported immediately to the Health Facilities and Services Regulatory Bureau for appropriate action;
						</li>
						<li>
							7.&nbsp;&nbsp; That any unauthorized deviation from approved floor plans or any violation of the above condition, will be sufficient ground for the imposition of sanctions as based from the provision of Administrative Order No. 2016-0042
						</li>
						<li>
							8.&nbsp;&nbsp; Inspection of the facility is necessary prior to the operation, utilization or usage of the approved scope of work.
						</li>
					</ol>
				</div>
				<br>
				<br>
				<div class="row">
					<div class="col-md-4" style="vertical-align: bottom;">
						<small class="text-small">PTC No. {{$retTable[0]->licenseNo}}</small>
						<br>
						<small class="text-small">Date Issued: {{((isset($retTable[0]->t_date)) ? date("F j, Y", strtotime($retTable[0]->t_date)) : 'No date.')}}</small>
					</div>
					<div class="col-md-8">
						<h3 class="text-uppercase text-center" style="font-size: 30px;"><strong>{{$director->directorInRegion}}{{-- {{((isset($retTable[0]->asdf)) ? $retTable[0]->asdf : 'No Director.')}} --}}</strong></h3>
						<p class="text-small text-center text-muted">{{$director->pos}}</p>
					</div>					
				</div>
			</div>
			<div class="card-footer">
				<p class="text-muted text-small" style="float: left; padding: 0; margin: 0;">
					{{-- <iframe  src="{{asset('ra-idlis/resources/views/client1/qrcode/index.php')}}?data={{asset('client1/certificates/view/external/')}}/{{$retTable[0]->appid}}" style="border: none !important; height: 150px; width: 150px;"></iframe> --}}
					<iframe src="{!!url('qrcode/'.$retTable[0]->appid )!!}" style="border: none !important; height: 230px; width: 260px;"></iframe>
				</p>
				<p class="text-muted text-small" style="float: right;">© All Rights Reserved {{date('Y')}}</p>
			</div>
		</div><br>
	</div>
</body>
@endsection