@if (session()->exists('employee_login'))   
  @extends('mainEmployee')
  @section('title', 'Assessment Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF009">
  <div class="content p-4">
      <div class="card">
          <div class="card-header bg-white font-weight-bold">
             Assess Applicants   @include('employee.tableDateSearch')
          </div>
          <div class="card-body table-responsive">
        
              <table class="table table-hover" id="example" style="font-size:13px; width: 100%">
                  <thead>
                  <tr>
                      <th ></th>
                      <th></th>
                      <th ></th>
                      <th  class="select-filter"></th>
                      <th></th>
                      <th class="select-filter"></th>
                      <th  class="select-filter"></th>
                      <th></th>
                     
                  </tr>
                  <tr>
                      <th scope="col" class="text-center">Type</th>
                      <th scope="col" class="text-center">Application Code</th>
                      <th scope="col" class="text-center">Name of Health Facility</th>
                      <th scope="col" class="text-center">Type of Health Facility</th>
                      <th scope="col" class="text-center">Date</th>
                      <th scope="col" class="text-center">{{-- &nbsp; --}}Application Status</th>
                      <th scope="col" class="text-center">Current Status</th>
                      <th scope="col" class="text-center">Options</th>
                  </tr>
                  </thead>
                  <tbody id="FilterdBody">
                      @if (isset($BigData))
                        @foreach ($BigData as $data)
                          <!-- if($data->isPayEval == 1 && $data->isrecommended == 1 && $data->isCashierApprove == 1 && $data->isInspected == null && in_array($data->hfser_id, ['LTO','COA']) && $data->proposedWeek != null && AjaxController::canProcessNextStepFDA($data->appid,'isCashierApproveFDA','isCashierApprovePharma')) -->
                          @if($data->isPayEval == 1  && $data->isCashierApprove == 1 && $data->isInspected == null && in_array($data->hfser_id, ['LTO','COA', 'ATO', 'COR']) && $data->proposedWeek != null && AjaxController::canProcessNextStepFDA($data->appid,'isCashierApproveFDA','isCashierApprovePharma'))
                         @php
                            $status = '';
                            $paid = $data->appid_payment;
                            $reco = $data->isrecommended;
                            $ifdisabled = '';$color = '';

                            // if($currentuser['cur_user'] != 'ADMIN' && !FunctionsClientController::existOnDB('app_team',[['appid',$data->appid],['uid',$currentuser['cur_user']]])){
                             // continue;
                            //}

                            // if ($data->isInspected == null ) {
                            //       $OptBtn = "<button type=\"button\" title=\"Assess ".$data->facilityname."\" class=\"btn-defaults\" onclick=\"window.location.href=\"".asset('employee/dashboard/lps/assess')."/".$data->appid."/inspect\"  ".$ifdisabled."><i class=\"fa fa-fw fa-clipboard-check\"></i></button>";
                            //   } else {
                            //       $OptBtn = "<button type\"button\" title=\"View ".$data->facilityname."\" class=\"btn-defaults\" onclick=\"window.location.href=\'".asset('employee/dashboard/lps/assess')."/".$data->appid."/view\"  ".$ifdisabled."><i class=\"fa fa-fw fa-clipboard-check\"></i></button>";
                            //   }
                          @endphp
                          <tr>
                            <td class="text-center">{{$data->hfser_id}}</td>
                            <td class="text-center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                            <td class="text-center"><strong>{{$data->facilityname}}</strong></td>
                            <td class="text-center">{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($data->appid)->hgpdesc ?? 'NOT FOUND')}}</td>
                            <td class="text-center">{{$data->formattedDate}}</td>
                            <td class="text-center">{{$data->aptdesc}}</td>
                            <td style="color:{{$color}};font-weight:bold;" class="text-center">{{$data->trns_desc}}</td>
                              <td>
                              	<center>
                                  <button type="button" title="Assess {{$data->facilityname}}" class="btn btn-outline-primary" onclick="window.location.href='{{asset('employee/dashboard/processflow/parts')}}/{{$data->appid}}'"><i class="fa fa-fw fa-clipboard-check"></i></button>
                            	</center>
                              </td>
                          </tr>
                          @endif
                        @endforeach
                      @endif
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){
    

$.fn.dataTable.ext.search.push(
  function (settings, data, dataIndex) {
      var min = $('#min').datepicker('getDate');
      var max = $('#max').datepicker('getDate');
      var startDate = new Date(data[4]);
      if (min == null && max == null) return true;
      if (min == null && startDate <= max) return true;
      if (max == null && startDate >= min) return true;
      if (startDate <= max && startDate >= min) return true;
      return false;
  }
);

$('#min').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
$('#max').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });




var table = $('#example').DataTable();
$("#example thead .select-filter").each( function ( i ) {
      var e = i == 0 ? 3 : i == 1 ? 5 : 6;
        var select = $('<select><option value=""></option></select>')
            .appendTo( $(this).empty() )
            // .appendTo( $(this).empty() )
            .on( 'change', function () {
                table.column( e )
                    .search( $(this).val() )
                    .draw();
            } );
 
        table.column(e).data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        } );


    } );
 $('#min, #max').change(function () {
        table.draw();
    });
  	});
  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif