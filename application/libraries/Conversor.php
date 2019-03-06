<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversor {

	public function __construct()
	{

	}

	public function data_brasileiro_americano($data)
	{
		if (($data !== '') && ($data !== NULL))
		{
			return date('Y-m-d', strtotime($data));
		}
	}

	public function data_americano_brasileiro($data)
	{
		if (($data !== '') && ($data !== NULL))
		{
			return date('d-m-Y', strtotime($data));
		}
	}

}
	