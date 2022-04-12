@extends('main')
{{-- 219 AND 319 --}}
@section('content')
@include('client1.cmp.__payment')

<script>

</script>
<body>
	@include('client1.cmp.nav')
	@include('client1.cmp.breadcrumb')
	@include('client1.cmp.msg')
	@include('client1.cmp.__wizard')
	<div class="container mt-5 mb-5">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Description</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
			
		     	@if(count($npayment) > 0)
				 @php
					$total = 0;
				 @endphp

				  @for($i = 0; $i < count($npayment); $i++)
				
				 @if($npayment[$i]->reference  != 'Payment')
				 @php
					$total += $npayment[$i]->amount;
				 @endphp
		     	<tr>
		     		<td>{{$npayment[$i]->reference}}</td>
		     		<td>&#8369;&nbsp;{{number_format($npayment[$i]->amount, 2)}}</td>
		     	</tr>
				 @endif
				

		        @endfor 
				<tr>
		     		<td><b>Total</b></td>
		     		<td><b>&#8369;&nbsp;{{number_format($total, 2)}}</b></td>
		     	</tr>
				@else
		     	<tr>
		     		<td colspan="2">No charge(s).</td>
		     	</tr>
		        @endif
			</tbody>
		</table>
		<hr>
		@if(isset($cToken))
			<div class="row">
				<div class="col-md-4">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					  {{-- <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-paypal"></i> Paypal</a>
					  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fab fa-btc"></i> Landbank</a>
					  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fas fa-money-check"></i> Dragonpay</a> --}}
					  <a class="nav-link active" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true"><i class="fas fa-user-alt"></i> Cash</a>
					  <a class="nav-link" id="v-pills-pmo-tab" data-toggle="pill" href="#v-pills-pmo" role="tab" aria-controls="v-pills-pmo" aria-selected="false"><i class="fa fa-rouble"></i> Postal Money Order</a>
					  <a class="nav-link" id="v-pills-mc-tab" data-toggle="pill" href="#v-pills-manager" role="tab" aria-controls="v-pills-pmo" aria-selected="false"><i class="fa fa-check" aria-hidden="true"></i> Manager's Check {{--/ Cashier's Check / Company Check--}}</a>
					</div>
				</div>
				<div class="col-md-8">
					{{-- <div class="tab-content" id="v-pills-tabContent">
					  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<img src="https://www.paypalobjects.com/digitalassets/c/website/logo/full-text/pp_fc_hl.svg" style="width: 100px; height: 100px; object-fit: contain;">
						<p style="line-height: 1;"><small>PayPal Holdings, Inc. is an American company operating a worldwide online payments system that supports online money transfers and serves as an electronic alternative to traditional paper methods like cheques and money orders.</small></p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					        {{csrf_field()}}
					     	<input type="hidden" name="cmd" value="_cart">
					     	<input type="hidden" name="upload" value="1">
					     	<input type="hidden" name="business" value="ra.janpaolocleotes-facilitator@gmail.com">
					     	<input TYPE="hidden" NAME="currency_code" value="PHP">
					     	@if(count($npayment) > 0) @for($i = 0; $i < count($npayment); $i++)
					            <input type="hidden" name="item_name_{{$i + 1}}" value="{{$npayment[$i]->reference}}">
					            <input type="hidden" name="quantity_{{$i + 1}}" value="1">
					            <input type="hidden" name="shipping_{{$i + 1}}" value="0.00">
					            <input type="hidden" name="amount_{{$i + 1}}" value="{{$npayment[$i]->amount}}">
					        @endfor @endif
					        <input type="hidden" name="return" id="return">
					        <input type="hidden" name="cancel_return" id="cancel_return" value="{{asset('/client1/request/payment')}}/{{$cToken}}/292/{{$appid}}">
							@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
					        <button type="submit" class="btn btn-primary"  style="float: right;">Continue with PayPal <i class="fab fa-paypal"></i></button>
@endif

					 	</form>
					  </div>
					  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						<img src="https://www.landbank.com/sites/default/files/weblogo.png" style="width: 100px; height: 100px; object-fit: contain;">
						<form id="_lndForm" method="POST" action="{{asset('client1/request/payment')}}/{{$cToken}}/294/{{$appid}}" enctype="multipart/form-data">
					      {{csrf_field()}}
					      <div class="row">
					      	<div class="col-sm-6">
					          <div class="form-group">
					          	<label>Date of Payment:</label>
					          	<input type="date" class="form-control form-control-sm" name="au_date">
					          </div>
					        </div>
					        <div class="col-sm-6">
					          <div class="form-group">
					          	<label>Upload Official Receipt:</label>
					          	<input type="file" class="form-control form-control-sm" name="au_file">
					          </div>
					        </div>
					      </div>
					      <div class="row">
					      	<div class="col-sm-6">
					          <div class="form-group">
					          	<label>Reference Number:</label>
					          	<input type="text" class="form-control form-control-sm" name="au_ref">
					          </div>
					        </div>
					        <div class="col-sm-6">
					          <div class="form-group">
					          	<label>Amount:</label>
					          	<input type="number" class="form-control form-control-sm" name="au_amount">
					          </div>
					        </div>
					      </div>
					    </form>
					    <hr>
						@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
					    <button form="_lndForm" class="btn btn-primary" style="float: right;">Continue with LandBank</button>
						@endif
					  </div>
					  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
						<img src="https://www.dragonpay.ph/wp-content/themes/wp365_theme/img/logo_dragonpay.png" style="width: 100px; height: 100px; object-fit: contain;">
						<p style="line-height: 1;"><small>Dragonpay is a leading online payment service provider in the Philippines. We provide an easy and convenient way to pay for products and services online.</small></p>
						<hr>
							@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
							<button class="btn btn-primary" style="float: right;">Continue with DragonPay</button>
							@endif
					  </div> --}}
					  <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
					  	<div class="row">
					  		<div class="col-md-3">
								<img src="https://www.freeiconspng.com/uploads/walking-icon-32.png" style="width: 100px; height: 100px; object-fit: contain;">
							</div>
					  		<div class="col-md-9">
							    <div class="row">
							        <div class="col-sm-1 text-right">
							          	{{-- <input id="s_wlk" type="checkbox" name="chance" onchange=""> --}}
							        </div>
							        <div class="col-sm-10">
							          	<p for="s_wlk" style="line-height: 1;" class="text-justify"><b>CONTINUE PAYMENT AS Cash</b> <small>(Walk In Payment)</small></p>
							        </div>
							        <form id="_fWlk" method="POST">
							        	{{csrf_field()}}
							        	<input type="hidden" name="mPay" value="MOP-001">
							        </form>
							    </div>
							    <br>
								
								@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
								
								<button form="_fWlk" class="btn btn-primary"  style="float: right;">Continue with Cash Payment</button>
								@endif
							</div>
						</div>
					  </div>
					  <div class="tab-pane fade" id="v-pills-pmo" role="tabpanel" aria-labelledby="v-pills-pmo-tab">
					  	<div class="row">
					  		<div class="col-md-3">
								<img src="https://www.mycablemart.com/images/money_order_large_icon.png" style="width: 100px; height: 100px; object-fit: contain;">
							</div>
					  		<div class="col-md-9">
							    <div class="row">
							        <div class="col-sm-1 text-right">
							          	{{-- <input id="s_wlk" type="checkbox" name="chance" onchange=""> --}}
							        </div>
							        <div class="col-sm-10">
							          	<p for="s_wlk" style="line-height: 1;" class="text-justify"><b>CONTINUE PAYMENT AS PMO</b> <small>(Postal Money Order)</small></p>
							        </div>
							        <form id="PMO" method="POST">
							        	{{csrf_field()}}
							        	<input type="hidden" name="mPay" value="MOP-010">
						        		<div class="col-md font-weight-bold mt-3 req">
						        			Number
						        		</div>
						        		<div class="col-md">
						        			<input type="number" name="number" class="form-control" required="">
						        		</div>
							        </form>
							    </div>
							    <br>
								@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
								<button form="PMO" class="btn btn-primary" style="float: right;">Continue with PMO Payment</button>
								@endif
							</div>
						</div>
					  </div>

					  <div class="tab-pane fade" id="v-pills-manager" role="tabpanel" aria-labelledby="v-pills-mc-tab">
					  	<div class="container pt-3 pb-3">
					  		<span class="text-danger">NOTE: Please make check payable to <span class="font-weight-bold"><u>Department of Health</u></span></span>
					  	</div>
					  	<div class="row">
					  		<div class="col-md-3">
								<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHBWlOJLD1K0mkJa_XHjH_aM-mCAQGexjhVkGGGEsU5z2TwGqA" style="width: 100px; height: 100px; object-fit: contain;" alt="managers check image">
							</div>
					  		<div class="col-md-9">
							    <div class="row">
							        <div class="col-sm-1 text-right">
							          	{{-- <input id="s_wlk" type="checkbox" name="chance" onchange=""> --}}
							        </div>
							        <div class="col-sm-10">
							          	<p for="s_wlk" style="line-height: 1;" class="text-justify"><b>CONTINUE PAYMENT AS MANAGER'S CHECK</b> </p>
							        </div>
							        <form id="MC" method="post" enctype="multipart/form-data">
							        	{{csrf_field()}}
							        	<input type="hidden" name="mPay" value="MOP-009">
							        	{{-- <div class="col-md font-weight-bold mt-3 req">
						        			Advise File
						        		</div>
						        		<div class="col-md">
						        			<input type="file" name="attFile" class="form-control" required="">
						        		</div> --}}
						        		<div class="col-md font-weight-bold mt-3 req">
						        			Drawee Bank
						        		</div>
						        		<div class="col-md">
						        			<input type="text" name="drawee" class="form-control" required="">
						        		</div>
						        		<div class="col-md font-weight-bold mt-3 req">
						        			Number
						        		</div>
						        		<div class="col-md">
						        			<input type="number" name="number" class="form-control" required="">
						        		</div>
							        </form>
							    </div>
							    <br>
								@if(($hfser_id == 'LTO' || $hfser_id == 'COA') && $hasAssessment == 0 && $aptid != 'R')
								<button class="btn btn-warning" disabled  style="float: right;">No assessment yet</button>
								@else
								<button form="MC" class="btn btn-primary" style="float: right;">Continue with Manager's Check Payment</button>
								@endif
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		@endif
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="{{asset('ra-idlis/public/js/forall.js')}}"></script>
	<script type="text/javascript">
		"use strict";
		var ___div = document.getElementById('__paymentBread'), ___wizardcount = document.getElementsByClassName('wizardcount');
		if(___div != null || ___div != undefined) {
			___div.classList.remove('active');
			___div.classList.add('text-primary');
		}
		if(___wizardcount != null || ___wizardcount != undefined) {
			for(let i = 0; i < ___wizardcount.length; i++) {
				if(i < 3) {
					___wizardcount[i].parentNode.classList.add('past');
				}
				if(i == 3) {
					___wizardcount[i].parentNode.classList.add('active');
				}
			}
		}
		(function() {
		})();
		$(function () {
		  	$('[data-toggle="tooltip"]').tooltip()
		});
		$(document).ready( function () {
		});
	</script>
	@include('client1.cmp.footer')
</body>
@endsection