@extends('layouts.backend.master')

@section('title', 'Profile')

@section('header_scripts')
@stop

@section('content')
<div ng-app="profileApp" ng-controller="ProfileCtrl as frm">
	<div class="col-12 mb-3">
		<div class="card bg-boxshadow full-height">
			<div class="card-body">
				<h4 class="card-title">Profile</h4>
				<ul class="profile-header-tab nav nav-tabs">
					<li class="nav-item"><a href="#profile-about" class="nav-link active" data-toggle="tab">ABOUT</a></li>
					<!-- <li class="nav-item"><a href="#profile-sponsor" class="nav-link" data-toggle="tab">SPONSOR</a></li>
					<li class="nav-item"><a href="#profile-bir" class="nav-link" data-toggle="tab">TIN</a></li> -->
				</ul>
				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="profile-about">
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h3>About</h3>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr class="highlight">
										<td class="field">Referral Link</td>
										<td><a href="#">{{ url('/?ref=').$user->username }}</a></td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Mobile</td>
										<td><i class="fa fa-mobile fa-lg m-r-5"></i> {{ $user->mobile && $user->mobile !== NULL ? $user->mobile : 'none' }}</td>
									</tr>
									<tr>
										<td class="field">Email</td>
										<td><a href="#">{{ $user->email }}</a></td>
									</tr>
									<tr class="highlight">
										<td class="field">My Accounts</td>
										<td>{{ $user->account()->count() }}</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">My Codes</td>
										<td>{{ $user->code()->where('status','UNUSED')->count() }}</td>
									</tr>
									<tr>
										<td class="field">My Referrals</td>
										<td>{{ $user->sponsored()->count() }}</td>
									</tr>
									<form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="updateInfoFrm" ng-submit="frm.updateInfo(updateInfoFrm.$valid)" autocomplete="off">
										<tr>
											<td class="field">Mobile no.</td>
											<td>
												<input type="text" class="form-control input-inline input-md" placeholder="Mobile Number" name="mobile" id="mobile" ng-model="frm.mobile" ng-init="frm.mobile='{{ $user->mobile && $user->mobile !== NULL ? $user->mobile : '' }}'"  required>
											</td>
										</tr>
										<tr>
											<td class="field">Birthdate</td>
											<td>
												<input type="date" class="form-control input-inline input-md" placeholder="Birthdate" name="birth_date" max="2000-01-01" min="1930-01-01" format="yyyy-mm-dd" id="birth_date" ng-model="frm.birth_date" ng-init="frm.birth_date=birth_date" required>
											</td>
										</tr>
										<tr class="divider">
											<td colspan="2"></td>
										</tr>
										<tr class="highlight">
											<td class="field">&nbsp;</td>
											<td class="p-t-10 p-b-10">
												<button type="submit" ng-disabled="updateInfoFrm.$invalid" id="update_info_btn" class="btn btn-primary width-150">Update</button>
											</td>
										</tr>
									</form>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="profile-sponsor">
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h3>Sponsor</h3>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="field"></td>
										<td>
											<img src="{{ URL::asset('homebook.png') }}" class="rounded-circle img-responsive" width="105" height="105" alt="HomeBookPH"> 	
										</td>
									</tr>
									<tr class="highlight">
										<td class="field">Name</td>
										<td>{{ $user->sponsor->first_name." ".$user->sponsor->last_name }}</td>
									</tr>
									<tr class="divider">
										<td colspan="2"></td>
									</tr>
									<tr>
										<td class="field">Username</td>
										<td>{{ $user->sponsor->username }}</td>
									</tr>
									<tr>
										<td class="field">Email</td>
										<td><a href="#">{{ $user->sponsor->email }}</a></td>
									</tr>
									<tr>
										<td class="field">Mobile no.</td>
										<td><i class="fa fa-mobile fa-lg m-r-5"></i> {{ $user->sponsor->mobile && $user->sponsor->mobile !== NULL ? $user->sponsor->mobile : 'none' }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="profile-bir">
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h3>TIN</h3>
										</th>
									</tr>
								</thead>
								<tbody>
									<form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="saveTINFrm" ng-submit="frm.saveTIN(saveTINFrm.$valid)" autocomplete="off">
										<tr>
											<td class="field">TIN No.</td>
											<td>
												<input type="text" class="form-control input-inline input-md ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="TIN Number" name="tin" id="tin" ng-model="frm.tin" ng-init="frm.tin='{{ $user->tin && $user->tin !== NULL ? $user->tin : ''   }}'" required>
											</td>
										</tr>
										<tr>
											<td class="field">Security Pin</td>
											<td>
												<input type="text" class="form-control input-inline input-md ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Security Pin" name="pin" maxlength="6" ng-model="frm.pin" required>
											</td>
										</tr>
										<tr class="divider">
											<td colspan="2"></td>
										</tr>
										<tr class="highlight">
											<td class="field">&nbsp;</td>
											<td class="p-t-10 p-b-10">
												<button type="submit" ng-disabled="saveTINFrm.$invalid" id="update_tin_btn" class="btn btn-primary width-150">Update</button>
											</td>
										</tr>
									</form>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript">
	(function () {
        var profileApp = angular.module('profileApp', ['angular.filter']);
        profileApp.controller('ProfileCtrl', function ($scope, $http, $sce) {

          	var vm = this;

          	$scope.birth_date = new Date("{{$user->birth_date}}");
          
			vm.updateInfo = function () {
				console.log(vm.birth_date);

			$http({
			      method: 'POST',
			      url: '/profile',
			      data: JSON.stringify({
			      	 middle_name: vm.middle_name,
			         mobile: vm.mobile,
			         birth_date: vm.birth_date,
					 team: vm.team
			      })
			  }).success(function (data) {
			      if (data.result==1){

			          alert(data.message);

			          $('#middle_name').prop('disabled', true);

					  setTimeout('window.location.reload();', 1000);
			      }
			  }).error(function (data) {

			    if(data.result == 0){

			    	alert(data.message);

			      } else {

			       	angular.forEach(data.errors, function(message, key){

			       		alert(message);

			        });
			      }
			  });
			 
			};

			vm.updatePassword = function () {

			$http({
			      method: 'POST',
			      url: '/profile/password',
			      data: JSON.stringify({
			         current_password: vm.current_password,
			         password: vm.password,
			         password_confirmation: vm.password_confirmation
			      })
			  }).success(function (data) {
			      if (data.result==1){
			          alert(data.message);
			      }
			  }).error(function (data) {

			    if(data.result == 0){

			    	alert(data.message);

			      } else {

			      	angular.forEach(data.errors, function(message, key){

			      		alert(message);

			        });
			      }
			  });
			 
			};

			vm.saveTIN = function () {

				$http({
				  method: 'POST',
				  url: '/profile/tin',
				  data: JSON.stringify({
				     tin: vm.tin,
				     pin: vm.pin,
				  })
				}).success(function (data) {
				  if (data.result==1){
				      alert(data.message);
				      setTimeout('window.location.reload();', 1000);
				  }
				}).error(function (data) {

				if(data.result == 0){

					alert(data.message);

					setTimeout('window.location.reload();', 1000);

				  } else {

				  	angular.forEach(data.errors, function(message, key){

				  		alert(message);

				    });
				  }
				});
			 
			};

			vm.marketplaceConnect = function () {

				$('#marketplace_btn').prop('disabled', true);
				$('#marketplace_btn').html('Connecting...');

				$http({
				method: 'POST',
				url: '/profile/marketplace',
				data: JSON.stringify({
					email: vm.marketplace_email,
					password: vm.marketplace_password,
					password_confirmation: vm.marketplace_password_confirmation,
					pin: vm.marketplace_pin
				})
				}).success(function (data) {
				if (data.result == 1){
						$('#marketplace_btn').html('Connected');
						alert(data.message);

						setTimeout('window.location.reload();', 1000);
				}

				}).error(function (data) {

					$('#marketplace_btn').prop('disabled', false);
					$('#marketplace_btn').html('Connect');

					if(data.result == 0){

						alert(data.message);

					} else {
						
						angular.forEach(data.errors, function(message, key){

							alert(message);

						});
					}
				})
				
				};

        });
    })();
</script>

@stop