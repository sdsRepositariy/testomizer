<?php

namespace App\Http\Controllers\Users\Students;

use App\Models\Users\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\Grade as Grade;
use App\Http\Requests\ValidateStudentDownloadRequest as ValidateStudentDownloadRequest;

class DownloadUserListController extends Controller
{
    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['level', 'stream', 'last_name'];

    /**
     * The sort orders.
     *
     * @var array
     */
    protected $sortOrder = ['asc', 'desc'];

    /**
     * The defaults for sorting.
     *
     * @var array
     */
    protected $sortDefault = [
        'sort' => 'last_name',
        'order' => 'asc',
    ];
    
    /**
     * Download the student list.
     *
     * @param  ValidateStudentDownloadRequest $request
     * @return \Illuminate\Http\Response
    */
    public function download(ValidateStudentDownloadRequest $request)
    {
        //Get input
        $input = $request->query();

        if (isset($input['status'])) {
            $filterUser['status'] = $input['status'];
        } else {
            $filterUser['status'] = 'active';
        }

        if (isset($input['level'])) {
            $filterGrade['level'] = $input['level'];
        } else {
            $filterGrade['level'] = null;
        }

        if (isset($input['stream'])) {
            $filterGrade['stream'] = $input['stream'];
        } else {
            $filterGrade['stream'] = null;
        }

        if (isset($input['search'])) {
            $search = $input['search'];
        } else {
            $search = null;
        }

        if (isset($input['sort']) && in_array($input['sort'], $this->sortable, true)) {
            $sort = $input['sort'];
        } else {
            $sort = $this->sortDefault['sort'];
        }

        if (isset($input['order']) && in_array($input['order'], $this->sortOrder, true)) {
            $order = $input['order'];
        } else {
            $order = $this->sortDefault['order'];
        }

        $filterUser['community'] = $input['community'];

        $filterGrade['period'] = $input['period'];

        //Get grades id
        $grade = new Grade();
        $gradesId = $grade->getGradesId($filterUser['community'], $filterGrade);

        //Get user list
        $user = new User();
        $users = $user->getStudents($sort, $order, $filterUser, $gradesId, $search)->get();

        //Prepare list
        $list = array();

        foreach ($users as $user) {
            array_push($list, array(
                    'Level' => $user->level,
                    'Stream' => $user->stream,
                    'Last name' => $user->last_name,
                    'First name' => $user->first_name,
                    'Middle name' => $user->middle_name,
                    'Login' => $user->login,
                    'Password' => $user->password,
                ));
        }
        
        unset($users);

        $this->createSheet($list);
    }

    /**
     * Create a sheet.
     *
     * @param  array $list
     * @return void
    */
    protected function createSheet($list)
    {
        \Excel::create('Students', function ($excel) use ($list) {
            $excel->sheet('Students', function ($sheet) use ($list) {
                $sheet->fromArray($list);

                $rows = count($list)+1;

                //Make borders
                $sheet->setBorder('A1:G'.$rows.'', 'thin');

                //Center cells
                $sheet->cells('A1:G'.$rows.'', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                //Set row height
                for ($i=0; $i<=$rows; $i++) {
                    $sheet->setHeight($i, 30);
                }
            });
        })->download('xlsx');
    }
}
