<?php

namespace App\Repositories\Users;

use App\Contracts\Users\UserRepositoryInterface as UserRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Users\User as User;

class UserRepository extends AbstractRepository implements UserRepoInterface
{
    /**
     * The user model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get authenticated user city.
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getAuthUser()
    {
        return $this->model->find(\Auth::user()->id);
    }
}
