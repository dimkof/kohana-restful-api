<?php defined('SYSPATH') OR die('No direct script access.');

$config = Kohana::$config->load('restful_api');
$default_format = Arr::get($config, 'default_format', 'json');
$allowed_formats = implode('|', array_keys(Arr::get($config, 'format_map', array($default_format => $default_format))));

Route::set('resful-api-default', 'api/<version>/<resource>(/<id>(/<rel_resource>(/<rel_id>)))(:<http_method>)(.<format>)',
	array(
		'version' 		=> '(v[0-9]++)',
		'resource' 		=> '([a-zA-Z0-9_]++)',
		'id'  			=> '[0-9]+',
		'rel_resource' 	=> '([a-zA-Z0-9_]++)',
		'rel_id'  		=> '[0-9]+',
		'format'  		=> '('.$allowed_formats.')',
		'http_method' 	=> '(get|post|put|delete)',
	))
	->filter(array('RESTful_API', 'run'))
	->defaults(array(
		'format' 		=> $default_format,
		'controller'	=> 'Restful_Api_Error',
		'action'		=> 'undefined',
	));

unset($config, $allowed_formats, $default_format);
