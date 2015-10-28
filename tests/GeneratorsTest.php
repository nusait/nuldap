<?php

use Nusait\Nuldap\SearchStringGenerators;

class GeneratorsTest extends PHPUnit_Framework_TestCase {
    public function testEmailSearchStringGenerator()
    {
        $generator = new SearchStringGenerators\EmailSearchStringGenerator();
        $value = 'abc@example.com';
        $this->assertEquals("(mail={$value})", $generator->getSearchString($value));
    }

    public function testEmplidSearchStringGenerator()
    {
        $generator = new SearchStringGenerators\EmplidSearchStringGenerator();
        $value = 123456;
        $this->assertEquals("(employeenumber={$value})", $generator->getSearchString($value));
    }

    public function testNetidSearchStringGenerator()
    {
        $generator = new SearchStringGenerators\NetidSearchStringGenerator();
        $value = 'abc123';
        $this->assertEquals("(nuidtag={$value})", $generator->getSearchString($value));
    }

    public function testStudentidSearchStringGenerator()
    {
        $generator = new SearchStringGenerators\StudentidSearchStringGenerator();
        $value = 'abc123';
        $this->assertEquals("(nustudentnumber={$value})", $generator->getSearchString($value));
    }
}