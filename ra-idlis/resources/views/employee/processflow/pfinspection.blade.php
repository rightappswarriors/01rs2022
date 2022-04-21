

@if (session()->exists('employee_login'))   
  @extends('mainEmployee')
  @section('title', 'Inspection Schedule')
  @section('content')


   <input type="text" id="CurrentPage" hidden="" value="PF011">
		<div class="content p-4">
  	<div class="card">
  		<div class="card-header bg-white font-weight-bold">
             Inspection Schedule
          </div>
          <div class="card-body table-responsive">
          	<table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
	                  <tr>
                        <th scope="col">Type of Facility</th>
	                  	  <th scope="col">Name of Facility</th>
	                      <th scope="col">Application Code</th>
	                      <th scope="col">Information</th>
	                  </tr>
                  </thead>
                  <tbody id="FilterdBody" >
                    
                   	@foreach($applicant as $apply)
					   <script>
						console.log("{!! $apply->hasAssessors.'---'. $apply->facilityname.'---' . AjaxController::canProcessNextStepFDA($apply->appid,'isCashierApproveFDA','isCashierApprovePharma') !!}")
						</script>
					  

                      @if($apply->isrecommended == 1 && $apply->isPayEval == 1 && $apply->isCashierApprove == 1 && in_array($apply->hfser_id, ['LTO','COA']))					
					  {{-- if($apply->isrecommended == 1 && $apply->isPayEval == 1 && $apply->isCashierApprove == 1 && in_array($apply->hfser_id, ['LTO','COA']) && AjaxController::canProcessNextStepFDA($apply->appid,'isCashierApproveFDA','isCashierApprovePharma')) -- }}

                     		@if($apply->hasAssessors == 'T')
            							<tr style="padding-right: 20px!important;">
                            <td scope="row" class="font-weight-bold">{{$apply->hfser_id}}</td>
            								<td scope="row" class="">{{$apply->facilityname}}</td>
            								<td scope="row" class="">{{$apply->hfser_id.'R'.$apply->rgnid.'-'.$apply->appid}}</td>
            								<td scope="row" class="">
            									<center>
            										 <button type="button" title="Show details for  {{$apply->facilityname}}" class="btn btn-outline-primary" onclick="window.location.href = '{{ asset('employee/dashboard/processflow/inspection') }}/{{$apply->appid}}'"><i class="fa fa-fw fa-clipboard-check"></i></button>&nbsp;
            									</center>
            								</td>
            							</tr>
  						          @endif
                      @endif

                   	@endforeach
                  </tbody>
              </table>
          </div>
  	</div>
  </div>
    <script type="text/javascript">
	  	$(document).ready(function(){
	  		$('#example').DataTable();
	  	});
	  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif
