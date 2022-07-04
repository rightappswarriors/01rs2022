
<script src="//cdn.datatables.net/plug-ins/1.10.24/filtering/row-based/range_dates.js"></script>
<script src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>

@if (session()->exists('employee_login'))   
  @extends('mainEmployee')
  @section('title', 'View Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF001">
  <div class="content p-4" style="font-size:13px; margin-left:0px;" >
  	<div class="card" >
   
  		<div class="card-header bg-white font-weight-bold">
             Application Status  @include('employee.tableDateSearch')
      </div>
      <div class="card-body table-responsive">
        <div  >   

          <table class="table table-hover" style="font-size:13px;" id="example">
            <thead>
              <tr>
                  <th ></th>
                  <th class="select-filter"></th>
                  <th ></th>
                  <th ></th>
                  <th class="select-filter"></th>
                  <th class="select-filter"></th>
                  <th ></th>
                  <th></th>
                  <th ></th>
                  <th ></th>
                  <th ></th>
                  <th class="select-filter"></th>
                  <th></th>
                  
              </tr>
              <tr>
                  <td scope="col" style="text-align: center;">Options</td>
                  <td scope="col" style="text-align: center;">Type</td>
                  <td scope="col" style="text-align: center;">Code</td>
                  <td scope="col" style="text-align: center;">Name of the Facility</td>
                  <td scope="col" style="text-align: center;">Type of Facility</td>
                  <td scope="col" style="text-align: center;">Type</td>
                  <td scope="col" style="text-align: center;">Date Applied</td>
                  {{-- <td scope="col" style="">Paid</td> --}}
                  <td scope="col" style="text-align: center;">Status</td>
                  <td scope="col" style="text-align:center">Evaluated</td>
                  {{-- <td scope="col" style="">Evaluated by</td> --}}
                  {{-- <td scope="col" style="">Region Evaluated</td> --}}
                  <td scope="col" style="text-align: center;">Inspected</td>
                  <td scope="col" style="text-align: center;">Approved</td>
                  <td scope="col" style="text-align: center;">Region</td>
                  <td scope="col" style="text-align: center;">Assigned Region Office</td>
                  
                  {{-- <td scope="col" style="">Current Status</td> --}}
                  
              </tr>
            </thead>
            <tbody id="FilterdBody">
              @if (isset($LotsOfDatas))
                @foreach ($LotsOfDatas as $data)
                  @if(in_array($data->hfser_id, $serv))

                    <tr>
                      <td>
                        <center>
                          <button type="button" title="View detailed information for {{$data->facilityname}}" class="btn btn-outline-info" onclick="showData({{$data->appid}},'{{$data->aptdesc}}', '{{$data->authorizedsignature}}','{{$data->brgyname}}', '{{$data->classname}}' ,'{{$data->cmname}}', '{{$data->email}}', '{{$data->facilityname}}','{{$data->hgpdesc}}', '{{$data->formattedDate}}', '{{$data->formattedTime}}', '{{$data->hfser_desc}}','{{$data->ocdesc}}', '{{$data->provname}}','{{$data->rgn_desc}}', '{{$data->streetname}}', '{{$data->zipcode}}', '{{$data->isrecommended}}', '{{$data->hfser_id}}', '{{$data->status}}', '{{$data->uid}}', '{{$data->trns_desc}}');" data-toggle="modal" data-target="#GodModal"><i class="fa fa-fw fa-eye"></i></button>
                        </center>
                      </td>
                      <td style="text-align:center">{{$data->hfser_id}}</td>
                      <td style="text-align:center">{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}</td>
                      <td style="text-align:center"><strong>{{$data->facilityname}}</strong></td>
                      <td style="text-align:center">{{(ajaxController::getFacilitytypeFromHighestApplicationFromX08FT($data->appid)->hgpdesc ?? 'NOT FOUND')}}</td>
                      <td style="text-align:center">{{$data->aptdesc}}</td>
                      <td style="text-align:center">@if(isset($data->t_date)){{date("F j, Y", strtotime($data->created_at)) }} @else {{ 'Not Officially Applied Yet' }} @endif </td>
                      <td style="color:black;font-weight:bolder;text-align:center;">{{$data->trns_desc}}</td>
                      <td>
                        <center> {{-- EVALUATION --}}
                          <h5>
                            @if($data->isrecommended == 1) 
                            <span class="badge  badge-success" title="Click for more info" style="cursor:pointer;" data-toggle="modal" data-target="#ShowEvalInfo" onclick="showEvalInfo('{{$data->formattedTimeEval}}', '{{$data->formattedDateEval}}', '{{$data->formattedTimePropEval}}', '{{$data->formattedDatePropEval}}', '{{$data->recommendedbyName}}', '{{$data->hfser_id}}R{{$data->rgnid}}-{{$data->appid}}', {{$data->appid}})">Yes</span> 
                            @elseif($data->isrecommended == null) 
                              <span class="badge badge-warning">Pending</span> 
                            @else 
                              <span class="badge badge-danger">No</span> 
                            @endif
                          </h5>
                        </center>
                      </td>
                      <td>
                        <center> {{-- INSPECTION --}}
                          <h5>
                            @if ($data->isInspected != null)
                              <span class="badge badge-success">Yes</span>
                            @else 
                              <span class="badge badge-warning">{{$data->hfser_id == 'CON' ? 'N/A' : 'Pending'}}</span>
                            @endif
                          </h5>
                        </center>
                      </td>
                      <td>
                        <center> {{-- APPROVED --}}
                          <h5>
                            @if ($data->isApprove == '1')
                              <span class="badge badge-success">Yes</span>
                            @elseif($data->isApprove == '0')
                              <span class="badge badge-danger">No</span>
                            @else
                              <span class="badge badge-warning">Pending</span>
                            @endif
                          </h5>
                        </center>
                      </td>
                      <td style="text-align:center">{{$data->rgn_desc}}</td>
                      <td style="text-align:center">{{$data->asrgn_desc}}</td>
                    </tr>

                  @endif
                @endforeach
              @endif 
            </tbody>
          </table>

        </div>
      </div>
  	</div>
  </div>
  <div class="modal fade" id="GodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog {{-- modal-lg --}}" role="document">
        <div class="modal-content" style="border-radius: 0px;border: none;">
          <div class="modal-body" style=" background-color: #272b30;color: white;">
            <h5 class="modal-title text-center"><strong>View Application</strong></h5>
            <hr>
            <div class="container">
                  <form id="ViewNow" data-parsley-validate>
                  <span id="ViewBody">
                  </span>
                  <hr>
                  <div class="row">
                    <div class="col-sm-6">
                      &nbsp;
                    {{-- <button type="button" class="btn btn-outline-info form-control" id="PreAssessButton" style="border-radius:0;"><span class="fa fa-sign-up"></span>View Preassessment</button> --}}
                  </div> 
                  <div class="col-sm-6">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger form-control" style="border-radius:0;"><span class="fa fa-sign-up"></span>Cancel</button>
                  </div>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="modal fade" id="ShowEvalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog {{-- modal-lg --}}" role="document">
        <div class="modal-content" style="border-radius: 0px;border: none;">
          <div class="modal-body text-justify" style=" background-color: #272b30;color: white;">
            <h5 class="modal-title text-center"><strong><span id="EvalTitle"></span> Evaluation</strong></h5>
            <hr>
            <div class="container">
                  <form id="" data-parsley-validate>
                  <span id="EvalBody">
                  </span>
                  <hr>
                  <div class="row">
                    <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-info form-control" style="border-radius:0;" id="ViewEvalButton"><span class="fa fa-sign-up"></span>View Evaluation</button>
                  </div> 
                  <div class="col-sm-6">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger form-control" style="border-radius:0;"><span class="fa fa-sign-up"></span>Cancel</button>
                  </div>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <script type="text/javascript">
/* Custom filtering function which will search data in column four between two values */

var minDate, maxDate;
 
 // Custom filtering function which will search data in column four between two values
//  $.fn.dataTable.ext.search.push(
//      function( settings, data, dataIndex ) {
//        console.log("neww")
     
//      if(isNaN($("#min").val())  && isNaN($("#max").val())) {  
//         var min =new Date( $("#min").val() );
      

//       var max = new Date( $("#max").val() );
//          var date = new Date( data[5] );
         
//          if (
//              ( min === null && max === null ) ||
//              ( min === null && date <= max ) ||
//              ( min <= date   && max === null ) ||
//              ( min <= date   && date <= max )
//          ) {
//           console.log(data)
//              return true;
//          }
//         }
//           return false;
        

        
//      }
//  );
// var minDate, maxDate;
 
 // Custom filtering function which will search data in column four between two values
//  $.fn.dataTable.ext.search.push(
//      function( settings, data, dataIndex ) {
//          var min = minDate.val();
//          var max = maxDate.val();
//          var date = new Date( data[5] );
  
//          if (
//              ( min === null && max === null ) ||
//              ( min === null && date <= max ) ||
//              ( min <= date   && max === null ) ||
//              ( min <= date   && date <= max )
//          ) {
//              return true;
//          }
//          return false;
//      }
//  );
  
  
  
  	$(document).ready(function() {

    //   minDate = new Date($('#min'), {
    //     format: 'MMMM Do YYYY'
    // });
    // maxDate = new Date($('#max'), {
    //     format: 'MMMM Do YYYY'
    // });
 
    
 // Create date inputs
//  minDate = new DateTime($('#min'), {
//         format: 'MMMM Do YYYY'
//     });
//     maxDate = new DateTime($('#max'), {
//         format: 'MMMM Do YYYY'
//     });

$.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker('getDate');
            var max = $('#max').datepicker('getDate');
            var startDate = new Date(data[6]);
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
      var e = i == 0 ? 1 : i == 1 ? 4 : i == 2 ? 5 : 11;
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
     // Event listener to the two range filtering inputs to redraw on input
    //  $('#min, #max').on('change', function () {
    //     table.draw();
    // });
    $('#min, #max').change(function () {
        table.draw();
    });

    });


    
  	function showData(appid, aptdesc, authorizedsignature, brgyname, classname, cmname, email, facilityname, facname, formattedDate, formattedTime, hfser_desc, ocdesc, provname, rgn_desc, streetname, zipcode, isrecommended, hfser_id, statusX, uid, trns_status){
          var status = '';
          // var paid = appid_payment;
          // if (statusX == 'P') {
          //     status = '<span style="color:orange">Pending</span>';
          // } 
          $('#PreAssessButton').attr('onclick', '');
          $('#PreAssessButton').attr('onclick', "location.href='{{ asset('/employee/dashboard/lps/preassessment') }}/"+uid+"'");
          $('#ViewBody').empty();
          $('#ViewBody').append(
              '<div class="row">'+
                  '<div class="col-sm-4">Facility Name:' +
                  '</div>' +
                  '<div class="col-sm-8">' + facilityname +
                  '</div>' +
              '</div>' +
              // '<br>' + 
              '<div class="row">'+
                  '<div class="col-sm-4">Address:' +
                  '</div>' +
                  '<div class="col-sm-8">' + streetname + ', ' + brgyname + ', ' + cmname + ', ' + provname + ' - ' + zipcode +
                  '</div>' +
              '</div>' +
              '<div class="row">'+
                  '<div class="col-sm-4">Owner:' +
                  '</div>' +
                  '<div class="col-sm-8">' + authorizedsignature + 
                  '</div>' +
              '</div>' +
              '<div class="row">'+
                  '<div class="col-sm-4">Applying for:' +
                  '</div>' +
                  '<div class="col-sm-8">' + hfser_id + ' ('+hfser_desc+') - ' + aptdesc +
                  '</div>' +
              '</div>' +
              '<div class="row">'+
                  '<div class="col-sm-4">Time and Date:' +
                  '</div>' +
                  '<div class="col-sm-8">' + formattedTime + ' - ' + formattedDate +
                  '</div>' +
              '</div>' +
              '<div class="row">'+
                  '<div class="col-sm-4">Status:' +
                  '</div>' +
                  '<div class="col-sm-8">' +trns_status +
                  '</div>' +
              '</div>'
            );
      }
      function showEvalInfo(EvalTime, EvalDate, PropTime, PropDate, RecommendedBy/*, RgnRecommended*/, code, idCode){
          $('#ViewEvalButton').attr('onclick','');
          $('#ViewEvalButton').attr('onclick',"location.href='{{ asset('/employee/dashboard/processflow/evaluate') }}/"+idCode+"'");
          $('#EvalTitle').empty();
          $('#EvalTitle').text(code);
          $('#EvalBody').empty();
          $('#EvalBody').append(
                '<div class="row">'+
                    '<div class="col-sm-5">Evaluated On:</div>' +
                    '<div class="cols-sm-7" style="font-weight:bold">' + EvalDate + ' ' + EvalTime +
                    '</div>' + 
                '</div>'  +
                '<div class="row">'+
                    '<div class="col-sm-5">Recommended By:</div>' +
                    '<div class="cols-sm-7" style="font-weight:bold">' + RecommendedBy +
                    '</div>' + 
                '</div>' +
                // '<div class="row">'+
                //     '<div class="col-sm-5">Region Evaluated:</div>' +
                //     '<div class="cols-sm-7" style="font-weight:bold">' + RgnRecommended +
                //     '</div>' + 
                // '</div>' +
                '<div class="row">'+
                    '<div class="col-sm-5">Proposed Inspection:</div>' +
                    '<div class="cols-sm-7" style="font-weight:bold">' + PropDate + ' ' + PropTime +
                    '</div>' + 
                '</div>'
            );
      }
  </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css" />


<!-- https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js -->