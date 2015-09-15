<?php namespace Nusait\Nuldap;

class NuLdap
{
    protected $rdn;
    protected $password;
    protected $host;
    protected $port;

    public function __construct(
        $rdn = null,
        $password = null,
        $host = 'ldaps://registry.northwestern.edu/',
        $port = 636
    ) {
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

    public function search($searchString)
    {
        $results = null;
        $connection = $this->connect();
        $bind = ldap_bind($connection, $this->rdn, $this->password);
        if ( ! is_null($searchString)) {
            $search = ldap_search($connection, 'dc=northwestern,dc=edu', $searchString);
            $entries = ldap_get_entries($connection, $search);
            if ($entries['count'] != 0) {
                $results = $entries[0];
            }
        }

        return $results;
    }

    public function searchNetid($netid)
    {
        $searchString = "(nuidtag={$netid})";
        return $this->search($searchString);
    }

    public function searchEmplid($emplid)
    {
        $searchString = "(employeenumber={$emplid})";
        return $this->search($searchString);
    }

    public function searchStudentid($studentid)
    {
        $searchString = "(nustudentnumber={$studentid})";
        return $this->search($searchString);
    }

    public function searchEmail($email)
    {
        $searchString = "(nustudentnumber={$email})";
        return $this->search($searchString);
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
