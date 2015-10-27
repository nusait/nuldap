<?php namespace Nusait\Nuldap;

use Nusait\Nuldap\SearchStringGenerators;

class NuLdap
{
    protected $rdn;
    protected $password;
    protected $host;
    protected $port;

    public function __construct(
        $rdn = null,
        $password = null,
        $host = null,
        $port = null
    ) {
        if(is_null($host) || is_null($port))
        {
            throw new \Exception('Must define host and port for Nuldap');
        }
        $this->rdn = $rdn;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;

        return $this;
    }

    public function connect()
    {
        $resource = ldap_connect($this->host, $this->port) or die("No connect $this->host");

        return $resource;
    }

    public function validate($netid, $password)
    {
        $connection = $this->connect();
        $rdn = "uid={$netid},ou=people,dc=northwestern,dc=edu";
        $bind = @ldap_bind($connection, $rdn, $password);

        return (bool)$bind;
    }

    public function search($field, $query)
    {
        if( is_null($query) or is_null($field)) {
            return null;
        }

        $generator = $this->createSearchStringInstance($field);
        $searchString = $generator->getSearchString($query);

        $connection = $this->connect();
        $bind = @ldap_bind($connection, $this->rdn, $this->password);

        $search = ldap_search($connection, 'dc=northwestern,dc=edu', $searchString);
        $entries = ldap_get_entries($connection, $search);
        if ($entries['count'] === 0) {
            return null;
        }

        return $entries[0];
    }

    protected function createSearchStringInstance($field) {
        $generatorClassName = 'SearchStringGenerators\\' .
            ucfirst($field) .
            'SearchStringGenerator';
        return new $generatorClassName;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRdn($rdn)
    {
        $this->rdn = $rdn;
    }

    public function parseUser($ldapUser, $transformer = null)
    {
        if (is_null($ldapUser)) {
            return $ldapUser;
        }

        if (is_null($transformer)) {
            $transformer = [
                'phone'       => 'telephonenumber',
                'email'       => 'mail',
                'title'       => 'title',
                'first_name'  => 'givenname',
                'last_name'   => 'sn',
                'netid'       => 'uid',
                'displayname' => 'displayname',
                'emplid'      => 'employeenumber',
                'studentid'   => 'nustudentnumber'
            ];
        }

        $parsedUser = [];
        foreach ($transformer as $key => $ldapkey) {
            $parsedUser[$key] = isset($ldapUser[$ldapkey][0]) ? $ldapUser[$ldapkey][0] : null;
        }

        return $parsedUser;
    }
}
