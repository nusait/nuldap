<?php

use Nusait\Nuldap\NuLdap;

class NuldapTest extends PHPUnit_Framework_TestCase
{
    protected $regExpectedUser;
    protected $detExpectedUser;
    protected $ldap;

    public function setUp()
    {
        $this->ldap = new NuLdap(null, null, 'test', 'test');

        $this->regExpectedUser = [
            'netid'                => 'abc123',
            'phone'                => '+1 555 555 5555',
            'email'                => 'test-user@northwestern.edu',
            'title'                => 'Developer',
            'first_name'           => 'Firstname',
            'last_name'            => 'Lastname',
            'displayname'          => 'Firstname Lastname',
            'emplid'               => null,
            'studentid'            => null,
            'photo'                => null,
            'primary_affiliation' => null
        ];

        $this->detExpectedUser = [
            'netid'               => 'abc123',
            'phone'               => '+1 555 555 5555',
            'email'               => 'test-user@northwestern.edu',
            'title'               => 'Developer',
            'first_name'          => 'Firstname',
            'last_name'           => 'Lastname',
            'displayname'         => 'Firstname Lastname',
            'emplid'              => 1234567,
            'studentid'           => 1234567,
            'photo'               => null,
            'primary_affiliation' => 'staff'
        ];
    }

    public function testParseRegularUser()
    {
        $json = file_get_contents(__DIR__ . '/ldap-output/regular-output.json');
        $ldapUser = json_decode($json, true);
        $this->assertEquals($this->regExpectedUser, $this->ldap->parseUser($ldapUser));
    }

    public function testParseDetailedUser()
    {
        $json = file_get_contents(__DIR__ . '/ldap-output/detailed-output.json');
        $ldapUser = json_decode($json, true);
        $this->assertEquals($this->detExpectedUser, $this->ldap->parseUser($ldapUser));
    }
}