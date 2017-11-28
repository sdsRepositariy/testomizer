<?php

namespace App\Repositories\Community;

use App\Contracts\Community\CommunityTypeRepositoryInterface as CommunityTypeRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Communities\CommunityType as CommunityType;

class CommunityTypeRepository extends AbstractRepository implements CommunityTypeRepoInterface
{
    /**
     * The community type model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(CommunityType $communityType)
    {
        $this->model = $communityType;
    }
}
