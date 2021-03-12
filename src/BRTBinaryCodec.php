<?php
namespace BRTNetwork\BRTBinaryCodec;

class BRTBinaryCodec
{
    private $binary;

    public function __construct()
    {
        $this->binary = new Binary();
    }

    public function encodeForSigning($json)
    {
        return $this->binary->signingData($json);
    }

    public function encode($json)
    {
        return $this->binary->serializeObject($json, []);
    }
}
