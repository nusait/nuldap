<?php namespace Nusait\Nuldap\Transformers;


use Nusait\Nuldap\Contracts\TransformerInterface;

abstract class AbstractTransformer implements TransformerInterface
{
    abstract function transform($value);

    protected function getSetValueOrNull($input, $key)
    {
        return isset($input[$key][0]) ? $input[$key][0] : null;
    }

    protected function getPhoto($input, $key)
    {
        return isset($input[$key][0]) ? base64_encode($input[$key][0]) : null;
    }
}