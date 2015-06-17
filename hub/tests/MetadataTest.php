<?php

use FP\Larmo\Domain\Entity\Metadata;

class MetadataTest extends PHPUnit_Framework_TestCase {

    private $metadata;
    private $checksum = "STRING";
    private $checkSumValidator;
    private $authInfoValidator;

    public function setup() {
        $this->checkSumValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\CheckSumInterface')->setMethods(array('validate'))->getMock();
        $this->authInfoValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\AuthInfoInterface')->setMethods(array('validate'))->getMock();
        $this->metadata = new Metadata($this->checkSumValidator, $this->authInfoValidator, $this->checksum, time(), 'AUTH_INFO', 'SOME_SOURCE');
    }

    /**
     * @test
     */
    public function metadataHasChecksum() {
        $this->assertNotEmpty($this->metadata->getChecksum());
    }

    /**
     * @test
     */
    public function metadataHasCorrectChecksum() {
        $this->assertEquals($this->checksum, $this->metadata->getChecksum());
    }

    /**
     * @test
     */
    public function checkSumIsNotValidating() {
        $this->checkSumValidator->method('validate')->willReturn(false);
        $this->setExpectedException('InvalidArgumentException');
        $this->metadata->setChecksum("CHECKSUM");
    }

    /**
     * @test
     */
    public function checkSumIsSetCorrectly() {
        /* We must assume checksum is correct */
        $this->checkSumValidator->method('validate')->willReturn(true);

        $this->metadata->setChecksum("SET OLD");
        $csOriginal = $this->metadata->getChecksum();

        $this->metadata->setChecksum("SET NEW");
        $csNew = $this->metadata->getChecksum();

        $this->assertNotEquals($csOriginal,$csNew);
    }

    /**
     * @test
     */
    public function metadataHasTimestamp() {
        $this->assertNotEmpty($this->metadata->getTimestamp());
    }

    /**
     * @test
     */
    public function metadataHasCorrectTimestamp() {
        $time = time();
        $this->metadata->setTimestamp($time);
        $this->assertEquals($time, $this->metadata->getTimestamp());
    }

    /**
     * @test
     */
    public function metadataHasAuthInfo() {
        $this->assertNotEmpty($this->metadata->getAuthInfo());
    }

    /**
     * @test
     */
    public function metadataCanSetAuthInfo() {
        $this->authInfoValidator->method('validate')->willReturn(true);
        $this->metadata->setAuthInfo('AUTHENTICATION INFO');
        $this->assertEquals('AUTHENTICATION INFO',$this->metadata->getAuthInfo());
    }

    /**
     * @test
     */
    public function authInfoIsNotValidating() {
        $this->authInfoValidator->method('validate')->willReturn(false);
        $this->setExpectedException('InvalidArgumentException');
        $this->metadata->setAuthInfo("NEW AUTH INFO");
    }

    /**
     * @test
     */
    public function metadataHasSource() {
        $this->assertNotEmpty($this->metadata->getSource());
    }

    /**
     * @test
     */
    public function metadataCanSetSource() {
        $source = "SOURCE_LIKE_IRC";
        $this->metadata->setSource($source);
        $this->assertEquals($source, $this->metadata->getSource());
    }

}