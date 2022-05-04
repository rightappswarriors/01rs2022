@if (session()->exists('employee_login'))   
  @extends('mainEmployee')
  @section('title', 'Approval/Issuance Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF007">
  <div class="content p-4">
      <div class="card">
          <div class="card-header bg-white font-weight-bold">
             Approval/Issuance Certificate     @include('employee.tableDateSearch')
          </div>
          <div class="card-body table-responsive">
        
            @php
              $lname = preg_replace('/\s*/', '', $uilastname);
              $lname = strtolower($lname);

              $position = preg_replace('/\s*/', '', $uiposition);
              $position = strtolower($position);
            @endphp          
            
              <table class="table table-hover" id="example" style="font-size:13px;">
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
                      <th scope="col" class="text-center">Application Status</th>
                      <th scope="col" class="text-center">Current Status</th>
                      <th scope="col" class="text-center">Options</th>
                  </tr>
                  </thead>
                  <tbody id="FilterdBody">
                      @if (isset($BigData))
                        @foreach ($BigData as $data)
                          @if($data->isRecoForApproval !== null && $data->isApprove == null)
                            @php
                              $status = '';
                              $paid = $data->appid_payment;
                              $reco = $data->isrecommended;
                              $ifdisabled = '';$color = '';
                              
                              if($data->status == 'P' || $data->status == 'RA' || $data->status == 'RE' || $data->status == 'RI' ){
                                $ifdisabled = 'disabled';
                              }
                            @endphp

                            <tr>
                              <!-- <td class="text-center">{{$data->pbedcap}}</td> -->
                              <td class="text-center">{{$data->hfser_id}}</td>
                              <td class="text-center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                              <td class="text-center"><strong>{{$data->facilityname}}</strong></td>
                              <td class="text-center">{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($data->appid)->hgpdesc ?? 'NOT FOUND')}}</td>
                              <td class="text-center">{{$data->formattedDate}}</td>
                              <td class="text-center">{{$data->aptdesc}}</td>
                              <td class="text-center" style="font-weight:bold;">{{$data->trns_desc}}</td>
                                <td><center>
                                    <button type="button" title="Evaluate Payment for {{$data->facilityname}}" class="btn btn-outline-primary" onclick="window.location.href='{{asset('employee/dashboard/processflow/approval')}}/{{$data->appid}}'"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>
                                </center></td>
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
  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif
