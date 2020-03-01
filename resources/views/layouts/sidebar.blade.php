<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<a href="#">
					<div class="image">
						<img src="{{ URL::asset('theme/v1/img/user/ecomnnect-logo-3.png') }}" alt="avatar" />
					</div>
					<div class="info">
						{{ Auth::user()->first_name .' '. Auth::user()->last_name }}
						<small>
							@if(Auth::user()->role == 0)
							<span class="label label-lime">ADMINISTRATOR</span>
							@else
								@if(Auth::user()->active == 1)
									@if($user->account->count() < 7 && $user->account->count() >= 1)
									<span class="label label-lime">PREMIUM BRONZE</span>
									@elseif($user->account->count() >= 7 && $user->account->count() < 15)
									<span class="label label-lime">PREMIUM SILVER</span>
									@elseif($user->account->count() == 15)
									<span class="label label-lime">PREMIUM GOLD</span>
									@endif
								@else
									<span class="label label-danger">FREE</span>
								@endif
							@endif
                        </small>
					</div>
				</a>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			@if(Auth::user()->role == 0)
			<li class="nav-header">Admin</li>
			@if(Auth::user()->id == 1)
			<li class="{!!(Request::is('admin') ? 'active' : '') !!}">
				<a href="{{ url('/admin') }}">
					<i class="icon-screen-desktop"></i>
					<span>Dashboard</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/encashments') ? 'active' : '') !!}">
				<a href="{{ url('/admin/encashments') }}">
					<i class="icon-credit-card"></i> 
					<span>Encashments</span>
				</a>
			</li>
			<li class="has-sub {!!(Request::is('admin/activation-codes') || Request::is('admin/transfer-codes') || Request::is('admin/generate-codes') || Request::is('admin/activation-codes-history') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-key"></i>
					<span>Codes</span>
				</a>
				<ul class="sub-menu">
					<li class="{!!(Request::is('admin/generate-codes') ? 'active' : '') !!}"><a href="{{ url('/admin/generate-codes') }}">Generate</a></li>
                    <li class="{!!(Request::is('admin/activation-codes') ? 'active' : '') !!}"><a href="{{ url('/admin/activation-codes') }}">Codes</a></li>
					<li class="{!!(Request::is('admin/transfer-codes') ? 'active' : '') !!}"><a href="{{ url('/admin/transfer-codes') }}">Transfer</a></li>
					<li class="{!!(Request::is('admin/activation-codes-history') ? 'active' : '') !!}"><a href="{{ url('/admin/activation-codes-history') }}">History</a></li>
				</ul>
			</li>
			<li class="{!!(Request::is('admin/network/genealogy') ? 'active' : '') !!}">
				<a href="{{ url('/admin/network/genealogy') }}">
					<i class="icon-globe"></i>
					<span>Genealogy</span>
				</a>
			</li>
			<li class="has-sub {!!(Request::is('admin/travelandtours/*') || Request::is('admin/eloading-wallet') || Request::is('admin/eloading-history') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-star"></i> 
					<span>Services</span>
				</a>
				<ul class="sub-menu">
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							Travel and Tours
						</a>
						<ul class="sub-menu">
							<li class="{!!(Request::is('admin/travelandtours/dashboard') ? 'active' : '') !!}"><a href="{{ url('/admin/travelandtours/dashboard') }}">Dashboard</a></li>
							<li class="{!!(Request::is('admin/travelandtours/master-fund') ? 'active' : '') !!}"><a href="{{ url('/admin/travelandtours/master-fund') }}">Master Fund</a></li>
							<li class="{!!(Request::is('admin/travelandtours/booking') ? 'active' : '') !!}"><a href="{{ url('/admin/travelandtours/booking') }}">Booking</a></li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							E-Loading
						</a>
						<ul class="sub-menu">
							<li class="{!!(Request::is('admin/eloading-wallet') ? 'active' : '') !!}"><a href="{{ url('/admin/eloading-wallet') }}">Load Wallet</a></li>
							<li class="{!!(Request::is('admin/eloading-history') ? 'active' : '') !!}"><a href="{{ url('/admin/eloading-history') }}">History</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="{!!(Request::is('admin/accounts') ? 'active' : '') !!}">
				<a href="{{ url('/admin/accounts') }}">
					<i class="icon-user-following"></i>
					<span>Accounts</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/members') ? 'active' : '') !!}">
				<a href="{{ url('/admin/members') }}">
					<i class="icon-user"></i>
					<span>Members</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/suspended*') ? 'active' : '') !!}">
				<a href="{{ url('/admin/suspended') }}">
					<i class="icon-user-unfollow"></i>
					<span>Suspended Members</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/settings') ? 'active' : '') !!}">
				<a href="{{ url('/admin/settings') }}">
					<i class="icon-settings"></i>
					<span>Settings</span>
				</a>
			</li>

			@elseif(Auth::user()->id == 3058)
			<li class="{!!(Request::is('admin') ? 'active' : '') !!}">
				<a href="{{ url('/admin') }}">
					<i class="icon-screen-desktop"></i>
					<span>Dashboard</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/encashments') ? 'active' : '') !!}">
				<a href="{{ url('/admin/encashments') }}">
					<i class="icon-credit-card"></i> 
					<span>Encashments</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/members') ? 'active' : '') !!}">
				<a href="{{ url('/admin/members') }}">
					<i class="icon-user"></i>
					<span>Members</span>
				</a>
			</li>
			<li class="{!!(Request::is('admin/suspended*') ? 'active' : '') !!}">
				<a href="{{ url('/admin/suspended') }}">
					<i class="icon-user-unfollow"></i>
					<span>Suspended Members</span>
				</a>
			</li>

			@endif

			@elseif(Auth::user()->role == 1)

			<li class="nav-header">Navigation</li>
			<li class="{!!(Request::is('overview') ? 'active' : '') !!}">
				<a href="{{ url('/overview') }}">
					<i class="icon-screen-desktop"></i>
					<span>Overview</span>
				</a>
			</li>
			<!--li class="{!!(Request::is('compensation-plan') ? 'active' : '') !!}">
				<a href="{{ url('/compensation-plan') }}">
					<i class="icon-docs"></i>
					<span>Compensation Plan</span>
				</a>
			</li-->
			<li class="{!!(Request::is('announcements') ? 'active' : '') !!}">
				<a href="{{ url('/announcements') }}">
					<i class="icon-drawer"></i> 
					<span>Announcements</span>
				</a>
			</li>
			<li class="{!!(Request::is('customer-support') || Request::is('customer-support/new') ? 'active' : '') !!}">
				<a href="{{ url('/customer-support') }}">
					<i class="icon-support"></i> 
					<span>Support</span> 
				</a>
			</li>
			<li class="has-sub {!!(Request::is('services/*') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-star"></i> 
					<span>Services</span>
				</a>
				<ul class="sub-menu">
					<li><a href="{{ url('/services/e-loading') }}" target="_blank">E-Loading</a></li>
					<li><a href="{{ url('/services/hotel-booking') }}" target="_blank">Hotel Booking</a></li>
					<li><a href="{{ url('/services/airline-ticketing') }}" target="_blank">Airline Ticketing</a></li>
				</ul>
			</li>
			<li class="has-sub {!!(Request::is('services/*') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-star"></i> 
					<span>Ecommerce</span>
				</a>
				<ul class="sub-menu">
					<li><a href="https://cms.ecomnnect.com/" target="_blank">CMS Beta Test</a></li>
					<li><a href="https://ecomnnect.ph/" target="_blank">Marketplace</a></li>
				</ul>
			</li>
			<li class="has-sub {!!(Request::is('voucher/my-vouchers') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-tag"></i> 
					<span>Product Voucher</span>
				</a>
				<ul class="sub-menu">
					<li class="{!!(Request::is('voucher/my-vouchers') ? 'active' : '') !!}"><a href="{{ url('/voucher/my-vouchers') }}">My Vouchers</a></li>
					<li><a href="#">Redeem</a></li>
				</ul>
			</li>
			<li class="has-sub {!!(Request::is('activation-codes') || Request::is('transfer-codes') || Request::is('activation-codes-history') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-key"></i>
					<span>Codes</span>
				</a>
				<ul class="sub-menu">
					<li class="{!!(Request::is('transfer-codes') ? 'active' : '') !!}"><a href="{{ url('/transfer-codes') }}">Transfer</a></li>
                    <li class="{!!(Request::is('activation-codes') ? 'active' : '') !!}"><a href="{{ url('/activation-codes') }}">My Codes</a></li>
                    <li class="{!!(Request::is('activation-codes-history') ? 'active' : '') !!}"><a href="{{ url('/activation-codes-history') }}">Codes History</a></li>
				</ul>
			</li>
            <li class="has-sub {!!(Request::is('account/activation') || Request::is('account/add') || Request::is('account/my-accounts') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-user"></i>
					<span>Account</span>
				</a>
				<ul class="sub-menu">
					@if(Auth::user()->active == 0)
					<li class="{!!(Request::is('account/activation') ? 'active' : '') !!}"><a href="{{ url('/account/activation') }}">Activation</a></li>
					@elseif(Auth::user()->active == 1)
					<li class="{!!(Request::is('account/add') ? 'active' : '') !!}"><a href="{{ url('/account/add') }}">Add Account</a></li>
					@endif
					<li class="{!!(Request::is('account/my-accounts') ? 'active' : '') !!}"><a href="{{ url('/account/my-accounts') }}">My Accounts</a></li>
				</ul>
			</li>
			<li class="has-sub {!!(Request::is('network/genealogy') || Request::is('network/subscribers') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-globe"></i>
					<span>Network</span>
				</a>
				<ul class="sub-menu">
                    <li class="{!!(Request::is('network/genealogy') ? 'active' : '') !!}"><a href="{{ url('/network/genealogy') }}">Genealogy</a></li>
                    <li class="{!!(Request::is('network/subscribers') ? 'active' : '') !!}"><a href="{{ url('/network/subscribers') }}">Subscribers</a></li>
				</ul>
            </li>
			<li class="has-sub {!!(Request::is('e-wallet/manage') || Request::is('e-wallet/withdraw') || Request::is('e-wallet/requests') || Request::is('e-wallet/convert') || Request::is('e-wallet/summary') || Request::is('e-wallet/payout-preference') ? 'active' : '') !!}">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="icon-wallet"></i>
					<span>E-Wallet</span>
				</a>
				<ul class="sub-menu">
					<li class="{!!(Request::is('e-wallet/manage') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/manage') }}">Manage E-Wallet</a></li>
					<li class="{!!(Request::is('e-wallet/withdraw') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/withdraw') }}">Withdraw Commission from E-Wallet</a></li>
					<li class="{!!(Request::is('e-wallet/requests') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/requests') }}">My Withdrawal Requests</a></li>
					<li class="{!!(Request::is('e-wallet/convert') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/convert') }}">Convert to E-Fund</a></li>
					<li class="{!!(Request::is('e-wallet/summary') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/summary') }}">Summary</a></li>
					<li class="{!!(Request::is('e-wallet/payout-preference') ? 'active' : '') !!}"><a href="{{ url('/e-wallet/payout-preference') }}">Payout Preference</a></li>
				</ul>
			</li>
			<li class="{!!(Request::is('terms-of-use') ? 'active' : '') !!}">
				<a href="{{ url('/terms-of-use') }}">
					<i class="icon-diamond"></i>
					<span>Terms of Use</span>
				</a>
			</li>
			<li class="has-sub {!!(Request::is('security/pin') || Request::is('security/password') ? 'active' : '') !!}">
				<a href="#">
					<i class="icon-settings"></i>
					<b class="caret pull-right"></b>
					<span>Security</span>
                </a>
                <ul class="sub-menu">
					<li class="{!!(Request::is('security/pin') ? 'active' : '') !!}"><a href="{{ url('/security/pin') }}">Security Pin</a></li>
					<li class="{!!(Request::is('security/password') ? 'active' : '') !!}"><a href="{{ url('/security/password') }}">Password</a></li>
				</ul>
			</li>

			@elseif(Auth::user()->role == 2)

			<li class="nav-header">Admin - Helper</li>
			<li class="{!!(Request::is('helper') ? 'active' : '') !!}">
				<a href="{{ url('/helper') }}">
					<i class="icon-screen-desktop"></i>
        	        <span>Overview</span>
        	    </a>
			</li>
			<li class="has-sub {!!(Request::is('helper/activation-codes') || Request::is('helper/transfer-codes')  ? 'active' : '') !!}">
                <a href="#">
					<b class="caret pull-right"></b>
                    <i class="icon-key"></i>
                    <span>Codes</span>
                </a>
                <ul class="sub-menu">
                    <li class="{!!(Request::is('helper/activation-codes') ? 'active' : '') !!}">
                        <a href="{{ url('/helper/activation-codes') }}">
                        	Codes
                        </a>
                    </li>
                    <li class="{!!(Request::is('helper/transfer-codes') ? 'active' : '') !!}">
                        <a href="{{ url('/helper/transfer-codes') }}">
                            Transfer
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{!!(Request::is('helper/members*') ? 'active' : '') !!}">
				<a href="{{ url('/helper/members') }}">
					<i class="icon-user"></i>
					<span>Members</span>
                </a>
            </li>
            <li class="{!!(Request::is('helper/customer-support*') ? 'active' : '') !!}">
				<a href="{{ url('/helper/customer-support') }}">
					<i class="icon-support"></i>
                    <span>Support Tickets</span>
                </a>
            </li>
            <li class="{!!(Request::is('helper/transfer-master-fund') ? 'active' : '') !!}">
				<a href="{{ url('/helper/transfer-master-fund') }}">
					<i class="icon-wallet"></i>
                    <span>Transfer Master Fund</span>
                </a>
			</li>
			<li class="{!!(Request::is('helper/eloading-transfer') ? 'active' : '') !!}">
				<a href="{{ url('/helper/eloading-transfer') }}">
					<i class="icon-wallet"></i>
                    <span>Transfer Load Wallet</span>
                </a>
			</li>
			
			@elseif(Auth::user()->role == 3)

			<li class="nav-header">Admin - Support</li>
			@if(Auth::user()->id == 3059)
			<li class="{!!(Request::is('support') ? 'active' : '') !!}">
				<a href="{{ url('/support') }}">
					<i class="icon-screen-desktop"></i>
        	        <span>Overview</span>
        	    </a>
			</li>
			<li class="{!!(Request::is('support/encashments') ? 'active' : '') !!}">
				<a href="{{ url('/support/encashments') }}">
					<i class="icon-credit-card"></i> 
					<span>Remittance Encashments</span>
				</a>
			</li>
			<li class="{!!(Request::is('support/bdo-encashments') ? 'active' : '') !!}">
				<a href="{{ url('/support/bdo-encashments') }}">
					<i class="icon-credit-card"></i> 
					<span>BDO Encashments</span>
				</a>
			</li>
			@endif
			<li class="{!!(Request::is('support/customer-support*') ? 'active' : '') !!}">
				<a href="{{ url('/support/customer-support') }}">
					<i class="icon-support"></i>
                    <span>Support Tickets</span>
                </a>
			</li>
			@endif

			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>

		</ul>
	</div>
</div>
<div class="sidebar-bg {!!(Request::is('profile') ? 'bg-white' : '') !!}"></div>