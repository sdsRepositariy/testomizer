<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Users\User as User;

class HandleSorting
{
    /**
     * The defaults for sorting e.g. ["sort" => "name", "order" => "asc"].
     *
     * @var array
     */
    protected $sortDefault = [];

    /**
     * The sort orders.
     *
     * @var array
     */
    protected $sortOrder = ['asc', 'desc'];

    /**
     * The attributes that can be sorted e.g. ['name', 'last_name', 'age'].
     *
     * @var array
     */
    protected $sortable = [];

    /**
     * The key string for session storage.
     *
     * @var string
     */
    protected $sessionKey = "";

    /**
     * Set sorting parameters.
     *
     * @param array $sortDefault
     * @param array $sortable
     * @param string $sessionKey
     * @param array $sortOrder
     *
     * @return void
     */
    public function setParameters($sortDefault, $sortable, $sessionKey, $sortOrder = null)
    {
        $this->sortDefault = $sortDefault;
        $this->sortable = $sortable;
        $this->sessionKey = $sessionKey;

        if ($sortOrder != null) {
            $this->sortOrder = $sortOrder;
        }
    }


    /**
     * The function:
     *  - retrives sort data;
     *  - stores it in the session;
     *  - if $queryString doesnt contain proper data takes stored data or default;
     *  - builds HTTP url for sotable data with sorted flag (true or false)
     *
     * @param  Request  $request
     * @return array
     */
    public function getSorting(Request $request)
    {
        $queryString = $request->query();

        //Sort
        if (isset($queryString['sort']) && in_array($queryString['sort'], $this->sortable, true)) {
            $sort = $queryString['sort'];
            session([$this->sessionKey.".sort" => $sort]);
        } else {
            $sort = session($this->sessionKey.".sort", $this->sortDefault['sort']);
        }

        //Order
        if (isset($queryString['order']) && in_array($queryString['order'], $this->sortOrder, true)) {
            $order = $queryString['order'];
            session([$this->sessionKey.".order" => $order]);
        } else {
            $order = session($this->sessionKey.".order", $this->sortDefault['order']);
        }

        //Data for DB query
        $sortData["query"] = [
            'sort' => $sort,
            'order' => $order,
        ];

        //Inverse sort order to make a loop for sorting
        if ($order == 'asc') {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        //Build HTTP url
        foreach ($this->sortable as $sortable) {
            $sortData[$sortable] = [
                "url" => url($request->path())."?".http_build_query(['sort' => $sortable, 'order' => $order]),
                "sorted" => $sortable == $sort ? $sortData["query"]["order"] : false,
            ];
        }

        return $sortData;
    }
}
