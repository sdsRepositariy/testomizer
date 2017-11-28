<?php

namespace App\Services\Common;

class GetFilter
{
    /**
     * Apply fiters to query builder
     *
     * @param array $queryString
     * @param string $namespace
     * @param string $filterPath
     *
     * @return Illuminate/Database/Eloquent/Builder $query
     *
    */
    public function filter($queryString, $namespace, $filterPath)
    {
        //Get all related filters
        $classPaths = glob(app_path().$filterPath.'*.php');
        $classes = array();
        $namespace = $namespace;

        //Apply filters
        foreach ($classPaths as $classPath) {
            $segments = explode('/', $classPath);
            $class = str_replace('.php', '', $segments[count($segments) - 1]);
            $className = $namespace . $class;
     
            $filterName = substr($class, 0, strpos($class, 'Filter'));
            $filterName = strtolower($filterName);

            //Get input
            $attribute = null;

            if (isset($queryString[$filterName])) {
                $attribute = $queryString[$filterName];
            }
        
            //Call filter
            $filterInst = app($className);
            $queryParameters[] = $filterInst->apply($attribute);
        }
    
        return $queryParameters;
    }
}
