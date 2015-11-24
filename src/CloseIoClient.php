<?php namespace CloseIo;

interface CloseIoClient
{
	public function get($action);

	public function post($action, array $data = []);

	public function put($action, array $data = []);

	public function delete($action);

	public function send($action, $method = 'GET', $data = [], array $options = []);

	public function getLastStatusCode();

	public function getLastQuery();

	public function getLastAction();
}
