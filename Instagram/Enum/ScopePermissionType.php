<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Enum;

class ScopePermissionType
{
	const BASIC 				= 'basic';
	const COMMENTS 			= 'comments';
	const RELATIONSHIPS = 'relationships';
	const LIKES 				= 'likes';

	public static function getList()
	{
		return [
			self::BASIC 	=> 'Basic'
			, self::COMMENTS => 'Comments'
			, self::RELATIONSHIPS => 'Relationship'
			, self::LIKES => 'Likes'
		];
	}
}