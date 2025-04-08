<?php

namespace App\Providers;

use App\Interfaces\CandidateProfileInterface;
use App\Services\JobServices;
use App\Services\CityServices;
use App\Services\PostServices;
use App\Services\RoleServices;
use App\Interfaces\JobInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\RoleInterface;
use App\Services\CompanyServices;
use App\Services\CountryServices;
use App\Services\JobTypeServices;
use App\Services\CategoryServices;
use App\Services\RecruiterServices;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\JobTypeInterface;
use App\Services\ContributorService;
use App\Services\ContributorServies;
use App\Services\FreelancerServices;
use App\Interfaces\CategoryInterface;
use App\Services\CompanyTypeServices;
use App\Services\ContributorServices;
use App\Services\SubCategoryServices;
use App\Interfaces\RecruiterInterface;
use App\Interfaces\FreelancerInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\CompanyTypeInterface;
use App\Interfaces\ContributorInterface;
use App\Interfaces\SubCategoryInterface;
use App\Services\ContributorTypeServices;
use Illuminate\Support\Facades\Broadcast;
use App\Services\CompanyRecruiterServices;
use App\Services\CompanyFreelancerServices;
use App\Services\RecruitmentProcessService;
use App\Interfaces\ContributorTypeInterface;
use App\Services\RecruiterEducationServices;
use App\Interfaces\CompanyRecruiterInterface;
use App\Interfaces\CompanyFreelancerInterface;
use App\Services\ContributorRecruiterServices;
use App\Interfaces\RecruiterEducationInterface;
use App\Interfaces\RecruitmentProcessInterface;
use App\Interfaces\ContributorRecruiterInterface;
use App\Services\CandidateProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompanyInterface::class, CompanyServices::class);
        $this->app->bind(RecruiterInterface::class, RecruiterServices::class);
        $this->app->bind(RoleInterface::class, RoleServices::class);
        $this->app->bind(CountryInterface::class, CountryServices::class);
        $this->app->bind(CityInterface::class, CityServices::class);
        $this->app->bind(CompanyTypeInterface::class, CompanyTypeServices::class);
        $this->app->bind(CategoryInterface::class, CategoryServices::class);
        $this->app->bind(SubCategoryInterface::class, SubCategoryServices::class);
        $this->app->bind(CompanyFreelancerInterface::class, CompanyFreelancerServices::class);
        $this->app->bind(FreelancerInterface::class, FreelancerServices::class);
        $this->app->bind(RecruiterEducationInterface::class, RecruiterEducationServices::class);
        $this->app->bind(JobTypeInterface::class, JobTypeServices::class);
        $this->app->bind(ContributorTypeInterface::class, ContributorTypeServices::class);
        $this->app->bind(ContributorInterface::class, ContributorServices::class);
        $this->app->bind(CompanyRecruiterInterface::class, CompanyRecruiterServices::class);
        $this->app->bind(PostInterface::class, PostServices::class);
        $this->app->bind(ContributorRecruiterInterface::class, ContributorRecruiterServices::class);
        $this->app->bind(RecruitmentProcessInterface::class, RecruitmentProcessService::class);
        $this->app->bind(CandidateProfileInterface::class, CandidateProfileService::class);
        $this->app->bind(ChatInterface::class, ChatService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
        require_once app_path('Helpers/helpers.php');
    }
}
