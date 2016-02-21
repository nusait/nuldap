<?php namespace Nusait\Nuldap;

use Nusait\Nuldap\Contracts\TransformerInterface;
use Nusait\Nuldap\Transformers\DefaultUserTransformer;
use Exception;

/*
 * @method array searchNetid(string $netid) Searches for a user by netid.
 * @method array searchEmplid(string $emplid) Searches for a user by emplid.
 * @method array searchEmail(string $email) Searches for a user by email.
 * @method array searchStudentid(string $studentid) Searches for a user by student id.
 */
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
        if (is_null($host) || is_null($port)) {
            throw new Exception('Must define host and port for Nuldap');
        }
        $this->rdn = $rdn;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;

        return $this;
    }

    protected function connect()
    {
        $resource = ldap_connect($this->host, $this->port) or die("No connect $this->host");
        ldap_set_option($resource, LDAP_OPT_NETWORK_TIMEOUT, 2);

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
        if (is_null($query) or is_null($field)) {
            return null;
        }

        $generator = $this->createSearchStringInstance($field);
        $searchString = $generator->getSearchString($query);

        $baseDN = 'dc=northwestern,dc=edu';
        $entries = $this->ldapSearch($baseDN, $searchString);

        if ($entries['count'] === 0) {
            return null;
        }

        return $entries[0];
    }

    protected function ldapSearch($baseDN, $searchString)
    {
        $connection = $this->connect();
        try {
            $bind = ldap_bind($connection, $this->rdn, $this->password);
        }
        catch(Exception $e)
        {
            throw new Exception('Cannot connect to the ldap server');
        }

        $search = ldap_search($connection, $baseDN, $searchString);

        return ldap_get_entries($connection, $search);
    }

    protected function createSearchStringInstance($field)
    {
        $generatorClassName = '\\Nusait\\Nuldap\\SearchStringGenerators\\' .
            ucfirst(strtolower(trim($field))) .
            'SearchStringGenerator';

        return new $generatorClassName;
    }

    public function parseUser($ldapUser, TransformerInterface $transformer = null)
    {
        if (is_null($ldapUser)) {
            return null;
        }
        if (is_null($transformer)) {
            $transformer = new DefaultUserTransformer();
        }

        return $transformer->transform($ldapUser);
    }

    public function __call($name, $arguments)
    {
        $regex = '/^search(.+)/';
        if(preg_match($regex, $name, $matches))
        {
            $field = strtolower(trim($matches[1]));
            if(! isset($arguments[0]))
            {
                throw new \InvalidArgumentException();
            }
            return $this->search($field, $arguments[0]);
        }
        throw new \BadMethodCallException();
    }
}
