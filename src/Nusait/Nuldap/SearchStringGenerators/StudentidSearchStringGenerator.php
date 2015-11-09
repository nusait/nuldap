<?php namespace Nusait\Nuldap\SearchStringGenerators;

use Nusait\Nuldap\Contracts\SearchStringInterface;

class StudentidSearchStringGenerator implements SearchStringInterface
{
    public function getSearchString($studentid)
    {
        return "(nustudentnumber={$studentid})";
    }
}