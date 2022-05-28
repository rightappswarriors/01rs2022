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
      Attachment / 
      <a href="{{asset('employee/dashboard/processflow/complianceremarks/')}}/{{$complianceId}}"> Remarks </a> / 

       
      </div>
        
          
          <div class="card-body table-responsive">


          	<table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
              
                  <tr>
                      <!-- <td scope="col" class="text-center"></td> -->
                      <td scope="col" class="text-center">Timestamp</td>
                      <td scope="col" class="text-center">File Name</td>
                      <td scope="col" class="text-center">Description</td>
                      <td scope="col" class="text-center">Type</td>
                      <td scope="col" class="text-center">Uploaded By</td>
                      <td scope="col" class="text-center">Action</td>
                  </tr>
                  </thead>

        
                  <tbody id="FilterdBody">
              
                   @if (isset($BigData))
                      @foreach ($BigData as $index => $data)
                      
                          <tr>
                            <td class="text-center">{{$data->date_submitted}}</td>
                            <td class="text-center">{{$data->attachment_name}}</td>
                            <td class="text-center">{{$data->description}}</td>
                            <td class="text-center">{{$data->type}}</td>
                            <td class="text-center">{{$data->fname}} {{$data->lname}}</td>
                           
                            <td>

                            <a href="#" class="btn btn-primary"> 
                            <i class="fa fa-fw fa-eye"></i>
                            </td>
                            <a href="#" class="btn btn-success"> 
                            <i class="fa fa-fw fa-download"></i>
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


      jQuery('.complianceChecker').click(function(e){
           e.preventDefault();
      });




    });

    function complianceChecker(id, assesment_status, appid){
            
    if(assesment_status == 1){
        $text = 'Are you sure you want to complied this item?';
    } else {
        $text = 'Are you sure you want to set this for Compliance?';
    }

    

    

            Swal.fire({
              title: 'Please review Compliance Item',
              text: $text,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirm!'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  url: '{{asset('employee/dashboard/processflow/complianceChecker/')}}/'+id+'/'+assesment_status,
                  type: 'GET',
                  success: function(){
                    Swal.fire({
                      type: 'success',
                      title: 'Success',
                      text: 'Successfully Updated Compliance',
                      timer: 2000,
                    }).then(() => {
                        location.reload();
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
