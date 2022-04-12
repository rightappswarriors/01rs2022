@if (session()->exists('employee_login'))   
  @extends('mainEmployee')
  @section('title', 'Fail Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF008">
  <div class="content p-4">
      <div class="card">
          <div class="card-header bg-white font-weight-bold">
             Failed Applications @include('employee.tableDateSearch')
          </div>
          <div class="card-body table-responsive">
          
              <table class="table table-hover"  id="example" style="font-size:13px;">
                  <thead>
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
                        @if($data->status == 'RA' || $data->status == 'RE' || $data->status == 'RI')
                        @php
                          $status = '';
                          $paid = $data->appid_payment;
                          $reco = $data->isrecommended;
                          $ifdisabled = '';$color = '';
                          
                          // if($data->status == 'P' || $data->status == 'RA' || $data->status == 'RE' || $data->status == 'RI' ){
                          //   $ifdisabled = 'disabled';
                          // }

                        @endphp
                        <tr>
                          <td class="text-center">{{$data->hfser_id}}</td>
                          <td class="text-center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                          <td class="text-center"><strong>{{$data->facilityname}}</strong></td>
                          <td class="text-center">{{$data->hgpdesc}}</td>
                          <td class="text-center">{{$data->formattedDate}}</td>
                          <td class="text-center">{{$data->aptdesc}}</td>
                          <td class="text-center" style="font-weight:bold;">{{$data->trns_desc}}</td>
                            <td><center>
                                <button type="button" title="View information for {{$data->facilityname}}" class="btn btn-outline-primary" onclick="window.location.href='{{ asset('employee/dashboard/processflow/failed') }}/{{$data->appid}}'"  {{$ifdisabled}}><i class="fa fa-fw fa-clipboard-check" {{$ifdisabled}}></i></button>
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
  	});

    $('#min, #max').change(function () {
        table.draw();
    });

  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif
