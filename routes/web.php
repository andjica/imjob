<?php

use App\Actions\FollowCompany;
use App\Actions\FollowContributor;
use App\Http\Controllers\{
    Admin\FrontController as AdminFrontController,
    Auth\LoginController,
    City\CityController,
    Company\CompanyController,
    Company\FrontController as CompanyFrontController,
    CompanyFreelancer\FreelancerController,
    CompanyFreelancer\FrontController as CompanyFreelancerFrontController,
    Contributor\FrontController as ContributorFrontController,
    Recruiter\FrontController as RecruiterFrontController,
    CompanyFreelancer\FollowController as FollowCompanyController,
    Contributor\FollowController as FollowContributorController,
    CountryController,
    GoogleController,
    HomeController,
    JobController,
    Recruiter\RecruiterEducationController,
    RecruiterController,
    RoleController,
    SubCategoryController,
    UserController,
    Contributor\ContributorController,
    EmailController,
    RecruitmentController
};

use App\Http\Controllers\CompanyFreelancer\FrontController;
use App\Http\Controllers\Contributor\PostController;
use App\Http\Controllers\Front\LandingController;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for your application. These routes are loaded by the
| RouteServiceProvider within a group containing the "web" middleware group.
|
*/

// Public Routes
Route::get('/', fn() => view('welcome'));

Auth::routes(['verify' => true]);

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth-google');
Route::get('callback/google/register', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout-route');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/choose/role', [HomeController::class, 'chooseRole'])->name('choose-role');
Route::get('/account/activation-pending', [HomeController::class, 'pendingActivation'])->name('company-pending-activation');

Route::get('/company/dashboard/information/freelancer/create', [HomeController::class, 'createFreelancer'])->name('company-freelancer-create');
Route::get('/recruiter/create', [HomeController::class, 'createFreelancer'])->name('recruiter-create');
Route::post('/choose/role/update', [RoleController::class, 'updateUserRole'])->name('choose-role-update');

Route::get('/proba', [HomeController::class, 'proba']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/subcategories/{categoryId}', [SubCategoryController::class, 'getSubCategoriesByCategory'])->name('subcategories');
    Route::get('/cities/{countryId}', [CityController::class, 'getCitiesByCountry'])->name('cities');
    Route::get('/country/{countryId}/currency', [CountryController::class, 'getCurrency'])->name('currency');
    Route::get('/country/{countryId}/phone-code', [CountryController::class, 'getPhoneCode'])->name('phone');

    Route::prefix('user/{id}')->name('user-')->group(function () {
        Route::put('/update-email', [UserController::class, 'userEmailUpdate'])->name('email-update');
        Route::put('/password-update', [UserController::class, 'userPasswordUpdate'])->name('password-update');
    });

    Route::post('/company/update', [CompanyController::class, 'update'])->name('company-update');
    Route::post('/job/store', [JobController::class, 'store'])->name('store-job');
    Route::put('/job/{id}/update', [JobController::class, 'update'])->name('update-job');

});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin/dashboard')->name('admin-dashboard-')->group(function () {
    Route::get('/', [AdminFrontController::class, 'dashboard'])->name('index');
    Route::get('/companies', [AdminFrontController::class, 'companies'])->name('companies');
    Route::get('/recruiters', [AdminFrontController::class, 'recruiters'])->name('recruiters');
    Route::get('/recruiter/profile/{id}', [AdminFrontController::class, 'recruiters'])->name('recruiter-profile');

    Route::get('/notifications', [AdminFrontController::class, 'notifications'])->name('notifications');
    Route::get('/jobs', [AdminFrontController::class, 'jobs'])->name('jobs');

    // Company Approval Routes
    Route::post('/company/{id}/accept', [CompanyController::class, 'accept'])->name('company-accept');
    Route::post('/company/{id}/reject', [CompanyController::class, 'reject'])->name('company-reject');
});

// Company Routes - Basic - Agency
Route::middleware(['auth', 'company', 'verified'])->prefix('company/dashboard')->name('company-dashboard-')->group(function () {
    Route::get('/', [CompanyFrontController::class, 'dashboard'])->name('index');
    Route::get('/information/create', [CompanyFrontController::class, 'informationCreate'])->name('information-create');

    Route::post('/store', [CompanyController::class, 'store'])->name('store');

    //recruiters list
    Route::get('/find/recruiters', [CompanyFrontController::class, 'findRecruiters'])->name('find-recruiters');
    Route::post('/recruiters/call/{recruiter}', [RecruiterController::class, 'callRecruiter'])->name('recruiters-call');
    Route::get('/recruiter/{id}/view', [CompanyFrontController::class, 'getRecruiter'])->name('recruiter-view');
    //jobs
    Route::get('/job/create', [CompanyFrontController::class, 'createJob'])->name('create-job');
    Route::get('/active/jobs', [CompanyFrontController::class, 'getActiveJobs'])->name('active-jobs');
    Route::get('/active/jobs/by/recruiter/{recruiterId}', [CompanyFrontController::class, 'getActiveJobsByRecruiter'])->name('active-jobs-by-recruiterid');
    Route::get('/jobs/in/recruitment-process', [CompanyFrontController::class, 'getjobsInRecruitmentProcess'])->name('job-in-recruitment-process');
    Route::get('/active/recruiters', [CompanyFrontController::class, 'getActiveRecruiters'])->name('active-recruiters');
    Route::get('/inactive/jobs', [CompanyFrontController::class, 'getInactiveJobs'])->name('inactive-jobs');

    //recruitment process
    //ruta za backbutton
    Route::get('/{job}/recruitment-process', [CompanyFrontController::class, 'recruitmentProcess'])->name('recruitment-process');
    Route::get('/job/candidate/{candidate}/recruitment-process', [CompanyFrontController::class, 'candidateRecruitmentProcess'])->name('candidat-recruitment-process');

    //profile
    Route::get('/settings', [CompanyFrontController::class, 'settings'])->name('settings');
    Route::get('/company/{company}/details', [CompanyFrontController::class, 'detailsCompany'])->name('company-details');
    Route::get('/edit', [CompanyFrontController::class, 'editCompany'])->name('edit-company');

    //follow and connections
    Route::post('/make-connection/change-status', [FollowCompanyController::class, 'changeStatus'])->name('follow-change-status');
    Route::post('/make-request', [FollowCompanyController::class, 'followRecruiter'])->name('make-request');
    Route::get('/add/employees', [CompanyFrontController::class, 'addEmployees'])->name('add-employees');
    Route::post('/status-change/to-delete', [FollowCompanyController::class, 'delete'])->name('status-change-to-delete');
    //email
    Route::post('/email/emoloyee-invitation', [EmailController::class, 'sendToEmployee'])->name('email-to-employeee');


    Route::get('/notifications', [CompanyFrontController::class, 'getNotifications'])->name('notifications');
    Route::get('/connections', [CompanyFrontController::class, 'getConnections'])->name('connections');
});

// Company Freelancer Routes
Route::middleware(['auth', 'company.freelancer', 'verified'])->prefix('company/freelancer')->name('company-freelancer-')->group(function () {

    Route::post('/recruiter/store', [FreelancerController::class, 'store'])->name('recruiter-store');

    Route::middleware(['recruiter.finish.profile'])->group(function () {
        Route::get('/dashboard', [CompanyFreelancerFrontController::class, 'dashboard'])->name('dashboard');
        Route::get('/find/companies', [CompanyFreelancerFrontController::class, 'findCompanies'])->name('find-companies');
        Route::get('/find/contributors', [CompanyFreelancerFrontController::class, 'findContributors'])->name('find-contributors');

        Route::get('/edit', [CompanyFreelancerFrontController::class, 'editFreelancer'])->name('freelancer-edit');
        Route::get('/edit/company', [CompanyFreelancerFrontController::class, 'editCompany'])->name('edit-company');

        Route::post('/update', [FreelancerController::class, 'update'])->name('update');
        Route::put('/update-profile-image', [FreelancerController::class, 'updateProfileImage'])->name('update-profile-image');

        // Education Routes
        Route::post('/education/create', [RecruiterEducationController::class, 'create'])->name('education-create');
        Route::post('/education/update', [RecruiterEducationController::class, 'update'])->name('education-update');

        //Settings Routes
        Route::get('/settings', [CompanyFreelancerFrontController::class, 'settings'])->name('settings');

        //follow and make connection Routes
        Route::post('/make-request', [FollowCompanyController::class, 'followCompany'])->name('make-request');
        Route::post('/make-connection', [FollowCompanyController::class, 'followContributor'])->name('follow-contributor');
        Route::post('/make-connection/change-status', [FollowCompanyController::class, 'changeStatus'])->name('follow-change-status');
        Route::post('/make-connection/accept-contributor', [FollowContributorController::class, 'acceptContributor'])->name('make-connection-accept-contributor');
        // view profile
        Route::get('/view', [FrontController::class, 'getProfile'])->name('view');
        Route::get('/contributor/{contributor}/details',[FrontController::class, 'detailsContributor'])->name('contributor-details');

        //Jobs Routes
        Route::get('/company/{company}/details', [CompanyFreelancerFrontController::class, 'detailsCompany'])->name('company-details');
        Route::get('/job/create', [CompanyFreelancerFrontController::class, 'createJob'])->name('create-job');
        Route::post('/job/store', [JobController::class, 'store'])->name('store-job');
        Route::get('/job/{id}/edit', [JobController::class, 'edit'])->name('edit-job');
        Route::put('/job/{id}/update', [JobController::class, 'update'])->name('update-job');
        Route::get('/active/jobs', [CompanyFreelancerFrontController::class, 'getActiveJobs'])->name('active-jobs');
        Route::get('/inactive/jobs', [CompanyFreelancerFrontController::class, 'getInactiveJobs'])->name('inactive-jobs');

        //recruitment and jobs
        Route::get('/{job}/recruitment-process', [CompanyFreelancerFrontController::class, 'recruitmentProcess'])->name('recruitment-process');
        Route::get('/job/candidate/{candidate}/recruitment-process', [CompanyFreelancerFrontController::class, 'candidateRecruitmentProcess'])->name('candidat-recruitment-process');
        Route::put('/job/candidate/{candidate}/change-status', [CompanyFreelancerFrontController::class, 'changeCandidateStatus'])->name('candidat-recruitment-process');
        Route::post('/job/candidate/{candidate}/plan-meeting', [CompanyFreelancerFrontController::class, 'createMeeting'])->name('create-meeting');
        Route::post('/recruitment-subphase/{subphase}/delete', [CompanyFreelancerFrontController::class, 'deleteSubphase'])->name('delete-subphase');
        Route::post('/recruitment-subphase/{subphase}/complete', [CompanyFreelancerFrontController::class, 'completeSubphase'])->name('complete-subphase');
        Route::post('/recruitment-process/{process}/advance', [CompanyFreelancerFrontController::class, 'advanceProcess'])->name('advance-process');
        Route::post('/finish/recruitment-process', [RecruitmentController::class, 'finishRecruitmentProcess'])->name('finish-recruitment-process');
        
        //pdf recruitment
        Route::get('/recruitment/download-pdf/{recruitment_process_id}', [RecruitmentController::class, 'downloadPDF'])->name('recruitment-download.pdf');

        //notifications and connections
        Route::get('/notifications', [CompanyFreelancerFrontController::class, 'notifications'])->name('notifications');
        Route::get('/connections', [CompanyFreelancerFrontController::class, 'connections'])->name('connections');
    });
});

//Recruter routes
Route::middleware(['auth', 'recruiter', 'verified'])->prefix('recruiter')->name('recruiter-')->group(function () {
    Route::middleware(['recruiter.finish.profile'])->group(function () {
        Route::get('/dashboard', [RecruiterFrontController::class, 'dashboard'])->name('dashboard');

        Route::get('/find/companies', [RecruiterFrontController::class, 'findCompanies'])->name('find-companies');
        Route::get('/find/contributors', [RecruiterFrontController::class, 'findContributors'])->name('find-contributors');
        // Jobs
        Route::get('/job/create', [RecruiterFrontController::class, 'createJob'])->name('create-job');
        Route::get('/active/jobs', [RecruiterFrontController::class, 'getActiveJobs'])->name('active-jobs');
        Route::get('/inactive/jobs', [RecruiterFrontController::class, 'getInactiveJobs'])->name('inactive-jobs');
        
        //recruitment process
        Route::get('/{job}/recruitment-process', [RecruiterFrontController::class, 'recruitmentProcess'])->name('recruitment-process');
        Route::get('/job/candidate/{candidate}/recruitment-process', [RecruiterFrontController::class, 'candidateRecruitmentProcess'])->name('candidat-recruitment-process');
        Route::put('/job/candidate/{candidate}/change-status', [RecruiterFrontController::class, 'changeCandidateStatus'])->name('candidat-recruitment-process');
        Route::post('/recruitment-process/{process}/advance', [RecruiterFrontController::class, 'advanceProcess'])->name('advance-process');
        Route::post('/job/candidate/{candidate}/plan-meeting', [RecruiterFrontController::class, 'createMeeting'])->name('create-meeting');
        Route::post('/recruitment-subphase/{subphase}/complete', [RecruiterFrontController::class, 'completeSubphase'])->name('complete-subphase');
        Route::post('/recruitment-subphase/{subphase}/delete', [RecruiterFrontController::class, 'deleteSubphase'])->name('delete-subphase');
        Route::post('/finish/recruitment-process', [RecruitmentController::class, 'finishRecruitmentProcess'])->name('finish-recruitment-process');
        
        //download pdf
        Route::get('/recruitment/download-pdf/{recruitment_process_id}', [RecruitmentController::class, 'downloadPDF'])->name('recruitment-download.pdf');

        Route::get('/edit', [RecruiterFrontController::class, 'editRecruiter'])->name('edit');
        Route::post('/update', [RecruiterFrontController::class, 'update'])->name('update');

        // Education Routes
        Route::post('/education/create', [RecruiterEducationController::class, 'create'])->name('education-create');
        Route::post('/education/update', [RecruiterEducationController::class, 'update'])->name('education-update');

        Route::get('/settings', [RecruiterFrontController::class, 'settings'])->name('settings');

        //follow 
        Route::post('/make-request-company', [FollowCompanyController::class, 'followCompany'])->name('make-request-company');
        Route::post('/make-request-contributor', [FollowCompanyController::class, 'followContributor'])->name('make-request-contributor');

        //view
        Route::get('/company/{company}/details', [RecruiterFrontController::class, 'detailsCompany'])->name('company-details');
        Route::get('/contributor/{contributor}/details', [RecruiterFrontController::class, 'detailsContributor'])->name('contributor-details');
    
    
        //notifications
        Route::get('/notifications', [RecruiterFrontController::class, 'notifications'])->name('notifications');
        Route::get('/connections', [RecruiterFrontController::class, 'connections'])->name('connections');

    });
});


//Contributors routes
Route::middleware(['auth', 'contributor', 'verified'])->prefix('contributor')->name('contributor-')->group(function () {
    Route::get('/dashboard', [ContributorFrontController::class, 'index'])->name('dashboard');

    //contributor information profile
    Route::post('/store', [ContributorController::class, 'store'])->name('create');

    Route::get('/settings', [ContributorFrontController::class, 'settings'])->name('settings');

    Route::middleware(['contributor.exists'])->group(function () {

        Route::post('/update', [ContributorController::class, 'update'])->name('update');
        //ruta za ajax
        Route::post('/make-request', [FollowContributorController::class, 'followRecruiter'])->name('make-request');

        Route::get('/find/companies', [ContributorFrontController::class, 'findCompanies'])->name('find-companies');
        Route::get('/find/recruiters', [ContributorFrontController::class, 'findRecruiters'])->name('find-recruiter');

        Route::get('/company/{id}/details', [ContributorFrontController::class, 'detailsCompany'])->name('company-details');
        //posts
        Route::get('/posts', [ContributorFrontController::class, 'allPost'])->name('posts');
        Route::get('/post/create', [ContributorFrontController::class, 'createPost'])->name('post-create');
        Route::post('/post/store', [PostController::class, 'store'])->name('post-store');
        Route::get('/edit', [ContributorFrontController::class, 'edit'])->name('edit');

        //connection
        Route::get('/connections', [ContributorFrontController::class, 'getActiveConnections'])->name('connections');

        Route::get('/settings', [ContributorFrontController::class, 'settings'])->name('settings');
    });
});
//Landing routes
Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/contact-us', [LandingController::class, 'getContactUs'])->name('contact-us');
Route::get('/about-us', [LandingController::class, 'getAboutUs'])->name('about-us');
