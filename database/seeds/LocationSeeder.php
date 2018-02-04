<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    /**
     * The pattern for the first level.
     *
     * @var string patternFirstLevel
     */
    protected $patternFirstLevel = '/^\d{2}0{8}$/';

    /**
     * The pattern for the second level.
     *
     * @var string patternSecondLevel
     */
    protected $patternSecondLevel = '/^\d{3}(?!00)\d{2}0{5}$/';

    /**
     * The pattern for the third level.
     *
     * @var string patternThirdLevel
     */
    protected $patternThirdLevel = '/^\d{5}[1,3-9](?!00)\d{2}0{2}$/';

    /**
     * The pattern for the fourth level.
     *
     * @var string patternFourthlevel
     */
    protected $patternFourthLevel = '/^\d{8}(?!00)\d{2}$/';

    /**
     * The abbreviation for cities
     *
     * @var string abbr
     */
    protected $abbr = array(
        'М' => 'м.',
        'С' => 'с.',
        'Щ' => 'с-ще',
        'Т' => 'смт',
        'Р' => 'р-н'
        );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->parseList();
    }

    /**
     * The level hadler.
     *
     * @return void
     */
    protected function parseList()
    {
        // $output = new Symfony\Component\Console\Output\ConsoleOutput();

        $result = \Excel::selectSheetsByIndex(0)->load('storage/app/admin/KOATUU_18122017.xls')->get();
        // $alter = 'KOATUU_18122017.xls';

        foreach ($result as $row) {
            $level = $this->getFirstLevel($row);

            if ($level) {
                $firstLevelKey = $level[0];
                $firstLevel = $level[1];

                $regionId = $this->seedRegion($firstLevel);
            } else {
                $level = $this->getSecondLevel($row);

                if ($level) {
                    $secondLevelKey = $level[0];

                    //The district regions joined to the first level
                    if (substr($secondLevelKey, 2, 1) == 2) {
                        $secondLevel = false;
                        $regionId = $this->seedRegion($firstLevel.'/'.$level[1]);
                    } else {
                        $secondLevel = $level[1];
                        $this->seedCity($secondLevel, $regionId);
                    }
                } else {
                    $level = $this->getThirdLevel($row);

                    if ($level) {
                        $thirdLevelKey = $level[0];

                        if ($secondLevel) {
                            $thirdLevel = $level[1].'/'.$secondLevel;
                        } else {
                            $thirdLevel = $level[1];
                        }
                        
                        //Eclude numbers 3, 8, 9 from sixth grade
                        $sixthGrade = substr($thirdLevelKey, 5, 1);

                        if ($sixthGrade != 3 && $sixthGrade != 8 && $sixthGrade != 9) {
                            $this->seedCity($thirdLevel, $regionId);
                        }
                    } else {
                        $level = $this->getFourthLevel($row);

                        if ($level) {
                            $fourthLevelKey = $level[0];

                            if (substr($fourthLevelKey, 0, 8) == substr($thirdLevelKey, 0, 8)) {
                                $fourthLevel = $level[1].'/'.$thirdLevel;
                            } else {
                                $fourthLevel = $level[1].'/'.$secondLevel;
                            }

                            $this->seedCity($fourthLevel, $regionId);
                        }
                    }
                }
            }
        }

        // $output->writeln(dd($this->region));
    }

     /**
     * Get first level.
     *
     * @param  object $row
     * @return mixed
     */
    protected function getFirstLevel($row)
    {
        if (preg_match($this->patternFirstLevel, $row->te)) {
            return array($row->te, $this->getName($row->nu, $row->np));
        } else {
            return false;
        }
    }

     /**
     * Get second level.
     *
     * @param  object $row
     * @return mixed
     */
    protected function getSecondLevel($row)
    {
        if (preg_match($this->patternSecondLevel, $row->te, $matches)) {
            return array($row->te, $this->getName($row->nu, $row->np));
        } else {
            return false;
        }
    }

    /**
     * Get third level.
     *
     * @param  object $row
     * @return mixed
     */
    protected function getThirdLevel($row)
    {
        if (preg_match($this->patternThirdLevel, $row->te)) {
            //Exclude intro line for 'смт'
            if (preg_match('/^\d{5}[4-6](?!0)\d0{3}$/', $row->te) && empty($row->np)) {
                return false;
            }

            return array($row->te, $this->getName($row->nu, $row->np));
        } else {
            return false;
        }
    }

    /**
     * Get fourth level.
     *
     * @param  object $row
     * @return mixed
     */
    protected function getFourthLevel($row)
    {
        if (preg_match($this->patternFourthLevel, $row->te)) {
            return array($row->te, $this->getName($row->nu, $row->np));
        } else {
            return false;
        }
    }

    /**
     * Get location name.
     *
     * @param  string  $nu
     * @param  string  $np
     *
     * @return string $name
     */
    protected function getName($nu, $np)
    {
        if (preg_match('/(ОБЛАСТЬ)/u', $nu)) {
            $name = title_case(strstr($nu, ' ОБЛАСТЬ', true)).' обл.';
        } elseif (preg_match('/(РАЙОН)/u', $nu)) {
            $name = title_case(strstr($nu, ' РАЙОН', true)).' р-н';
        } elseif (preg_match('/\//', $nu)) {
            $name = title_case(strstr($nu, '/', true));
        } elseif (preg_match('/^(М\.)/u', $nu)) {
            $name = title_case(substr($nu, strpos($nu, '.')+1)).' м.';
        } elseif (isset($this->abbr[$np])) {
            $name = title_case($nu).' '.$this->abbr[$np];
        } else {
            $name = title_case($nu).' м.';
        }

        return $name;
    }

    /**
     * Seed the region table.
     *
     * @param  string $region
     * @return int $regionId
     */
    protected function seedRegion($region)
    {
        $regionId = DB::table('regions')->insertGetId([
            'country_id' => 1,
            'name' => $region,
            'created_at' => Carbon::now(),
        ]);

        return $regionId;
    }

    /**
     * Seed the city table.
     *
     * @param  string  $city
     * @param  string  $regionId
     *
     * @return void
     */
    protected function seedCity($city, $regionId)
    {
        DB::table('cities')->insert([
            'region_id' => $regionId,
            'name' => $city,
            'created_at' => Carbon::now(),
        ]);
    }
}
