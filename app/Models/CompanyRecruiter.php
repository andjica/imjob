<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\NewFollowNotification;

class CompanyRecruiter extends Pivot
{
    protected $table = 'company_recruiter';

    protected $fillable = ['recruiter_id', 'company_id', 'from_date', 'until_date', 'status', 'invite_type'];

    public $timestamps = true; // ✅ Osigurava da timestamps funkcionišu.

    // ✅ Osiguraj da Laravel koristi tačno ime tabele
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // ✅ Scope za aktivne veze
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // ✅ Scope za prošle veze
    public function scopePast($query)
    {
        return $query->where('status', 'Past');
    }

    //✅ Ispravljeni mutator koji sada NE MENJA "Rejected"
    // public function getStatusAttribute($value)
    // {
        
    //     if (in_array($value, ['Rejected', 'Pending', 'Past'])) {
    //         return $value;
    //     }
    
       
    //     if ($value === 'Active') {
    //         // Ako `active_from` postoji i prošao je, status ostaje `Active`
    //         if (!is_null($this->active_from) && $this->active_from <= now()) {
    //             return 'Active';
    //         }
    
          
    //         return 'Pending';
    //     }
    
    //     // ✅ Ako `until_date` postoji i prošao je, status je `Past`
    //     if (!is_null($this->until_date) && $this->until_date < now()) {
    //         return 'Past';
    //     }
    
    //     // ✅ Ako ništa drugo ne odgovara, vrati 'Pending'
    //     return 'Pending';
    // }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // ✅ Proveri da li Laravel vidi tačan status direktno iz baze
    public static function checkStatusFromDB($id)
    {
        return self::withoutGlobalScopes()->where('id', $id)->value('status');
    }

    // ✅ Ako kompanija šalje recruiteru zahtev
    public static function getCompaniesFollowRequest()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
            ->where('status', 'Pending')
            ->where('invite_type', 'Company')
            ->get();
    }

    // ✅ Ako recruiter šalje zahtev kompaniji
    public static function getRecruiterFollowRequestToCompanies()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
            ->where('status', 'Pending')
            ->where('invite_type', 'Recruiter')
            ->get();
    }

    // ✅ Prikazuje sve aktivne veze recruiter - kompanija
    public function getAllConnections()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
            ->where('status', 'Active')
            ->get();
    }
}
