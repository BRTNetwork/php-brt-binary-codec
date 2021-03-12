<?php
namespace BRTNetwork\BRTBinaryCodec;


class Binary
{
    public function signingData($transaction, $prefix = null)
    {
        if (is_null($prefix))
        {
            $prefix = HashPrefixes::TransactionSig();
        }

        return $this->serializeObject($transaction, ['prefix' => $prefix, 'signingFieldsOnly' => true]);
    }

    public function serializeObject($json, $options)
    {
        $out    = [];
        $prefix = isset($options['prefix']) ? $options['prefix'] : false;
        if ($prefix)
        {
            $out[] = $prefix->getHex();
        }
        $ser    = new TxSerializer();
        $out[]  = $ser->SerializeTx($json, $options)
                      ->getHex()
        ;
        $suffix = isset($options['suffix']) ? $options['suffix'] : false;
        if ($suffix)
        {
            $out[] = $suffix->getHex();
        }

        return strtoupper(join($out));
    }
}
