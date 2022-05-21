@if (session()->exists('employee_login'))  
  @extends('mainEmployee')
  @section('title', 'Evaluate Process Flow')
  @section('content')
  <input type="text" id="CurrentPage" hidden="" value="PF002">
  <div class="content p-4">
  	<div class="card">
  		<div class="card-header bg-white font-weight-bold">
        For Compliance Details
      </div>
        
          
          <div class="card-body table-responsive">


          	<table class="table table-hover" style="font-size:13px;" id="example">
                  <thead>
              
                  <tr>
                      <!-- <td scope="col" class="text-center"></td> -->
                      <td scope="col" class="text-center">ID</td>
                      <td scope="col" class="text-center">For Compliance</td>
                      <td scope="col" class="text-center">Area of Concern</td>
                      <td scope="col" class="text-center">Complied?</td>
                  </tr>
                  </thead>

        
                  <tbody id="FilterdBody">
              
                   @if (isset($BigData))
                      @foreach ($BigData as $index => $data)
                      
                          <tr>
                            <td class="text-center">{{$index}}</td>
                            <td class="text-center">{!!$data->assessmentName!!}</td>
                            <td class="text-center">
                            {!!$data->h1name!!}
                            <br>
                            {!!$data->h2name!!}
                            <br>
                            {!!$data->h3name!!}
                            </td>
                            <td>

                            <input type="checkbox" value="0" class="complianceChecker" {{$data->assesment_status == 0 ? 'checked' : '' }} onclick="complianceChecker({{$data->compliance_item_id}}, 0, {{$data->compliance_id}})"> No
                            <input type="checkbox" value="1" class="complianceChecker" {{$data->assesment_status == 1 ? 'checked' : '' }} onclick="complianceChecker({{$data->compliance_item_id}}, 1, {{$data->compliance_id}})"> Yes
                            
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
