<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    UserController,
    GoogleController,
    RecruiterController,
    SubCategoryController,
    City\CityController,
    Company\CompanyController,
    Company\FrontController as CompanyFrontController,
    CompanyFreelancer\FrontController as CompanyFreelancerFrontController,
    CompanyFreelancer\FreelancerController,
    Recruiter\RecruiterEducationController,
    RoleController,
    Auth\LoginController,
    Admin\FrontController as AdminFrontController,
    CountryController,
    JobController
};
use App\Models\RecruiterEducation;

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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

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

    Route::get('/edit', [CompanyFreelancerFrontController::class, 'editFreelancer'])->name('freelancer-edit');
    Route::get('/edit/company', [CompanyFreelancerFrontController::class, 'editCompany'])->name('edit-company');


    Route::post('/recruiter/store', [FreelancerController::class, 'store'])->name('recruiter-store');
    Route::post('/update', [FreelancerController::class, 'update'])->name('update');
    Route::put('/update-profile-image', [FreelancerController::class, 'updateProfileImage'])->name('update-profile-image');

    // Education Routes
    Route::post('/education/create', [RecruiterEducationController::class, 'create'])->name('education-create');
    Route::post('/education/update', [RecruiterEducationController::class, 'update'])->name('education-update');

    Route::get('/settings', [CompanyFreelancerFrontController::class, 'settings'])->name('settings');
    Route::post('/make-request', [CompanyFreelancerFrontController::class, 'followCompany'])->name('make-request');

    //za dzonija
    Route::get('/company/{companyId}/details', [CompanyFreelancerFrontController::class, 'detailsCompany'])->name('company-details');
    Route::get('/job/create', [CompanyFreelancerFrontController::class, 'createJob'])->name('create-job');

    //za dzonija store job
    Route::post('/job/store', [JobController::class, 'store'])->name('store-job');
});
