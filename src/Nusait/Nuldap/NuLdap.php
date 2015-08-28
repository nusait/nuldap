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

    public function searchField($field, $value)
    {
        $results = null;
        $field = trim(strtolower($field));
        $connection = $this->connect();
        $bind = ldap_bind($connection, $this->rdn, $this->password);
        if ($field == 'netid') {
            $searchTerm = "(nuidtag={$value})";
        } elseif ($field == 'email') {
            $searchTerm = "(mail={$value})";
        } elseif ($field == 'emplid') {
            $searchTerm = "(employeenumber={$value})";
        } elseif ($field == 'studentid') {
            $searchTerm = "(nustudentnumber={$value})";
        } else {
            $searchTerm = null;
        }
        if (! is_null($searchTerm)) {
            $search = ldap_search($connection, 'dc=northwestern,dc=edu', $searchTerm);
            $entries = ldap_get_entries($connection, $search);
            if ($entries['count'] != 0) {
                $results = $entries[0];
            }
        }

        return $results;
    }

    public function searchNetid($netid)
    {
        $connection = $this->connect();
        $bind = ldap_bind($connection, $this->rdn, $this->password);
        $search = ldap_search($connection, 'dc=northwestern,dc=edu', "(nuIdTag={$netid})");
        $entries = ldap_get_entries($connection, $search);
        $data = $entries[0];

        return $data;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRdn($rdn)
    {
        $this->rdn = $rdn;
    }
}
