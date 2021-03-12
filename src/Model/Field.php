<?php
namespace BRTNetwork\BRTBinaryCodec\Model;

use BRTNetwork\Buffer\Buffer;
use BRTNetwork\BRTBinaryCodec\Definitions;
use BRTNetwork\BRTBinaryCodec\Utils;

/**
 * Class Field
 * @property int $nth
 * @property bool $isVariableLengthEncoded
 * @property bool $isSerialized
 * @property bool $isSigningField
 * @property Bytes $type
 * @property int $ordinal
 * @property string $name
 * @property Buffer $header
 * @property $value
 */
class Field extends BaseModel
{
    /**
     * @param $json
     * @return static
     */
    public static function fromJson($json)
    {
        $json = json_decode(json_encode($json));

        $filed = new self();

        $filed->nth                     = $json->nth;
        $filed->isVariableLengthEncoded = $json->isVLEncoded;
        $filed->isSerialized            = $json->isSerialized;
        $filed->isSigningField          = $json->isSigningField;
        $filed->type                    = Definitions::getType($json->type);
        $filed->ordinal                 = $filed->type->ordinal << 16 | $filed->nth;
        $filed->header                  = self::header($filed->type->ordinal, $json->nth);

        return $filed;
    }

    private static function header($type, $nth): Buffer
    {
        $header = [];
        if ($type < 16)
        {
            if ($nth < 16)
            {
                $header[] = (($type << 4) | $nth);
            }
            else
            {
                $header[] = ($type << 4);
                $header[] = $nth;
            }
        }
        else if ($nth < 16)
        {
            $header[] = $nth;
            $header[] = $type;
        }
        else
        {
            $header[] = 0;
            $header[] = $type;
            $header[] = $nth;
        }

        return Buffer::hex(Utils::decimalArrayToHexStr($header));
    }
}
