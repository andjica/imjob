<?php

namespace App\Models;




use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recruiters()
    {
        return $this->belongsToMany(Recruiter::class, 'company_recruiter')
        ->using(CompanyRecruiter::class) // Specify the custom pivot model
        ->withPivot('from_date', 'until_date', 'status')
        ->withTimestamps();
    }

    //if user is freelancer he need to have only one company
    public function freelancerCompany()
    {
        return $this->hasOne(FreelancerCompany::class, 'company_id');
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }
}
