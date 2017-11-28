<?php

namespace App\Repositories\Community;

use App\Contracts\Community\CommunityRepositoryInterface as CommunityRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Communities\Community as Community;

class CommunityRepository extends AbstractRepository implements CommunityRepoInterface
{
    /**
     * The community model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(Community $community)
    {
        $this->model = $community;
    }

    /**
     * Make community list
     *
     * @param array $queryParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
    */
    public function getCommunityList($queryParameters)
    {
        return $this->model->whereIn(
            ['city_id', $queryParameters['city_id']],
            ['community_type_id', $queryParameters['community_type_id']]
        )->get();
    }
}
