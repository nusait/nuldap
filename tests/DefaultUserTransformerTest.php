<?php

use Nusait\Nuldap\Transformers\DefaultUserTransformer;

class DefaultUserTransformerTest extends PHPUnit_Framework_TestCase
{
    protected $regExptectedUser;
    protected $detExpectedUser;
    protected $transformer;

    public function setUp()
    {
        $this->transformer = new DefaultUserTransformer();
        $this->regExpectedUser = [
            'netid'               => 'abc123',
            'phone'               => '+1 555 555 5555',
            'email'               => 'test-user@northwestern.edu',
            'title'               => 'Developer',
            'first_name'          => 'Firstname',
            'last_name'           => 'Lastname',
            'displayname'         => 'Firstname Lastname',
            'emplid'              => null,
            'studentid'           => null,
            'photo'               => null,
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

    public function testDefaultUserTransformerWithDetailedUser()
    {
        $json = file_get_contents(__DIR__ . '/ldap-output/detailed-output.json');
        $ldapUser = json_decode($json, true);
        $transformedUser = $this->transformer->transform($ldapUser);
        $this->assertEquals($this->detExpectedUser, $transformedUser);
    }

    public function testDefaultUserTransformerWithRegularUser()
    {
        $json = file_get_contents(__DIR__ . '/ldap-output/regular-output.json');
        $ldapUser = json_decode($json, true);
        $transformedUser = $this->transformer->transform($ldapUser);
        $this->assertEquals($this->regExpectedUser, $transformedUser);

    }
}