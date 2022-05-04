@if (session()->exists('employee_login'))  
  @extends('mainEmployee')
  @section('title', 'Evaluate Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF002">
  <div class="content p-4">
  	<div class="card">
  		<div class="card-header bg-white font-weight-bold">
        {{$type == 'technical' ? 'Technical' : 'Documentary'}}  Evaluation  @include('employee.tableDateSearch')
          </div>
         {{-- @if($type != 'technical')  --}}
          <div  class="card-header bg-white text-center">
              <span class=" font-weight-bold">Legend:</span> <span class=" font-weight-bold">Gray Background </span>= Not yet Viewed/Not yet Opened Document(s).  <span class=" font-weight-bold">White Background</span> = Viewed/Opened Document(s).
          </div>
          {{-- @endif --}}
          
          <div class="card-body table-responsive">
         
          	<table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
                  <tr>
                      <th class="select-filter"></th>
                      <th class="select-filter"></th>
                      <th ></th>
                      <th ></th>
                      <th  class="select-filter"></th>
                      <th></th>
                      <th class="select-filter"></th>
                      <th ></th>
                     
                  </tr>
                  <tr>
                      <!-- <td scope="col" class="text-center"></td> -->
                      <td scope="col" class="text-center">Process</td>
                      <td scope="col" class="text-center">Type</td>
                      <td scope="col" class="text-center">Application Code</td>
                      <td scope="col" class="text-center">Name of Facility</td>
                      <td scope="col" class="text-center">Type of Facility</td>
                      <td scope="col" class="text-center">Last Updated On</td>
                      {{-- <th scope="col" class="text-center">&nbsp;</td> --}}
                      <td scope="col" class="text-center">Current Status</td>
                      <td scope="col" class="text-center">Options</td>
                  </tr>
                  </thead>

                  <!--{{-- @if(!in_array($data->isrecommended, [2,null]))
                             continue
                              @endif --}} -->

                              <!-- {{-- if($data->isAcceptedFP == 1 && !in_array($data->isrecommended, [2]))
                                 continue
                              endif --}} -->
                  <tbody id="FilterdBody">
              
                   @if (isset($BigData))
                        @foreach ($BigData as $data)
                          @if($data->isCashierApprove == 1)   
                          {{-- @if(true) --}}
                        @if( $data->aptid == 'R' || $data->isReadyForInspec == 1 || $data->isrecommended == 2  &&  (isset($data->isCashierApprove) && $data->isCashierApprove == 1 ) )
                            
                            @if(strtolower($data->hfser_id) == 'ptc' )
                  
                            @else
                                  <!-- Place the  data->isrecommended [2,null] here-->
                            @endif

                            @php
                              $status = '';
                              $paid = $data->appid_payment;
                              $reco = $data->isrecommended;
                              $ifdisabled = '';$color = '';
                            @endphp

                             @if($data->status == 'A' )
                             <?php continue; ?>
                              @endif

                            @if($data->isrecommended == 1 && strtolower($data->hfser_id) != 'lto')
                          {{--  @if($data->isrecommended == 1 ) --}}
                                <?php continue; ?>
                              @endif

                              @if(strtolower($data->hfser_id) == 'con' && $data->isrecommended == 2 && $data->status == 'REV')
                              
                              <?php continue; ?>
                              
                              @endif

                           @if(strtolower($data->hfser_id) == 'ptc' && $data->isReadyForInspec == 0 && $data->status == 'REV')
                              <?php  continue; ?>
                            @endif

                             {{--  @if($data->aptid == 'R' || $data->hasAssessors == 'T' || strtolower($data->hfser_id) != 'lto')--}}
                            @if($data->hasAssessors == 'T' || strtolower($data->hfser_id) != 'lto')

                            <tr @if(!isset($data->documentSent) || $data->isrecommended == 2)style="background-color: #c4c1bb";@endif>
                              <!-- <td class="text-center">{{$data->isCashierApprove}}</td> -->
                              <td class="text-center">@if($data->aptid == 'R'){{'Renewal'}}@elseif($data->aptid == 'IN'){{'Initial New'}}@else{{'Unidentified'}}@endif</td>
                              <td class="text-center">{{$data->hfser_id}}</td>
                              <td class="text-center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                              <td class="text-center"><strong>{{$data->facilityname}}</strong></td>
                              <td class="text-center">{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($data->appid)->hgpdesc ?? 'NOT FOUND')}}</td>
                              <td class="text-center">{{$data->formattedUpdatedDate}}</td>
                              {{-- <td class="text-center">{{$data->aptdesc}}</td> --}}
                              <td class="text-center" style="font-weight:bold;">{{$data->trns_desc}}</td>
                                <td>
                                  <center>
                                    @if(!isset($data->documentSent))
                                      <button type="button" title="Evaluate {{$data->facilityname}}" class="btn btn-outline-primary ml-3 pb-2 pt-2 mt-2 mb-2 font-weight-bold" onclick="acceptDocu({{$data->appid}})"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>&nbsp;
                                      {{-- <button type="button" title="Edit {{$data->facilityname}}" class="btn btn-outline-warning ml-3 pb-2 pt-2 mt-2 mb-2 font-weight-bold" onclick="window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/{{$data->appid}}/edit'"  {{$ifdisabled}}><i class="fa fa-fw fa-edit" {{$ifdisabled}}></i></button> --}}

                                      {{-- for documentary evaluation  --}}
                                    @else Documentary
                                      <button type="button" title="Evaluate {{$data->facilityname}}" class="btn btn-outline-primary ml-3 pb-2 pt-2 mt-2 mb-2 font-weight-bold" onclick="window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/{{$data->appid}}/{{'hfsrb'}}/{{$isdocumentary}}'"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>&nbsp;
                                    {{-- <button type="button" title="Edit {{$data->facilityname}}" class="btn btn-outline-warning ml-3 pb-2 pt-2 mt-2 mb-2 font-weight-bold" onclick="window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/{{$data->appid}}/edit'"  {{$ifdisabled}}><i class="fa fa-fw fa-edit" {{$ifdisabled}}></i></button> --}}
                                    @endif
                                </center>
                              </td>
                            </tr>

                              @endif

                            {{-- @endif --}}
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
      var e = i == 0 ? 0 : i == 1 ? 1 : i == 2 ? 3 : 5;
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
            Swal.fire({
              title: 'You are about to View this documents',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirm!'
            }).then((result) => {
              if (result.value) {
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
                      window.location.href = '{{ asset('/employee/dashboard/processflow/evaluate') }}/'+id;
                    });
                  }
                })
              }
            })
       }
  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css" />
