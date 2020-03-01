<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', array('as' => 'get-home', 'uses' => 'HomeController@getHome'));

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/add/listing/properties', array('as' => 'add-listing-properties', 'uses' => 'HomeController@getAddListingProperties'));

Route::get('/properties/sale', array('as' => 'get-for-sale-properties', 'uses' => 'PropertyController@getForSaleProperties'));
Route::get('/properties/rent', array('as' => 'get-for-rent-properties', 'uses' => 'PropertyController@getForRentProperties'));
Route::get('/properties', array('as' => 'get-search-property', 'uses' => 'PropertyController@getSearchProperty'));
Route::get('/property/{slug}', array('as' => 'get-single-property', 'uses' => 'PropertyController@getSingleProperty'));

Route::get('/forum/view/{slug}', array('as' => 'get-single-news', 'uses' =>'ForumController@getViewForum'));

Route::group(['middleware' => 'revalidate'],function() {


	//================================ Forum 

	Route::get('/forum', 'ForumController@getForum')->name('home');
	Route::get('/write/forum', 'ForumController@getWriteForum');
	Route::post('/post/forum', 'ForumController@postForum');
	Route::post('/forum/{forum_id}/comment', 'ForumController@postForumComment');
	Route::post('/forum/{forum_id}/{comment_id}/reply', 'ForumController@postForumReply');
	Route::any('/forum/search/keyword', 'ForumController@getForumSearch');
	Route::get('/forum/category/{category}', 'ForumController@getForumCategory');
	Route::get('/forum/edit/{slug}', 'ForumController@getEditForum');
	Route::post('/forum/edit', 'ForumController@postEditForum');
	Route::post('/forum/{forum_id}/delete', 'ForumController@postDeleteForum');

	//================================ News

	Route::get('/latest/news', 'NewsController@getNews');
	Route::get('/news/view/{slug}', 'NewsController@getViewNews');
	Route::get('/news/list', 'NewsController@getNewsList');
	Route::get('/news/add', 'NewsController@getAddNews');
	Route::post('/news/add', 'NewsController@postAddNews');
	Route::get('/news/edit/{id}', 'NewsController@getEditNews');
	Route::post('/news/edit', 'NewsController@postEditNews');
	Route::post('/news/{news_id}/delete', 'NewsController@postDeleteNews');

	//================================ Trivia

	Route::get('/trivia', 'TriviaController@getTrivia');
	Route::get('/trivia/view/{slug}', 'TriviaController@getViewTrivia');
	Route::get('/trivia/list', 'TriviaController@getTriviaList');
	Route::get('/trivia/add', 'TriviaController@getAddTrivia');
	Route::post('/trivia/add', 'TriviaController@postAddTrivia');
	Route::get('/trivia/edit/{id}', 'TriviaController@getEditTrivia');
	Route::post('/trivia/edit', 'TriviaController@postEditTrivia');
	Route::post('/trivia/{trivia_id}/delete', 'TriviaController@postDeleteTrivia');

	//================================ Video Tutorial

	Route::get('/video/tutorial', 'VideoTutorialController@getVideoTutorial');
	Route::get('/video/tutorial/view/{slug}', 'VideoTutorialController@getViewVideoTutorial');
	Route::get('/video/tutorial/list', 'VideoTutorialController@getVideoTutorialList');
	Route::get('/video/tutorial/add', 'VideoTutorialController@getAddVideoTutorial');
	Route::post('/video/tutorial/add', 'VideoTutorialController@postAddVideoTutorial');
	Route::get('/video/tutorial/edit/{id}', 'VideoTutorialController@getEditVideoTutorial');
	Route::post('/video/tutorial/edit', 'VideoTutorialController@postEditVideoTutorial');
	Route::post('/video/tutorial/{video_id}/delete', 'VideoTutorialController@postDeleteVideoTutorial');

	//================================ Property listing

	Route::get('/profile/property/listing', array('as' => 'get-user-property-listing','uses' => 'PropertyController@getuserListingProperty'));

	Route::get('/profile/property/listing/data', array('as' => 'get-user-property-listing','uses' => 'PropertyController@getuserListingPropertyData'));

	Route::get('/profile/property/add', array('as' => 'get-user-property-add','uses' => 'PropertyController@getuserAddProperty'));

	Route::post('/profile/property/add', array('as' => 'post-user-property-add','uses' => 'PropertyController@postuserAddProperty'));

	Route::get('/profile/property/edit/{id}', array('as' => 'get-user-edit-property','uses' => 'PropertyController@getuserEditProperty'));

	Route::post('/profile/property/edit', array('as' => 'post-user-property-edit','uses' => 'PropertyController@postuserEditProperty'));

	Route::post('/property/image/{image_id}/delete', array('as' => 'post-user-property-delete-image','uses' => 'PropertyController@postuserDeleteImage'));

	Route::post('/profile/property/{property_id}/delete', array('as' => 'post-user-delete-property','uses' => 'PropertyController@postuserDeleteProperty'));

	Route::post('/share-link-reward', array('as' => 'post-share-reward','uses' => 'HomeController@postShareLinkRewards'));

	Route::post('/property/{id}/inquire', array('as' => 'post-inquire-property', 'uses' => 'PropertyController@postPropertyInquiry'));

	Route::middleware(['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:150,15'])->group(function () {

		Route::get('/register', 'Auth\RegisterController@getRegister');
		Route::post('/register', 'Auth\RegisterController@postRegister');
		Route::get('/register/confirm-email', 'Auth\AuthController@confirmEmail');
		Route::get('/login', array('as' => 'view-login','uses' => 'Auth\LoginController@getLogin'));
		Route::post('/login', array('as' => 'login','uses' => 'Auth\LoginController@postLogin'));
		Route::post('/logout', array('as' => 'logout','uses' => 'Auth\LoginController@logout'));

		//associate
		Route::get('/dashboard', array('as' => 'get-dashboard','uses' => 'AccountController@getDashboard'));

		
		//terms
		Route::get('/terms-of-use', array('as' => 'get-terms-of-use','uses' => 'AccountController@getTAC'));

		//network
		Route::get('/referrals', array('as' => 'get-referrals','uses' => 'AccountController@getSubscribers'));
		Route::get('/referrals-data', array('as' => 'get-referrals-data','uses' => 'AccountController@getSubscribersData'));
		Route::post('/referrals', array('as' => 'post-referrals','uses' => 'AccountController@postSubscribers'));

	
		//security
		Route::get('/security/pin', array('as' => 'get-security-pin','uses' => 'AccountController@getSecurityPin'));
		Route::post('/security/pin', array('as' => 'post-security-pin','uses' => 'AccountController@postSecurityPin'));
		Route::get('/security/password', array('as' => 'get-security-password','uses' => 'AccountController@getSecurityPassword'));
		Route::post('/security/password', array('as' => 'post-security-password','uses' => 'AccountController@postSecurityPassword'));

		//profile
		Route::get('/profile', array('as' => 'get-profile','uses' => 'AccountController@getProfile'));
		Route::post('/profile', array('as' => 'post-profile','uses' => 'AccountController@postProfile'));
		Route::post('/profile/tin', array('as' => 'post-tin','uses' => 'AccountController@postProfileTin'));
		Route::post('/profile/marketplace', array('as' => 'post-marketplace-connect','uses' => 'AccountController@postProfileMarketplaceConnect'));


	
	});

	Route::middleware(['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:50,15'])->group(function () {
		//account
		Route::get('/account/activation', array('as' => 'get-account-activation','uses' => 'AccountController@getAccountActivation'));
		Route::get('/account/add', array('as' => 'get-add-account','uses' => 'AccountController@getAddAccount'));
		Route::get('/account/my-accounts', array('as' => 'get-accounts','uses' => 'AccountController@getAccounts'));
		Route::get('/account/accounts-data', array('as' => 'get-accounts-data','uses' => 'AccountController@getAccountsData'));
		Route::post('/account/activation', array('as' => 'post-accounts-add','uses' => 'AccountController@postAccountsAdd'));
	
		//e-wallet
		Route::get('/e-wallet/manage', array('as' => 'get-wallet','uses' => 'AccountController@getWallet'));
		Route::middleware('throttle:1,1')->group(function () {
			Route::post('/e-wallet/manage', array('as' => 'post-wallet-move','uses' => 'AccountController@postWalletMove'));
		});
	});

	//ADMIN PANEL
	Route::get('/admin', array('as' => 'get-admin','uses' => 'AdminController@getAdmin'));
	Route::get('/admin-data', array('as' => 'get-admin-data','uses' => 'AdminController@getAdminData'));

	Route::get('/admin/members', array('as' => 'get-admin-members','uses' => 'AdminController@getAdminMembers'));
	Route::post('/admin/members/create', array('as' => 'get-admin-members-create','uses' => 'AdminController@postAdminMembersCreate'));
	Route::get('/admin/members-data', array('as' => 'get-admin-members-data','uses' => 'AdminController@getAdminMembersData'));
	Route::get('/admin/members/{id}', array('as' => 'get-admin-members-info','uses' => 'AdminController@getAdminMembersInfo'));
	Route::post('/admin/members/{id}/profile', array('as' => 'get-admin-members-profile','uses' => 'AdminController@postAdminMembersProfile'));
	Route::post('/admin/members/{id}/password', array('as' => 'get-admin-members-profile','uses' => 'AdminController@postAdminMembersPassword'));
	Route::post('/admin/members/{id}/pin', array('as' => 'get-admin-members-profile','uses' => 'AdminController@postAdminMembersPin'));
	Route::post('/admin/members/{id}/sponsor', array('as' => 'get-admin-members-profile','uses' => 'AdminController@postAdminMembersSponsor'));
	Route::post('/admin/members/{id}/bdo_account', array('as' => 'get-admin-members-bdo-account','uses' => 'AdminController@postAdminMembersBdoAccount'));
	Route::post('/admin/members/{id}/bdo_attempt', array('as' => 'get-admin-members-bdo-attempt','uses' => 'AdminController@postAdminMembersBdoAttempt'));
	Route::post('/admin/members/{id}/yazz_account', array('as' => 'get-admin-members-yazz-account','uses' => 'AdminController@postAdminMembersYazzAccount'));
	Route::get('/admin/members/{id}/data', array('as' => 'get-admin-members-info-data','uses' => 'AdminController@getAdminMembersInfoData'));

	Route::get('/admin/members/retrieve/{id}', array('as' => 'get-admin-retrieve','uses' => 'AdminController@postHelperRetrieve'));
	Route::get('/admin/members/ban/{id}', array('as' => 'get-admin-ban','uses' => 'AdminController@postHelperBan'));

	Route::get('/admin/accounts', array('as' => 'get-admin-accounts','uses' => 'AdminController@getAdminAccounts'));
	Route::get('/admin/accounts-data', array('as' => 'get-admin-accounts-data','uses' => 'AdminController@getAdminAccountsData'));

	//generate codes
	Route::get('/admin/generate-codes', array('as' => 'get-admin-generate-codes','uses' => 'AdminController@getAdminGenerateCodes'));
	Route::post('/admin/generate-codes', array('as' => 'post-admin-generate-codes','uses' => 'AdminController@postAdminGenerateCodes'));

	//leads
	Route::get('/admin/property/add', array('as' => 'get-admin-add-property','uses' => 'AdminController@getAddProperty'));
	Route::get('/admin/properties', array('as' => 'get-admin-properties','uses' => 'AdminController@getProperties'));
	
	Route::get('/admin/properties-data', array('as' => 'get-admin-properties-data','uses' => 'AdminController@getPropertiesData'));
	
	Route::get('/admin/property/edit/{id}', array('as' => 'get-admin-edit-property','uses' => 'AdminController@getEditProperty'));

	Route::post('/admin/property/add', array('as' => 'post-admin-add-property','uses' => 'AdminController@postAddProperty'));

	Route::post('/admin/property/{id}/edit', array('as' => 'post-admin-edit-property','uses' => 'AdminController@postEditProperty'));
	
	Route::post('/admin/property/image/{image_id}/delete', array('as' => 'post-admin-property-delete-image','uses' => 'AdminController@postDeleteImage'));

	Route::post('/admin/property/{property_id}/delete', array('as' => 'post-admin-delete-property','uses' => 'AdminController@postDeleteProperty'));

	Route::get('/admin/suspended', array('as' => 'get-admin-suspended','uses' => 'AdminController@getSuspended'));
	Route::post('/admin/suspended/retrieve', array('as' => 'get-admin-suspended-retrieve','uses' => 'AdminController@postAdminSuspendedRetrieve'));
	Route::post('/admin/suspended/ban', array('as' => 'get-admin-suspended-ban','uses' => 'AdminController@postAdminSuspendedBan'));
	Route::get('/admin/suspended-data', array('as' => 'get-admin-suspended-data','uses' => 'AdminController@getAdminSuspendedData'));


	//activation codes
	Route::get('/admin/activation-codes', array('as' => 'get-admin-activation-codes','uses' => 'AdminController@getAdminActivationCodes'));
	Route::get('/admin/activation-codes-data', array('as' => 'get-admin-activation-codes-data','uses' => 'AdminController@getAdminActivationCodesData'));
	Route::post('/admin/activation-codes/{id}/retrieve', array('as' => 'get-admin-activation-codes-retrieve','uses' => 'AdminController@getAdminActivationCodesRetrieve'));

	Route::get('/admin/transfer-codes', array('as' => 'get-admin-transfer-codes','uses' => 'AdminController@getAdminTransferCodes'));
	Route::get('/admin/transfer-codes-data', array('as' => 'get-admin-transfer-codes-data','uses' => 'AdminController@getAdminTransferCodesData'));
	Route::get('/admin/activation-codes-history', array('as' => 'get-admin-transfer-codes-history','uses' => 'AdminController@getAdminTransferCodesHistory'));
	Route::get('/admin/transfer-codes-data', array('as' => 'get-admin-transfer-codes-data','uses' => 'AdminController@getAdminTransferCodesData'));
	Route::post('/admin/transfer-codes', array('as' => 'post-admin-transfer-codes','uses' => 'AdminController@postAdminTransferCodes'));

	Route::get('/admin/settings', array('as' => 'get-admin-settings','uses' => 'AdminController@getAdminSettings'));
	Route::post('/admin/settings', array('as' => 'post-admin-settings','uses' => 'AdminController@postAdminSettings'));

	Route::get('/admin/interior-design/listing', array('as' => 'get-interior-design-listing','uses' => 'AdminController@getInteriorDesignListing'));
	
	Route::get('/admin/pagination/interior-design/listing', array('as' => 'get-paginate-interior-design-listing','uses' => 'AdminController@getInteriorDesignListingPage'));

	Route::post('/admin/search/interior-design/listing', array('as' => 'get-search-interior-design-listing','uses' => 'AdminController@getInteriorDesignListingSearch'));

	Route::get('/admin/architectural-design/listing', array('as' => 'get-architectural-design-listing','uses' => 'AdminController@getArchitecturalDesignListing'));

	Route::get('/admin/pagination/architectural-design/listing', array('as' => 'get-paginate-architectural-design-listing','uses' => 'AdminController@getArchitecturalDesignListingPage'));

	Route::post('/admin/search/architectural-design/listing', array('as' => 'get-search-architectural-design-listing','uses' => 'AdminController@getArchitecturalDesignListingSearch'));

	//helper PANEL
	Route::get('/helper', array('as' => 'get-helper','uses' => 'HelperController@getHelper'));
	Route::get('/helper-data', array('as' => 'get-helper-data','uses' => 'HelperController@getHelperData'));

	Route::get('/helper/members', array('as' => 'get-helper-members','uses' => 'HelperController@getHelperMembers'));
	Route::get('/helper/members-data', array('as' => 'get-helper-members-data','uses' => 'HelperController@getHelperMembersData'));
	Route::get('/helper/members/{id}', array('as' => 'get-helper-members-info','uses' => 'HelperController@getHelperMembersInfo'));
	Route::post('/helper/members/{id}/profile', array('as' => 'get-helper-members-profile','uses' => 'HelperController@postHelperMembersProfile'));
	Route::post('/helper/members/{id}/password', array('as' => 'get-helper-members-profile','uses' => 'HelperController@postHelperMembersPassword'));
	Route::post('/helper/members/{id}/pin', array('as' => 'get-helper-members-profile','uses' => 'HelperController@postHelperMembersPin'));
	Route::post('/helper/members/{id}/bdo_attempt', array('as' => 'get-helper-members-bdo-attempt','uses' => 'HelperController@postHelperMembersBdoAttempt'));
	Route::post('/helper/members/{id}/yazz_account', array('as' => 'get-helper-members-yazz-account','uses' => 'HelperController@postHelperMembersYazzAccount'));
	Route::get('/helper/members/{id}/data', array('as' => 'get-helper-members-info-data','uses' => 'HelperController@getHelperMembersInfoData'));

	Route::get('/helper/retrieve/{id}', array('as' => 'get-helper-retrieve','uses' => 'HelperController@postHelperRetrieve'));
	Route::get('/helper/ban/{id}', array('as' => 'get-helper-ban','uses' => 'HelperController@postHelperBan'));

	Route::get('/helper/accounts', array('as' => 'get-helper-accounts','uses' => 'HelperController@getHelperAccounts'));
	Route::get('/helper/accounts-data', array('as' => 'get-helper-accounts-data','uses' => 'HelperController@getHelperAccountsData'));

	//leads
	Route::get('/helper/property/add', array('as' => 'get-helper-add-property','uses' => 'HelperController@getAddProperty'));
	Route::get('/helper/properties', array('as' => 'get-helper-properties','uses' => 'HelperController@getProperties'));
	Route::get('/helper/properties-data', array('as' => 'get-helper-properties-data','uses' => 'HelperController@getPropertiesData'));
	Route::get('/helper/leads', array('as' => 'get-helper-lead','uses' => 'HelperController@getLeads'));
	Route::get('/helper/property/edit/{id}', array('as' => 'get-helper-edit-property','uses' => 'HelperController@getEditProperty'));
	Route::post('/helper/property/add', array('as' => 'post-helper-add-property','uses' => 'HelperController@postAddProperty'));
	Route::post('/helper/property/{id}/edit', array('as' => 'post-helper-edit-property','uses' => 'HelperController@postEditProperty'));

	Route::get('/helper/leads', array('as' => 'get-helper-leads','uses' => 'HelperController@getLeads'));
	Route::get('/helper/leads-data', array('as' => 'get-helper-leads-data','uses' => 'HelperController@getLeadsData'));
	Route::get('/helper/leads/{id}', array('as' => 'get-helper-view-lead','uses' => 'HelperController@getLeadDetails'));
	Route::post('/helper/leads/{id}', array('as' => 'post-helper-view-lead','uses' => 'HelperController@postLeadDetails'));


	//activation codes
	Route::get('/helper/activation-codes', array('as' => 'get-helper-activation-codes','uses' => 'HelperController@getHelperActivationCodes'));
	Route::get('/helper/activation-codes-data', array('as' => 'get-helper-activation-codes-data','uses' => 'HelperController@getHelperActivationCodesData'));
	Route::post('/helper/activation-codes/{id}/retrieve', array('as' => 'get-helper-activation-codes-retrieve','uses' => 'HelperController@getHelperActivationCodesRetrieve'));

	Route::get('/helper/transfer-codes', array('as' => 'get-helper-transfer-codes','uses' => 'HelperController@getHelperTransferCodes'));
	Route::get('/helper/transfer-codes-data', array('as' => 'get-helper-transfer-codes-data','uses' => 'HelperController@getHelperTransferCodesData'));
	Route::post('/helper/transfer-codes', array('as' => 'post-helper-transfer-codes','uses' => 'HelperController@postHelperTransferCodes'));

	//Dealers
	Route::get('/dealer', array('as' => 'get-dealer','uses' => 'DealerController@getDealer'));
	Route::get('/dealer-data', array('as' => 'get-dealer-data','uses' => 'DealerController@getDealerData'));

	Route::get('/dealer/transfer-master-fund', array('as' => 'get-dealer-transfer-master-fund','uses' => 'DealerController@getDealerTransferMasterFund'));
	Route::post('/dealer/transfer-master-fund', array('as' => 'get-dealer-transfer-master-fund','uses' => 'DealerController@postDealerTransferMasterFund'));
	Route::get('/dealer/transfer-master-fund-data', array('as' => 'get-dealer-transfer-master-fund-data','uses' => 'DealerController@getDealerTransferMasterFundData'));

	Route::get('/dealer/transfer-codes', array('as' => 'get-dealer-transfer-codes','uses' => 'DealerController@getDealerTransferCodes'));
	Route::get('/dealer/transfer-codes-data', array('as' => 'get-dealer-transfer-codes-data','uses' => 'DealerController@getDealerTransferCodesData'));
	Route::post('/dealer/transfer-codes', array('as' => 'post-dealer-transfer-codes','uses' => 'DealerController@postDealerTransferCodes'));

	//=============================== Architectural Design

	Route::get('/architectural-design/listing', array('as' => 'get-architectural-design-listing','uses' => 'ArchitecturalDesignController@getArchitecturalDesignListing'));

	Route::get('/pagination/architectural-design/listing', array('as' => 'get-paginate-architectural-design-listing','uses' => 'ArchitecturalDesignController@getArchitecturalDesignListingPage'));

	Route::get('/architectural-design/add', array('as' => 'get-architectural-design-add','uses' => 'ArchitecturalDesignController@getAddArchitecturalDesign'));

	Route::post('/architectural-design/add', array('as' => 'get-architectural-design-add','uses' => 'ArchitecturalDesignController@postAddArchitecturalDesign'));

	Route::get('/edit/architectural_design/{id}', array('as' => 'get-architectural-design-edit','uses' => 'ArchitecturalDesignController@getEditArchitecturalDesign'));

	Route::post('/edit/architectural_design', array('as' => 'post-architectural-design-edit','uses' => 'ArchitecturalDesignController@postEditArchitecturalDesign'));

	Route::get('/architectural_design/{architectural_design_id}/delete', array('as' => 'post-architectural-design-delete','uses' => 'ArchitecturalDesignController@postDeleteArchitecturalDesign'));

	//=============================== Interior Design

	Route::get('/interior-design/listing', array('as' => 'get-interior-design-listing','uses' => 'InteriorDesignController@getInteriorDesignListing'));

	Route::get('/pagination/interior-design/listing', array('as' => 'get-paginate-interior-design-listing','uses' => 'InteriorDesignController@getInteriorDesignListingPage'));

	Route::get('/interior-design/add', array('as' => 'get-interior-design-add','uses' => 'InteriorDesignController@getAddInteriorDesign'));

	Route::post('/interior-design/add', array('as' => 'get-interior-design-add','uses' => 'InteriorDesignController@postAddInteriorDesign'));

	Route::get('/interior-design/edit/{id}', array('as' => 'get-interior-design-edit','uses' => 'InteriorDesignController@getEditInteriorDesign'));

	Route::post('/interior-design/edit', array('as' => 'post-interior-design-edit','uses' => 'InteriorDesignController@postEditInteriorDesign'));

	Route::get('/interior_design/{interior_design_id}/delete', array('as' => 'post-interior-design-delete','uses' => 'InteriorDesignController@postDeleteInteriorDesign'));


});
