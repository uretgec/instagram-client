<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:21
 * Company: Uretgec
 * URI: www.uretgec.com
 */

namespace Oauth2r\Instagram\Mapper;

class Media extends Base
{
	public $distance;
	public $id;
	public $location = array(); // Location Class
	public $type;
	public $users_in_photo = array(); // UsersInPhoto Class
	public $filter;
	public $tags = array();
	public $comments = array(); // Comments Class
	public $caption;
	public $likes = array(); // Likes Class
	public $link;
	public $user = array(); // User Class
	public $created_time;
	public $images = array(); // Images Class
	public $videos = array(); // Video Class
	public $user_has_liked; // Boolean

}