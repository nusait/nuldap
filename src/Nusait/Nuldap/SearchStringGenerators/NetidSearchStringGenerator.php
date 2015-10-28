<?php namespace Nusait\Nuldap\SearchStringGenerators;

use Nusait\Nuldap\Contracts\SearchStringInterface;

class NetidSearchStringGenerator implements SearchStringInterface {
    public function getSearchString($netid)
    {
        return "(nuidtag={$netid})";
    }
}