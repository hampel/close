<?php namespace Close\Types;

abstract class AbstractType
{
    protected function filterNullValues(array $data)
    {
        return array_filter($data, function($v) {
            return !is_null($v);
        });
    }

    protected function stripCustomPrefix($key)
    {
        if (substr($key, 0, 7) == 'custom.')
        {
            return substr($key, 7);
        }

        return $key;
    }
}
