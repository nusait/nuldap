<?php

use Nusait\Nuldap\NuLdap;

class NuldapTest extends PHPUnit_Framework_TestCase {
    public function testParseRegularUser()
    {
        $json = file_get_contents(__DIR__.'/ldap-output/regular-output.json');
        $ldapUser = json_decode($json, true);

        $nuldap = new NuLdap(null, null, 'test', 'test');
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
        $this->assertEquals($expectedUser, $nuldap->parseUser($ldapUser));
    }

    public function testParseDetailedUser()
    {
        $json = file_get_contents(__DIR__.'/ldap-output/detailed-output.json');
        $ldapUser = json_decode($json, true);

        $nuldap = new NuLdap(null, null, 'test', 'test');
        $expectedUser = [
            'netid' => 'abc123',
            'phone' => '+1 555 555 5555',
            'email' => 'test-user@northwestern.edu',
            'title' => 'Developer',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'displayname' => 'Firstname Lastname',
            'emplid' => 1234567,
            'studentid' => 1234567
        ];
        $this->assertEquals($expectedUser, $nuldap->parseUser($ldapUser));
    }
}