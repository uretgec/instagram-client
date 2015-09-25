<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:21
 * Company: Uretgec
 * URI: www.uretgec.com
 */

namespace Oauth2r\Instagram\Mapper;

class User extends Base
{
	public $id;
	public $username;
	public $first_name;
	public $last_name;
	public $full_name;
	public $profile_picture;
	public $bio;
	public $website;
	public $counts = array();
	public $type;
}