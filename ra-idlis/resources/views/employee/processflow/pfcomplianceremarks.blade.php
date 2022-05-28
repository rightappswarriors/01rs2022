@if (session()->exists('employee_login'))  
  @extends('mainEmployee')
  @section('title', 'Evaluate Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF002">
  <div class="content p-4">
  	<div class="card">
  		<div class="card-header bg-white font-weight-bold">


      <div class="card-header bg-white font-weight-bold">
      <a href="{{asset('employee/dashboard/processflow/compliancedetails/')}}/{{$complianceId}}"> For Compliance Details</a> / 
      <a href="{{asset('employee/dashboard/processflow/complianceattachment/')}}/{{$complianceId}}"> Attachment</a> / 
         Remarks / 

       
      </div>
        
          
          <div class="card-body table-responsive">


          	<table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
              
                  <tr>
                      <td scope="col" class="text-center">Timestamp</td>
                      <td scope="col" class="text-center">From</td>
                      <td scope="col" class="text-center">Message</td>
                  </tr>
                  </thead>

        
                  <tbody id="FilterdBody">
              
                   @if (isset($BigData))
                      @foreach ($BigData as $index => $data)
                      
                          <tr>
                            <td class="text-center">{{$data->remarks_date}}</td>
                            <td class="text-center">{{$data->fname}} {{$data->lname}}</td>
                            <td class="text-center">{{$data->message}}</td>
                 
                            </td>
        
                 
                          
                          </tr>

                      @endforeach
                    @endif
                  </tbody>
              </table>
          </div>
  	</div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){

      var table = $('#example').DataTable();


 
    });



    
    </script>
  @endsection
@else
  <script type="text/javascript">window.location.href= "{{ asset('employee') }}";</script>
@endif

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css" />
