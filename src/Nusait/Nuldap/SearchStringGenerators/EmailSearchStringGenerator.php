<?php namespace Nusait\Nuldap\SearchStringGenerators;

use Nusait\Nuldap\Contracts\SearchStringInterface;

class EmailSearchStringGenerator implements SearchStringInterface {
    public function getSearchString($email)
    {
        return "(mail={$email})";
    }
}