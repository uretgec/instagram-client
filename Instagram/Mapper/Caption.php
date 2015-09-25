<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:21
 * Company: Uretgec
 * URI: www.uretgec.com
 */

namespace Oauth2r\Instagram\Mapper;

class Caption extends Base
{
	public $id;
	public $created_time;
	public $text;
	public $from = array(); // User Class
}