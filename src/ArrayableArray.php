<?php namespace CloseIo;

trait ArrayableArray 
{
	private function objectToArray(Arrayable $object)
	{
		return $object->toArray();
	}

	private function arrayToArray(array $arrayable)
	{
		return array_map([get_called_class(), 'objectToArray'], $arrayable);
	}
}
