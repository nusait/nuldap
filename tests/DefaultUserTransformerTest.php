<?php

use Nusait\Nuldap\Transformers\DefaultUserTransformer;

class DefaultUserTransformerTest extends PHPUnit_Framework_TestCase {

    public function testDefaultUserTransformerWithDetailedUser()
    {
        $json = file_get_contents(__DIR__.'/ldap-output/detailed-output.json');
        $ldapUser = json_decode($json, true);
        $transformer = new DefaultUserTransformer();
        $transformedUser = $transformer->transform($ldapUser);
        $expectedUser = [
            'netid' => 'abc123',
            'phone' => '+1 555 555 5555',
            'email' => 'test-user@northwestern.edu',
            'title' => 'Developer',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'displayname' => 'Firstname Lastname',
            'emplid' => '1234567',
            'studentid' => '1234567'
        ];
        $this->assertEquals($expectedUser, $transformedUser);
    }

    public function testDefaultUserTransformerWithRegularUser()
    {
        $json = file_get_contents(__DIR__.'/ldap-output/regular-output.json');
        $ldapUser = json_decode($json, true);
        $transformer = new DefaultUserTransformer();
        $transformedUser = $transformer->transform($ldapUser);
        $expectedUser = [
            'netid' => 'abc123',
            'phone' => '+1 555 555 5555',
            'email' => 'test-user@northwestern.edu',
            'title' => 'Developer',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'displayname' => 'Firstname Lastname',
            'emplid' => null,
            'studentid' => null
        ];
        $this->assertEquals($expectedUser, $transformedUser);

    }
}