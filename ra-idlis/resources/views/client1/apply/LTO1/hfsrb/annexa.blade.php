@if (session()->exists('uData'))  
	@extends('main')
	@section('content')
	@include('client1.cmp.__apply')
	@include('client1.cmp.requirementsSlider')
	@include('client1.cmp.nav')
		@include('client1.cmp.breadcrumb')
		@include('client1.cmp.msg')
		<style>
			    fieldset 
				{
					border: 1px solid #ddd !important;
					margin: 0;
					xmin-width: 0;
					padding: 10px;       
					position: relative;
					border-radius:4px;
					background-color:#f5f5f5;
					padding-left:10px!important;
				}	
				
				legend
				{
					font-size:14px;
					font-weight:bold;
					margin-bottom: 0px; 
					width: 35%; 
					border: 1px solid #ddd;
					border-radius: 4px; 
					padding: 5px 5px 5px 10px; 
					background-color: #ffffff;
				}

				@media (min-width: 576px) {
				  .modal-dialog { max-width: none; }
				}

				.modal-dialog {
				  width: 98%;
				  height: 92%;
				  padding: 0;
				}

				.modal-body {
				   max-height: calc(100vh - 200px);
    			   overflow-y: auto;
				}

				.modal-content {
				  height: auto;
				}

				.select2-container--default .select2-selection--single {
				    height: 40px !important;
				    padding: 10px 16px;
				    font-size: 18px;
				    line-height: 1.33;
				    border-radius: 6px;
				}
				.select2-container--default .select2-selection--single .select2-selection__arrow b {
				    top: 85% !important;
				}
				.select2-container--default .select2-selection--single .select2-selection__rendered {
				    line-height: 20px !important;
				}
				.select2-container--default .select2-selection--single {
				    border: 1px solid #CCC !important;
				    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
				    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
				}

		</style>
	<body>
		@include('client1.cmp.__wizard')

		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col-md-6 d-flex justify-content-start" id="prevDiv">
					<a href="#" class="inactiveSlider slider">&laquo; Previous</a>
				</div>
				<div class="col-md-6 d-flex justify-content-end" id="nextDiv">
					<a href="#" class="activeSlider slider">Next &raquo;</a>
				</div>
			</div>
		</div>
		<div class="container text-center font-weight-bold mt-5">List of Personnel Annex A</div>
		<div class="container-fluid table-responsive pb-3">
			@if($canAdd)
				<button class="btn btn-primary pl-3 mb-3" data-toggle="modal" data-target="#viewModal" data-backdrop="static" data-keyboard="false" onclick="$('#viewModal').on('shown.bs.modal', function () {addFunc()});">Add</button>
			@endif
				<table class="table table-hover" id="tApp">
		      		<thead style="background-color: #428bca; color: white" id="theadapp">
		      			<tr>
		      				<th>Prefix</th>
							<th>Surname</th>
							<th>First Name</th>
							<th>Middle Name</th>
							<th>Suffix</th>
							<th>Profession</th>
							<th>PRC Reg. Number</th>
							<th>Validity Period Until</th>
							{{-- <th>Speciality</th> --}}
							<th>Date of Birth</th>
							<th>Sex</th>
							<!-- <th>Email</th> -->
							<th>Employment</th>
							<th>Position/<br/>Designation</th>
							{{-- <th>Qualification</th> --}}
							{{-- <th>Area</th> --}}
							<th>Work Status</th>
							{{-- <th>TIN</th> --}}
							<th>Status</th>
							<th>Options</th>
						</tr>
		      		</thead>
		      		<tbody id="loadHere">
		      			@foreach($hfsrbannexa[0] as $personnel)
		      				@php 
		      					$_txtColor = 'text-black';
		      					$_trColor = 'white';
		      					$_stat = array('Active');
		      					if(strtotime($personnel->validityPeriodTo) <= strtotime('now')){
		      						$_trColor = 'danger';
		      						$_txtColor = 'text-white';
		      						array_push($_stat, 'PRC License Expired');
		      					} else if(strtotime($personnel->validityPeriodTo) <= strtotime('+1 month')){
		      						$_trColor = 'warning';
		      						array_push($_stat, 'PRC License Almost Expired');
		      					}
		      					if($personnel->status == 0){
		      						unset($_stat[0]);
		      						array_push($_stat, 'Resigned');
		      					}
		      				@endphp
							<tr class="bg-{{$_trColor}} {{$_txtColor}}">
								<td>{{ucfirst($personnel->prefix)}}</td>
								<td>{{ucfirst($personnel->surname)}}</td>
								<td>{{ucfirst($personnel->firstname)}}</td>
								<td>{{ucfirst($personnel->middlename)}}</td>
								<td>{{ucfirst($personnel->suffix)}}</td>
								<td>{{ucfirst($personnel->posname)}} </td>
								<td>{{$personnel->prcno}}</td>
								{{-- <td>{{$personnel->validityPeriodFrom}}</td> --}}
								<td>{{$personnel->validityPeriodTo}}</td>
								{{-- <td>{{$personnel->speciality}}</td> --}}
								<td>{{$personnel->dob}}</td>
								<td>{{$personnel->sex}}</td>
								<!-- <td>{{$personnel->email}}</td> -->
								<td>{{$personnel->pworksname}}</td>
								<td>{{$personnel->pos}}</td>
								{{-- <td>{{$personnel->qual}}</td> --}}
								{{-- <td>{{$personnel->designation}}</td> --}}
								{{-- <td>{{$personnel->area}}</td> --}}
								<td>{{$personnel->pworksname}}</td>
								{{-- <td>{{$personnel->tin}}</td> --}}
								<td class="font-weight-bold">{{implode(',',$_stat)}}</td>
								@if($canAdd)
								<td>
									<div class="container">
										<div class="row">
									
											<div class="col-md-6">
												<button class="btn border-dark btn-warning" title="edit" onclick="showData(
													'{{$personnel->id}}',
												'{{$personnel->prefix}}',
												'{{$personnel->surname}}',
												'{{$personnel->firstname}}',
												'{{$personnel->middlename}}',
												'{{$personnel->suffix}}',
												'{{$personnel->prof}}',
												'{{$personnel->prcno}}',
												'{{$personnel->validityPeriodTo}}',
												'{{$personnel->dob}}',
												'{{$personnel->sex}}',
												'{{$personnel->employement}}',
												'{{$personnel->pos}}'
												/*,'{{$personnel->area}}'*/,
												'{{$personnel->qual}}',
												'{{$personnel->email}}',
												/*'{{$personnel->tin}}',*/ 
												'{{$personnel->isMainRadio}}',
												 '{{$personnel->ismainpo}}',
												  '{{$personnel->isMainRadioPharma}}',
												  '{{$personnel->isXrayTech}}',
												  '{{$personnel->isChiefRadTech}}'
												  
												  )
												  
												  ">
													<i class="fa fa-edit"></i>
												</button>
											</div>
											@if($personnel->status == 1)
											<div class="col-md-6">
												<button class="btn border-primary btn-danger" data-toggle="modal" data-target="#deletePersonnel" title="Change Status to Resigned" onclick="showDelete('{{$personnel->id}}','{{$personnel->surname.' '.$personnel->firstname.' '.$personnel->middlename}}',1)"><i class="fa fa-sign-out" aria-hidden="true"></i></button>
											</div>
											@else
											<div class="col-md-6">
												<button class="btn border-dark btn-primary" data-toggle="modal" data-target="#deletePersonnel" title="Change Status to Active" onclick="showDelete('{{$personnel->id}}','{{$personnel->surname.' '.$personnel->firstname.' '.$personnel->middlename}}',2)"><i class="fa fa-handshake-o" aria-hidden="true"></i></button>
											</div>
											@endif
										</div>
									</div>
								</td>
								@else 
								<td class="font-weight-bold">NOT AVAILABLE</td>
								@endif
							</tr>
							@endforeach
		      		</tbody>
		      	</table>
		</div>
		<div class="remthis modal fade" id="viewModal" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	                <div class="modal-header" id="viewHead">
	                    <h5 class="modal-title" id="actionModalCRUD">Add Personnel</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <form id="personnelAdd" method="POST" enctype="multipart/form-data">
	                <div class="modal-body" id="viewBody">
	               		<input type="hidden" name="action" id="toChange" value="add">
	               		<input type="hidden" name="id" id="idToAdd">
	               		{{csrf_field()}}
						<fieldset>
							<legend>Employee Personal Details:</legend>
							<div class="row mb-2">
								<div class="col-md-3">
									<div class="col-sm">
										Prefix:
									</div>
									<div class="col-sm-11">
										{{-- <input class="form-control w-100" name="prefix"> --}}
										<select name="prefix" class="form-control">
											<option value="" selected>None</option>
											<option value="Mr">Mr</option>
											<option value="Mrs">Mrs</option>
											<option value="Ms">Ms</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="col-sm required">
										First Name:
									</div>
									<div class="col-sm-11">
										<input class="form-control w-100" name="fname" required="">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-sm">
										Middle Name:
									</div>
									<div class="col-sm-11">
										<input class="form-control w-100" name="mname">
									</div>
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-md-6">
									<div class="col-sm required">
										Surname:
									</div>
									<div class="col-sm-11">
										<input class="form-control w-100" name="sur_name" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="col-sm">
										Suffix:
									</div>
									<div class="col-sm-11">
										{{-- <input class="form-control w-100" name="suffix"> --}}
										<select name="suffix" class="form-control">
											<option value="" selected>None</option>
											<option value="Jr">Jr</option>
											<option value="II">II</option>
											<option value="III">III</option>
											<option value="IV">IV</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Date of Birth:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input type="date" class="form-control w-100" name="dob" required="">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Sex:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<select name="sex" id="sex" class="form-control">
		                   					<option value="M">Male</option>
		                   					<option value="F">Female</option>
		                   				</select>
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Email:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input type="email" class="form-control w-100" name="email" required="">
		                   			</div>
								</div>
							</div>
						 </fieldset>
						 <fieldset class="mt-5">
							<legend>Employment Details:</legend>
							<div class="row mb-2">
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Position/Designation:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" name="position" required="">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Profession:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<div class="row">
		                   					<div class="col-md-10">
		                   						<!-- <select onchange="setAssignment(this.value)" name="prof"  class="form-control" required=""> -->
		                   						<select onchange="getAss(this.value)"  name="prof" id="prof" class="form-control" required="">
				                   					<option value="">Please Select</option>
				                   					@foreach($pos as $p)
				                   						<option value="{{$p->posid}}" isRequired="{{$p->groupRequired}}">{{$p->posname}}</option>
				                   					@endforeach
				                   				</select>
		                   					</div>


		                   					<!-- {{-- @if($hfsrbannexa[1]) --}}
		                   					<div class="col-md" style="display: none;" id="ishead">
		                   						<input type="checkbox" name="head"> Make as Head of Radiology
		                   					</div>
		                   					{{-- @endif --}}
		                   					{{-- @if($hfsrbannexa[2]) --}}
		                   					<div class="col-md" style="display: none;" id="isrpo">
		                   						<input type="checkbox" name="po"> Make as Radiation protection officer
		                   					</div>
											   
		                   					{{-- @endif --}}
		                   					{{-- @if($hfsrbannexa[3]) --}}
		                   					<div class="col-md" style="display: none;" id="isph">
		                   						<input type="checkbox" name="pharmahead"> Make as Chief Pharmacist
		                   					</div>
		                   					{{-- @endif --}} -->


											   

		                   					<!-- {{-- @if($hfsrbannexa[1]) --}}
		                   					<div class="col-md" >
		                   						<input type="checkbox" name="head"> Make as Head of Radiology
		                   					</div>
		                   					{{-- @endif --}}
		                   					{{-- @if($hfsrbannexa[2]) --}}
		                   					<div class="col-md" >
		                   						<input type="checkbox" name="po"> Make as Radiation protection officer
		                   					</div>
		                   					{{-- @endif --}}
		                   					{{-- @if($hfsrbannexa[3]) --}}
		                   					<div class="col-md" >
		                   						<input type="checkbox" name="pharmahead"> Make as Chief Pharmacist
		                   					</div>
		                   					{{-- @endif --}} -->

											<div id="mainassignment">
												<div id="assignment">

											
												</div>
											
											</div>
		                   					
											 
		                   				</div>
		                   				<div class="col-md" id="isrpo1" hidden>
		                   						<input type="checkbox" value="1" name="po1" id="po1" > Make as Radiation protection officer
		                   				</div>
										
										<div class="col-md" id="ishead1" hidden>
		                   						<input type="checkbox" value="1" name="head1" id="head1" > Make as Head of Radiology
		                   				</div>
										
										<div class="col-md" id="ispharmahead1" hidden>
		                   						<input type="checkbox" value="1" name="pharmahead1" id="pharmahead1" > Make as  Chief Pharmacist
		                   				</div>
										<div class="col-md" id="isxtech" hidden>
		                   						<input type="checkbox" value="1" name="xtech" id="xtech" >  Make as Xray technologist
		                   				</div>
										<div class="col-md" id="ischiefrt" hidden>
		                   						<input type="checkbox" value="1" name="chiefrt" id="chiefrt" >Make as Chief Radiation Technologist
		                   				</div>

		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm">
	                   					Specialization:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" name="qual">
		                   			</div>
								</div>
								{{-- <div class="col-md-3">
									<div class="col-sm required">
	                   					Area of Assignment:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" name="assignment" required="">
		                   			</div>
								</div> --}}
							</div>
							<div class="row mb-2">
								<div class="col-md-4">
									<div class="col-sm required">
	                   					PRC Reg. Number:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100 canBeNot" name="prcno" required="">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Validity Period Until:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100 canBeNot" type="date" name="vto" required="">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Work Status:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<select name="employement" id="employement" class="form-control">
		                   					<option value="">Please Select</option>
		                   					@foreach($workstat as $work)
		                   						<option value="{{$work->pworksid}}">{{$work->pworksname}}</option>
		                   					@endforeach
		                   				</select>
		                   			</div>
								</div>
							</div>
							<div class="row mb-2">
								{{-- <div class="col-md-6">
									<div class="col-sm required">
	                   					TIN
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" name="tin" required="">
		                   			</div>
								</div> --}}
{{-- 								<div class="col-md-6">
									<div class="col-sm required">
	                   					PRC Reg. Number:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" name="prcno" required="">
		                   			</div>
								</div> --}}
							</div>
						 </fieldset>
						 <fieldset class="mt-5" id="forUpload" hidden>
							<legend>Uploading of Credentials: <span class="text-danger" id="forCred"></span></legend>
							<div class="row mb-2 first" hidden>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					PRC:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" type="file" name="req[prc]">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Board Certificate:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" type="file" name="req[bc]">
		                   			</div>
								</div>
								<div class="col-md-4">
									<div class="col-sm required">
	                   					Contract of Employment:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" type="file" name="req[coe]">
		                   			</div>
								</div>
							</div>
							<div class="row mb-2 second" hidden>
								<div class="col-md-6">
									<div class="col-sm required">
	                   					PRC:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" type="file" name="req[prc1]">
		                   			</div>
								</div>
								<div class="col-md-6">
									<div class="col-sm required">
	                   					Certificate of Training:
		                   			</div>
		                   			<div class="col-sm-11">
		                   				<input class="form-control w-100" type="file" name="req[cert]">
		                   			</div>
								</div>
							</div>
						</fieldset>
	                </div>
	                <div class="modal-footer">
	                	<button type="submit" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					</form>
	            </div>
	        </div>
	    </div>
	    <div class="remthis modal fade" id="editPersonnel" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header" id="viewHead">
	                    <h5 class="modal-title" id="viewModalLabel">Edit Personnel</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body" id="viewBodyEdit">
	                   	<form id="personnelEdit">	
	                   	</form>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="remthis modal fade" id="deletePersonnel" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header" id="viewHead">
	                    <h5 class="modal-title" id="actionModal">Edit Personnel</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body" id="viewBodyDelete">
	                </div>
	            </div>
	        </div>
	    </div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="{{asset('ra-idlis/public/js/forall.js')}}"></script>
		<script type="text/javascript">
		function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
  		}
			function setAssignment(value){
				console.log()
				document.getElementById("assignment").remove()

				var x = document.createElement("div");
                x.setAttribute("id",'assignment');
                document.createElement("mainassignment").appendChild(x);
				
				chceb('head', ' Make as Head of Radiology');
				chceb('po', ' Make as Radiation protection officer');
				chceb('pharmahead', ' Make as Chief Pharmacist');

				
			}
			function getAss(value){

				console.log("value")
				console.log(value)

				if(value == "20" || value == "3"|| value == "6"|| value == "12"){
					document.getElementById("isrpo1").removeAttribute("hidden")
				}else{
					document.getElementById("isrpo1").setAttribute("hidden", "hidden");
				}

				if(value == "3"){
					document.getElementById("ishead1").removeAttribute("hidden")
					
				}else{
					document.getElementById("ishead1").setAttribute("hidden", "hidden");
				}

				if(value == "8"){
					document.getElementById("ispharmahead1").removeAttribute("hidden")
					
				}else{
					document.getElementById("ispharmahead1").setAttribute("hidden", "hidden");
				}


				if(value == "12"){
					document.getElementById("isxtech").removeAttribute("hidden")
					document.getElementById("ischiefrt").removeAttribute("hidden")
					
				}else{
					document.getElementById("isxtech").setAttribute("hidden", "hidden");
					document.getElementById("ischiefrt").setAttribute("hidden", "hidden");
				}




				// console.log()
				// document.getElementById("assignment").remove()

				// var x = document.createElement("div");
                // x.setAttribute("id",'assignment');
                // document.createElement("mainassignment").appendChild(x);
				
				// chceb('head', ' Make as Head of Radiology');
				// chceb('po', ' Make as Radiation protection officer');
				// chceb('pharmahead', ' Make as  Chief Pharmacist');

				
			}
			function chceb(name, desc){
				var ass = document.getElementById("assignment");
			
				var x = document.createElement("div");
                x.setAttribute("id",'is'+name);
                x.setAttribute("class", "col-md");
                ass.appendChild(x);



				var ids = name+"inpt";
				var x = document.createElement("input");
                x.setAttribute("type", "checkbox");
                x.setAttribute("id", ids);
                x.setAttribute("name", name);
				x.setAttribute("class", "custom-control-input");
                document.getElementById("is"+name).appendChild(x);
				

                var label = document.createElement("Label");
                label.setAttribute("for", ids);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = desc;

                var newInput = document.getElementById(ids)
                insertAfter(newInput, label);
			}
			// $(function(){
			// 	toReq();
			// })
			let rad = Array('12','13');
			let par = Array('6','3');
			let fieldOnUp = $("#forUpload");
			let inputs;
			let fieldsForInput = Array('id','prefix','sur_name','fname','mname','suffix','prof','prcno','vto','dob','sex','employement','position'/*,'assignment'*/,'qual','email'/*,'tin'*/,null, null, null);

			$("#prof").change(function(event) {
				let isRequiredForSend = $("#prof option:selected").attr('isRequired');
				let canBeRequired = $(".canBeNot");
				switch (true) {

					case (isRequiredForSend == 1):
						canBeRequired.attr('required',true).addClass('required');
						if(canBeRequired.parent().prev().find('span').length <= 0){
							$( canBeRequired.parent().prev() ).append( '<span class="text-danger" style="font-size: 20px;">*</span>');
						}

					break;

					case (isRequiredForSend == 0):
						canBeRequired.removeAttr('required').removeClass('required').parent().prev().find('span').remove();
					break;

					// case (jQuery.inArray($(this).val(), rad) != -1):
					// 	fieldOnUp.removeAttr('hidden');
					// 	$(".first").removeAttr('hidden');
					// 	inputs = $(".first").find('input[type=file]');
					// 	if(inputs.length > 0){
					// 		inputs.each(function(index, el) {
					// 			$(this).attr('required',true).removeAttr('hidden');
					// 		});
					// 	}
					// 	$(".second").attr('hidden',true);
					// 	inputs = $(".second").find('input[type=file]');
					// 	if(inputs.length > 0){
					// 		inputs.each(function(index, el) {
					// 			$(this).removeAttr('required').attr('hidden',true).val('');
					// 		});
					// 	}
					// 	break;
					// case (jQuery.inArray($(this).val(), par) != -1):
					// 	fieldOnUp.removeAttr('hidden');
					// 	$(".second").removeAttr('hidden');
					// 	inputs = $(".second").find('input[type=file]');
					// 	if(inputs.length > 0){
					// 		inputs.each(function(index, el) {
					// 			$(this).attr('required',true).removeAttr('hidden');
					// 		});
					// 	}
					// 	$(".first").attr('hidden',true);
					// 	inputs = $(".first").find('input[type=file]');
					// 	if(inputs.length > 0){
					// 		inputs.each(function(index, el) {
					// 			$(this).removeAttr('required').attr('hidden',true).val('');
					// 		});
					// 	}
					// 	break;
					default:
						fieldOnUp.attr('hidden',true);
						$(".first .second").attr('hidden',true);
						inputs = fieldOnUp.find('input[type=file]');
						if(inputs.length > 0){
							inputs.each(function(index, el) {
								$(this).removeAttr('required').attr('hidden',true).val('');
							});
						}
						break;
				}
			});

			"use strict";
			// var ___div = document.getElementById('__applyBread'), ___wizardcount = document.getElementsByClassName('wizardcount');
			// document.getElementById('stepDetails').innerHTML = 'Step 3.b: HFSRB Requirement';
			// if(___wizardcount != null || ___wizardcount != undefined) {
			// 	for(let i = 0; i < ___wizardcount.length; i++) {
			// 		if(i < 2) {
			// 			___wizardcount[i].parentNode.classList.add('past');
			// 		}
			// 		if(i == 2) {
			// 			___wizardcount[i].parentNode.classList.add('active');
			// 		}
			// 	}
			// }
			// if(___div != null || ___div != undefined) {
			// 	___div.classList.remove('active');	___div.classList.add('text-primary');
			// }
		</script>
		@include('client1.cmp.footer')
		<script>
            onStep(3);
            slider([],['hfsrb','annexb',{{$appid}}]);
        </script>
		<script>
			$(function(){
				$("#tApp").dataTable();
			})
			$('[name=prefix],[name=suffix]').select2({ width: '100%', tags: true });
			@if($canAdd)
			function addFunc(){
				$("#actionModalCRUD").empty().html('Add Personnel');
				$("#toChange").val('add');
				$("#idToAdd").val("");
				$("#forCred").empty();
				for(let j = 0; fieldsForInput.length > j; j++){
					if($('input[name='+fieldsForInput[j]+']').length > 0){
				    	$('input[name='+fieldsForInput[j]+']').val("").trigger('change');
				    } else {
				    	$('select[name='+fieldsForInput[j]+']').val("").trigger('change');
				    }
				}
				// $("input[type=file]:hidden").each(function(index, el) {
				// 	$(this).parent().prev().append('<span class="text-danger" style="font-size: 20px;">*</span>');
				// 	$(this).attr('required',true);
				// });
			}
			function showData(id,pre,sur,first,mid,suf,prof,prcno,valid,dob,sex,emp,pos/*,des,area*/,qual,email/*,tin*/, head = null, po = null, pharmahead = null, isXrayTech = null, isChiefRadTech = null){
			console.log("head1")
			console.log(head)
				$("#viewModal").modal('toggle');
				$("#viewModal").on('shown.bs.modal', function(){
					otherFunction(id,pre,sur,first,mid,suf,prof,prcno,valid,dob,sex,emp,pos/*,des,area*/,qual,email/*,tin*/, head, po, pharmahead, isXrayTech, isChiefRadTech);
				});
			}

			// function toReq(){
			// 	$(".required").each(function(index, el) {
			// 		$(el).append('<span class="text-danger" style="font-size: 20px;">*</span>');
			// 	});
			// }

			function otherFunction(id,pre,sur,first,mid,suf,prof,prcno,valid,dob,sex,emp,pos/*,des,area*/,qual,email/*,tin*/,head, po, pharmahead, isXrayTech, isChiefRadTech){
				$("#actionModalCRUD").empty().html('Edit Personnel');
				$("#toChange").val('edit');
				$("#idToAdd").val(id);
				$("#forCred").empty().append('(You may resubmit or if not, details of credentials will be retained)');
				console.log(arguments)
				// if(arguments.length == fieldsForInput.length){
					// if(head != ""){
					// 	$('[name=head]').show();
					// 	$('[name=head]').attr('value',1);
					// 	$('[name=head]').prop('checked',true);
					// }
					// if(po != ""){
					// 	$('[name=po]').show();
					// 	$('[name=po]').attr('value',1);
					// 	$('[name=po]').prop('checked',true);
					// }
					// if(pharmahead != ""){
					// 	$('[name=pharmahead]').show();
					// 	$('[name=pharmahead]').attr('value',1);
					// 	$('[name=pharmahead]').prop('checked',true);
					// }
console.log("head")
console.log(isXrayTech)
console.log(isChiefRadTech)
					if(head == 1){
						
						$('[name=head1]').attr('value',1);
						$('[name=head1]').prop('checked',true);
					}
					if(isXrayTech == "1"){
						
						$('[name=xtech]').attr('value',1);
						$('[name=xtech]').prop('checked',true);
					}
					
					if(isChiefRadTech == "1"){
						
						$('[name=chiefrt]').attr('value',1);
						$('[name=chiefrt]').prop('checked',true);
					}
					if(po != ""){
						
						$('[name=po1]').attr('value',1);
						$('[name=po1]').prop('checked',true);
					}
					console.log("pharmahead")
					console.log(pharmahead)
					if(pharmahead == 1){
						
						$('[name=pharmahead1]').attr('value',1);
						$('[name=pharmahead1]').prop('checked',true);
					}
					for(var arg = 0; arg < arguments.length; ++ arg)
					{
					    var arr = arguments[arg];
					    if($('input[name='+fieldsForInput[arg]+']').length > 0){
					    	$('input[name='+fieldsForInput[arg]+']').val(arr).trigger('change');
					    } else {
					    	$('select[name='+fieldsForInput[arg]+']').val(arr).trigger('change');
					    }
					}
					$("input[type=file]:visible").each(function(index, el) {
						// $(this).parent().prev().find('span').remove()
						$(this).removeAttr('required');
					});
				// } else {
				// 	alert('Arguments are missing! Please contact Admin');
				// }
			}
			function showDelete(id,name,action){
				let sel;
				switch (action) {
					case 1:
					$("#actionModal").empty().html('Change status of Employee to Resign');
						sel = '<div class="container">'+
					'<input type="hidden" id="idtodelete" value='+id+'>'+
					' Are you sure you want to Set status of <span class="text-danger">'+
					name +
					' to Resigned?</span>?<br>'+
					'<button type="button" class="btn btn-danger" id="delete">Submit</button>'+
					'<button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>'+
					'</div>';
						break;
					case 2:
					$("#actionModal").empty().html('Change status of Employee to Active');
						sel = '<div class="container">'+
					'<input type="hidden" id="idtodelete" value='+id+'>'+
					' Are you sure you want to Re-active <span class="text-primary">'+
					name +
					'</span>?<br>'+
					'<button type="button" class="btn btn-danger" id="delete">Submit</button>'+
					'<button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>'+
					'</div>';
						break;
				}
				$("#viewBodyDelete").empty().append(
					sel
				);
			}
			$(document).on('click','#delete',function(event){
				$.ajax({
					type: 'POST',
					data:{_token:$('input[name=_token]').val(), action:'delete',id:$("#idtodelete").val()},
					success: function(a){
						if(a == 'DONE'){
							alert('Successfully Changed Status of Personnel');
							location.reload();
						} else {
							console.log(a);
						}
					}
				})
			})
			$(document).on('submit','#personnelAdd',function(event){
				event.preventDefault();
				let data = new FormData(this);
				$.ajax({
					type: 'POST',
					data:data,
					contentType: false,
					processData: false,
					success: function(a){
						if(a == 'DONE'){
							alert('Operation Successul');
							location.reload();
						} else {
							console.log(a);
						}
					}
				})
			})
			$(document).on('submit','#personnelEdit',function(event){
				event.preventDefault();
				let data = new FormData(this);
				$.ajax({
					type: 'POST',
					data:data,
					success: function(a){
						if(a == 'DONE'){
							alert('Successfully Edited Personnel');
							location.reload();
						} else {
							console.log(a);
						}
					},
					fail: function(a,b,c){
						console.log([a,b,c]);
					}
				})
			})

			let forHead = [12,3,17,8,6];
			let dom = [['po'],['po','head'],['po'],['pharmahead'],['po']];
			$("#prof").change(function(event) {
				if($.inArray(Number($(this).val()), forHead) >= 0){
					for (var j=0;  j < dom[$.inArray(Number($(this).val()), forHead)].length;  j++) {
						$('[name='+dom[$.inArray(Number($(this).val()), forHead)][j]+']').parent().toggle('display');
						$('[name='+dom[$.inArray(Number($(this).val()), forHead)][j]+']').attr('value',1);
					}
				} else {
					dom.forEach(function(el,key){
						for (var i=0; i < el.length; i++) {
							if($('[name='+el[i]+']').length){
								$('[name='+el[i]+']').parent().hide();
								$('[name='+el[i]+']').removeAttr('value');
								$('[name='+el[i]+']').prop('checked',false);
							}
						}
					})
				}
			});
			$(document).ready(function(){
				$('[name=head], [name=po], [name=pharmahead]').change(function(event) {
					if(!$(this).is(':checked')){
						$(this).removeAttr('value');
					} else {
						$(this).attr('value',1);
					}
				});
			})

		@endif
		</script>
	</body>
	@endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('client1/apply') }}";</script>
@endif

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css" />