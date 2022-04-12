@if (session()->exists('employee_login'))  
  @extends('mainEmployee')
  @section('title', 'Evaluate Process Flow')
  @section('content')
  {{-- <input type="text" id="CurrentPage" hidden="" value="FD002"> --}}
  <div class="content p-4">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
             Evaluate Applicant ({{$request =='machines' ? 'Radiation Facility' : 'Pharmacy'}}) @include('employee.tableDateSearch')
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
                  <tr>
                      <th class="select-filter" ></th>
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
                      <th scope="col" class="text-center">Name of Facility</th>
                      <th scope="col" class="text-center">Type of Facility</th>
                      <th scope="col" class="text-center">Date</th>
                      <th scope="col" class="text-center">&nbsp;</th>
                      <th scope="col" class="text-center">Current Status</th>
                      <th scope="col" class="text-center">Options</th>
                  </tr>
                  </thead>
                  <tbody id="FilterdBody">
                   @if (isset($BigData))
                        @foreach ($BigData as $data)
                        
                        
                                @php
                                $preassess = (strtolower($request) == 'machines' ? $data->ispreassessed : $data->ispreassessedpharma);
                                $oop = (strtolower($request) == 'machines' ? $data->isPayEvalFDA : $data->isPayEvalFDAPharma);
                                $eval = (strtolower($request) == 'machines' ? $data->isrecommendedFDA : $data->isrecommendedFDAPharma);
                                $cashier = (strtolower($request) == 'machines' ? $data->isCashierApproveFDA : $data->isCashierApprovePharma);
                                @endphp
                              @if($data->isRecoDecision == 'Return for Correction' || $eval == null || $eval == 2 || ($request != 'machines' && FunctionsClientController::existOnDB('cdrrpersonnel',[['appid',$data->appid],['isTag',1]])) )
                                @if(in_array(strtolower($data->hfser_id), ['lto','coa']) && $data->isReadyForInspecFDA == 1 && $oop == 1 && $cashier == 1 && $preassess == 1)
                                  @php
                                    $toCheck = ($request == 'machines' ? 'cdrrhr' : 'cdrr');
                                  @endphp
                                  @if(!FunctionsClientController::hasRequirementsFor($toCheck,$data->appid))
                                  @php continue; @endphp
                                  @endif

                                  @php
                                    $status = '';
                                    $paid = $data->appid_payment;
                                    $reco = $data->isrecommended;
                                    $ifdisabled = '';$color = '';
                                    // if($data->status == 'P'){
                                    //   $ifdisabled = 'disabled';
                                    // }
                                  @endphp
                                  <tr>
                                    <td class="text-center">{{$data->hfser_id}}</td>
                                    <td class="text-center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                                    <td class="text-center"><strong>{{$data->facilityname}}</strong></td>
                                    <td class="text-center">{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($data->appid)->hgpdesc ?? 'NOT FOUND')}}</td>
                                    <td class="text-center">{{$data->formattedDate}}</td>
                                    <td class="text-center">{{$data->aptdesc}}</td>
                                    @php
                                $status = (strtolower($request) == 'machines' ? $data->FDAStatMach : $data->FDAStatPhar)
                            @endphp
                            <td class="text-center" style="font-weight:bold;">{{$status}}</td>
                                    <!-- <td class="text-center" style="font-weight:bold;">{{(AjaxController::getTransStatusById($data->FDAstatus)[0]->trns_desc ?? '')}}</td> -->
                                      <td>
                                        <center>
                                          @if(!isset($data->documentSent))
                                            <button type="button" title="Evaluate {{$data->facilityname}}" class="btn btn-outline-primary" onclick="acceptDocu({{$data->appid}})"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>&nbsp;
                                            {{-- <button type="button" title="Edit {{$data->facilityname}}" class="btn btn-outline-warning" onclick="window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/{{$data->appid}}/edit'"  {{$ifdisabled}}><i class="fa fa-fw fa-edit" {{$ifdisabled}}></i></button> --}}
                                          @else
                                            <button type="button" title="Evaluate {{$data->facilityname}}" class="btn btn-outline-primary" onclick="window.location.href = '{{ asset('employee/dashboard/processflow/evaluate/FDA/') }}/{{$data->appid}}/{{$request}}'"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>&nbsp;
                                          {{-- <button type="button" title="Edit {{$data->facilityname}}" class="btn btn-outline-warning" onclick="window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/{{$data->appid}}/edit'"  {{$ifdisabled}}><i class="fa fa-fw fa-edit" {{$ifdisabled}}></i></button> --}}
                                          @endif
                                      </center>
                                    </td>
                                  </tr>
                                  @endif
                                @endif

                          
                          
                        @endforeach
                      @endif
                  </tbody>
              </table>
          </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {

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
      var e =i == 0 ? 0: i == 1 ? 3 : i == 2 ? 5 : 6;
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
    function acceptDocu(id){
      // Swal.fire({
      //   title: 'You are about to View this documents and timeclock will start',
      //   text: "You won't be able to revert this!",
      //   type: 'warning',
      //   showCancelButton: true,
      //   confirmButtonColor: '#3085d6',
      //   cancelButtonColor: '#d33',
      //   confirmButtonText: 'Confirm!'
      // }).then((result) => {
      //    $.ajax({
      //       url: '{{asset('employee/dashboard/processflow/evaluate/')}}/'+id,
      //       type: 'POST',
      //       data: {_token: $('#token').val(),checkFiles: true},
      //       success: function(){
      //         Swal.fire({
      //           type: 'success',
      //           title: 'Success',
      //           text: 'Successfully Accepted Documents',
      //           timer: 2000,
      //         }).then(() => {
      //           window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate/FDA') }}/'+id;
      //         });
      //       }
      //     })
      //  }) 
       
      $.ajax({
            url: '{{asset('employee/dashboard/processflow/evaluate/')}}/'+id,
            type: 'POST',
            data: {_token: $('#token').val(),checkFiles: true},
            success: function(){
              Swal.fire({
                type: 'success',
                title: 'Success',
                text: 'Successfully Accepted Documents',
                timer: 2000,
              }).then(() => {
                window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate/FDA') }}/'+id+ '/{{$request}}';
                // window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate/FDA') }}/'+id;
              });
            }
          })



    }
  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif
