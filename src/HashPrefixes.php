<?php
namespace BRTNetwork\BRTBinaryCodec;

use BRTNetwork\Buffer\Buffer;

class HashPrefixes
{
    private static $transactionSig = 0x53545800;

    public static function TransactionSig(): Buffer
    {
        return Buffer::int(static::$transactionSig);
    }
}
