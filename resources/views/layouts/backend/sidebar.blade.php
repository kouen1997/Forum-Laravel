<div class="ecaps-sidemenu-area">
	<!-- Desktop Logo -->
	<div class="ecaps-logo">
		<a href="{{ url('/account') }}"><img class="desktop-logo" src="{{ URL::asset('homebook.png') }}" alt="HomeBookPH"> <img class="small-logo" src="{{ URL::asset('homebook.png') }}" alt="HomeBookPH"></a>
	</div>
	<!-- Side Nav -->
	<div class="ecaps-sidenav" id="ecapsSideNav">
		<!-- Side Menu Area -->
		<div class="side-menu-area">
			<!-- Sidebar Menu -->
			<nav>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="sidemenu-user-profile d-flex align-items-center">
						<div class="user-thumbnail">
							<img src="{{ URL::asset('homebook.png') }}" alt="">
						</div>
						<div class="user-content">
							<h6>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</h6>
							<span>
								@if(Auth::user()->role == 0)
									Administrator
								@endif
							</span>
						</div>
					</li>
					@if(Auth::user()->role == 0)

					@if(Auth::user()->id == 1)
					<li {!!(Request::is('admin') ? 'class="active"' : '') !!}>
						<a href="{{ url('/admin') }}"><i class="ti-dashboard"></i><span>Dashboard</span></a>
					</li>
					<li class="treeview">
                        <a href="javascript:void(0)"><i class="ti-email"></i> <span>News</span> <i class="fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('/news/list') }}">Listing</a></li>
                            <li><a href="{{ url('/news/add') }}">Add News</a></li>
                        </ul>
                    </li>
					<li class="treeview">
                        <a href="javascript:void(0)"><i class="ti-email"></i> <span>Trivia</span> <i class="fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('/trivia/list') }}">Listing</a></li>
                            <li><a href="{{ url('/trivia/add') }}">Add Trivia</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="javascript:void(0)"><i class="ti-video"></i> <span>Video Tutorials</span> <i class="fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('/video/tutorial/list') }}">Listing</a></li>
                            <li><a href="{{ url('/video/tutorial/add') }}">Add Tutorials</a></li>
                        </ul>
                    </li>
					<li class="treeview">
						<a href="javascript:void(0)"><i class="ti-package"></i> <span>Lead Management</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/admin/property/add') }}">Add Property</a></li>
							<li><a href="{{ url('/admin/properties') }}">Property List</a></li>
						</ul>
					</li>
					<li {!!(Request::is('architectural_design') ? 'class="treeview active"' : 'class="treeview"') !!}>
						<a href="javascript:void(0)"><i class="ti-panel"></i> <span>Architectural Design</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/admin/architectural-design/listing') }}">Listing</a></li>
						</ul>
					</li>
					<li {!!(Request::is('interior_design') ? 'class="treeview active"' : 'class="treeview"') !!}>
						<a href="javascript:void(0)"><i class="ti-panel"></i> <span>Interior Design</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/admin/interior-design/listing') }}">Listing</a></li>
						</ul>
					</li>
					@endif

					@elseif(Auth::user()->role == 1)
					<li {!!(Request::is('dashboard') ? 'class="active"' : '') !!}>
						<a href="{{ url('/dashboard') }}"><i class="ti-dashboard"></i><span>Dashboard</span></a>
					</li>
					<!-- <li class="treeview">
						<a href="javascript:void(0)"><i class="ti-user"></i> <span>Account</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							@if(Auth::user()->active == 0)
							<li><a href="{{ url('/account/activation') }}">Activate</a></li>
							@elseif(Auth::user()->active == 1)
							<li><a href="{{ url('/account/add') }}">Add Account</a></li>
							@endif
							<li><a href="{{ url('/account/my-accounts') }}">Account List</a></li>
						</ul>
					</li> -->
					<li {!!(Request::is('architectural_design') ? 'class="treeview active"' : 'class="treeview"') !!}>
						<a href="javascript:void(0)"><i class="ti-panel"></i> <span>Architectural Design</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/architectural-design/listing') }}">Listing</a></li>
							<li><a href="{{ url('/architectural-design/add') }}">Add Architectural Design</a></li>
						</ul>
					</li>
					<li {!!(Request::is('interior_design') ? 'class="treeview active"' : 'class="treeview"') !!}>
						<a href="javascript:void(0)"><i class="ti-panel"></i> <span>Interior Design</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/interior-design/listing') }}">Listing</a></li>
							<li><a href="{{ url('/interior-design/add') }}">Add Interior Design</a></li>
						</ul>
					</li>
					<li {!!(Request::is('listing') ? 'class="treeview active"' : 'class="treeview"') !!}>
						<a href="javascript:void(0)"><i class="ti-panel"></i> <span>Property</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/profile/property/listing') }}">Listing</a></li>
							<li><a href="{{ url('/profile/property/add') }}">Add Property</a></li>
						</ul>
					</li>
					<!-- <li class="treeview">
						<a href="javascript:void(0)"><i class="ti-wallet"></i> <span>E-Wallet</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/e-wallet/manage') }}">Manage</a></li>
							<li><a href="{{ url('/e-wallet/withdraw') }}">Withdraw</a></li>
							<li><a href="{{ url('/e-wallet/history') }}">Withdrawal History</a></li>
							<li><a href="{{ url('/e-wallet/payout-preference') }}">Preference</a></li>
						</ul>
					</li>
					<li {!!(Request::is('referrals') ? 'class="active"' : '') !!}>
						<a href="{{ url('/referrals') }}"><i class="ti-heart"></i> <span>Referrals</span></a>
					</li> -->
					<li class="treeview">
						<a href="javascript:void(0)"><i class="ti-lock"></i> <span>Security</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<!-- <li><a href="{{ url('/security/pin') }}">Pin</a></li> -->
							<li><a href="{{ url('/security/password') }}">Password</a></li>
						</ul>
					</li>
					@elseif(Auth::user()->role == 2)
					<li {!!(Request::is('helper') ? 'class="active"' : '') !!}>
						<a href="{{ url('/helper') }}"><i class="ti-dashboard"></i><span>Dashboard</span></a>
					</li>
					<li class="treeview">
						<a href="javascript:void(0)"><i class="ti-package"></i> <span>Lead Management</span> <i class="fa fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/helper/property/add') }}">Add Property</a></li>
							<li><a href="{{ url('/helper/properties') }}">Property List</a></li>
							<li><a href="{{ url('/helper/leads') }}">Leads</a></li>
						</ul>
					</li>
					@endif
				</ul>
			</nav>
		</div>
	</div>
</div>