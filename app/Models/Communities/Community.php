<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\City as City;
use App\Models\Communities\CommunityType as CommunityType;
use App\Models\Users\Grade as Grade;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Level as Level;
use App\Models\Users\Period as Period;
use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;

class Community extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['community_type_id', 'city_id', 'number', 'name'
    ];

    /**------------Model relationships------------*/
    
    //Get the city associated with the community.
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //Get the community type associated with the community.
    public function communityType()
    {
        return $this->belongsTo(CommunityType::class);
    }

    //Get grades associated with the community.
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    //Get streams associated with the community.
    public function streams()
    {
        return $this->belongsToMany(Stream::class, 'grades');
    }

    //Get levels associated with the community.
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'grades');
    }

    //Get periods associated with the community.
    public function periods()
    {
        return $this->belongsToMany(Period::class, 'grades');
    }

    //Get the users for the community.
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //Get roles associated with the community.
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users');
    }

    /**
     * Get communities.
     *
     * @param string $sort
     * @param string $order
     * @param array $filters
     *
     * @return Illuminate\Database\Query\Builder
    */
    public function getCommunities($filter, $sort = null, $order = null)
    {
        $query = \DB::table('communities')
            ->select(
                'countries.id as country_id',
                'countries.name as country',
                'regions.id as region_id',
                'regions.name as region',
                'cities.id as city_id',
                'cities.name as city',
                'community_types.id as community_type_id',
                'community_types.name as community_type',
                'communities.*'
            )
            ->join('cities', 'communities.city_id', '=', 'cities.id')
            ->join('regions', 'cities.region_id', '=', 'regions.id')
            ->join('countries', 'regions.country_id', '=', 'countries.id')
            ->join('community_types', 'communities.community_type_id', '=', 'community_types.id');

        foreach ($filter as $key => $value) {
            if (!empty($value)) {
                $query->where($key.'_'.'id', $value);
            }
        }

        if ($sort != null & $order != null) {
            $query->orderBy($sort, $order);
        }

        return $query;
    }
}
