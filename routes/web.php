<?php

use App\Http\Controllers\{Admin\FrontController as AdminFrontController,
    Auth\LoginController,
    City\CityController,
    Company\CompanyController,
    Company\FrontController as CompanyFrontController,
    CompanyFreelancer\FrontController as CompanyFreelancerFrontController,
    Contributor\FrontController as ContributorFrontController,
    CountryController,
    GoogleController,
    HomeController,
    JobController,
    Recruiter\RecruiterEducationController,
    RecruiterController,
    RoleController,
    SubCategoryController,
    UserController,
};
use App\Http\Controllers\CompanyFreelancer\FreelancerController;
use App\Http\Controllers\Contributor\ContributorController;
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
Route::get('/', fn () => view('welcome'));

Auth::routes(['verify' => true]);

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth-google');
Route::get('callback/google/register', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout-route');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/choose/role', [HomeController::class, 'chooseRole'])->name('choose-role');
Route::get('/account/activation-pending', [HomeController::class, 'pendingActivation'])->name('company-pending-activation');

Route::get('/company/dashboard/information/freelancer/create', [HomeController::class, 'createFreelancer'])->name('company-freelancer-create');

Route::post('/choose/role/update', [RoleController::class, 'updateUserRole'])->name('choose-role-update');

Route::get('/proba', [HomeController::class, 'proba']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/subcategories/{categoryId}', [SubCategoryController::class, 'getSubCategoriesByCategory'])->name('subcategories');
    Route::get('/cities/{countryId}', [CityController::class, 'getCitiesByCountry'])->name('cities');
    Route::get('/country/{countryId}/currency', [CountryController::class, 'getCurrency'])->name('currency');

    Route::prefix('user/{id}')->name('user-')->group(function () {
        Route::put('/update-email', [UserController::class, 'userEmailUpdate'])->name('email-update');
        Route::put('/password-update', [UserController::class, 'userPasswordUpdate'])->name('password-update');
    });

    Route::post('/company/update', [CompanyController::class, 'update'])->name('company-update');
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

// Company Routes
Route::middleware(['auth', 'company', 'verified'])->prefix('company/dashboard')->name('company-dashboard-')->group(function () {
    Route::get('/', [CompanyFrontController::class, 'dashboard'])->name('index');
    Route::get('/information/create', [CompanyFrontController::class, 'informationCreate'])->name('information-create');
    Route::post('/store', [CompanyController::class, 'store'])->name('store');

    Route::get('/find/recruiters', [CompanyFrontController::class, 'findRecruiters'])->name('find-recruiters');
    Route::get('/add/employees', [CompanyFrontController::class, 'addEmployees'])->name('add-employees');

    Route::post('/recruiters/call/{recruiter}', [RecruiterController::class, 'callRecruiter'])->name('recruiters-call');
});

// Company Freelancer Routes
Route::middleware(['auth', 'company.freelancer', 'verified'])->prefix('company/freelancer')->name('company-freelancer-')->group(function () {
    Route::get('/dashboard', [CompanyFreelancerFrontController::class, 'dashboard'])->name('dashboard');
    Route::get('/find/companies', [CompanyFreelancerFrontController::class, 'findCompanies'])->name('find-companies');
    Route::get('/find/contributors', [CompanyFreelancerFrontController::class, 'findContributors'])->name('find-contributors');

    Route::get('/edit', [CompanyFreelancerFrontController::class, 'editFreelancer'])->name('freelancer-edit');
    Route::get('/edit/company', [CompanyFreelancerFrontController::class, 'editCompany'])->name('edit-company');

    Route::post('/recruiter/store', [FreelancerController::class, 'store'])->name('recruiter-store');
    Route::post('/update', [FreelancerController::class, 'update'])->name('update');
    Route::put('/update-profile-image', [FreelancerController::class, 'updateProfileImage'])->name('update-profile-image');

    // Education Routes
    Route::post('/education/create', [RecruiterEducationController::class, 'create'])->name('education-create');
    Route::post('/education/update', [RecruiterEducationController::class, 'update'])->name('education-update');

    //Settings Routes
    Route::get('/settings', [CompanyFreelancerFrontController::class, 'settings'])->name('settings');
    Route::post('/make-request', [CompanyFreelancerFrontController::class, 'followCompany'])->name('make-request');

    //Jobs Routes
    Route::get('/company/{company}/details', [CompanyFreelancerFrontController::class, 'detailsCompany'])->name('company-details');
    Route::get('/job/create', [CompanyFreelancerFrontController::class, 'createJob'])->name('create-job');
    Route::post('/job/store', [JobController::class, 'store'])->name('store-job');
    //za dzonija rute
    Route::get('/{job}/recruitment-process', [CompanyFreelancerFrontController::class, 'recruitmentProcess'])->name('recruitment-process');
    Route::get('/job/candidate/{candidate}/recruitment-process', [CompanyFreelancerFrontController::class, 'candidateRecruitmentProcess'])->name('candidat-recruitment-process');
    Route::put('/job/candidate/{candidate}/change-status', [CompanyFreelancerFrontController::class, 'changeCandidateStatus'])->name('candidat-recruitment-process');
    Route::get('/active/jobs', [CompanyFreelancerFrontController::class, 'getActiveJobs'])->name('active-jobs');
    Route::get('/inactive/jobs', [CompanyFreelancerFrontController::class, 'getInactiveJobs'])->name('inactive-jobs');
    Route::get('/job/candidate/{candidate}/plan-meeting', [CompanyFreelancerFrontController::class, 'createMeeting'])->name('create-meeting');
});

//Contributors routes
Route::middleware(['auth', 'contributor', 'verified'])->prefix('contributor')->name('contributor-')->group(function () {
    Route::get('/dashboard', [ContributorFrontController::class, 'index'])->name('dashboard');

    //contributor information profile
    Route::post('/store', [ContributorController::class, 'store'])->name('create');

    Route::middleware(['contributor.exists'])->group(function () {
        Route::get('/companies', [ContributorFrontController::class, 'companies'])->name('companies');
        Route::get('/find-recruiter', [ContributorFrontController::class, 'recruiter'])->name('find-recruiter');

        Route::get('/posts', [ContributorFrontController::class, 'posts'])->name('posts');
        Route::get('/post/create', [ContributorFrontController::class, 'createPosts'])->name('post-create');
        Route::get('/edit', [ContributorFrontController::class, 'edit'])->name('edit');
    });

});
