<?php namespace Nusait\Nuldap\SearchStringGenerators;

use Nusait\Nuldap\Contracts\SearchStringInterface;

class EmplidSearchStringGenerator implements SearchStringInterface {
    public function getSearchString($emplid)
    {
        return "(employeenumber={$emplid})";
    }
}