<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Enum;

class RelationshipActionType
{
	const FOLLOW 		= 'follow';
	const UNFOLLOW 	= 'unfollow';
	const BLOCK 		= 'block';
	const UNBLOCK 	= 'unblock';
	const APPROVE 	= 'approve';
	const IGNORE 		= 'ignore';

	public static function getList()
	{
		return [
			self::FOLLOW 	=> 'Follow'
			, self::UNFOLLOW => 'Unfollow'
			, self::BLOCK => 'Block'
			, self::UNBLOCK => 'Unblock'
			, self::IGNORE => 'Ignore'
		];
	}

}