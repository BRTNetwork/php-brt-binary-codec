<?php
namespace BRTNetwork\BRTBinaryCodecc\Model;

use BRTNetwork\Buffer\Buffer;
use BRTNetwork\BRTBinaryCodecc\Utils;

/**
 * Class Bytes
 * @property $name
 * @property $ordinal
 * @property $ordinalWidth
 * @property Buffer $bytes
 */
class Bytes extends BaseModel
{
    public function __construct(string $name, int $ordinal, int $ordinalWidth)
    {
        $this->name         = $name;
        $this->ordinal      = $ordinal;
        $this->ordinalWidth = $ordinalWidth;
        $this->bytes        = Buffer::hex(str_repeat('00', $ordinalWidth));
        $_bytes             = $this->bytes->getDecimal();
        for ($i = 0; $i < $ordinalWidth; $i++)
        {
            $_bytes[$ordinalWidth - $i - 1] = Utils::unsignedRightShift($ordinal, ($i * 8)) & 0xff;
        }

        $this->bytes = Buffer::hex(Utils::decimalArrayToHexStr($_bytes));
    }

    public function __debugInfo()
    {
        return [
            'name'        => $this->name,
            'ordinal'     => $this->ordinal,
            'ordinalWith' => $this->ordinalWidth,
            'bytes'       => 'Buffer 0x' . $this->bytes->getHex(),
        ];
    }
}
