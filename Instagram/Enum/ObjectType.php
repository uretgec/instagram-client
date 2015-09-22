<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Enum;

class ObjectType
{
	const ALL = 'all';
	const USER = 'user';
	const TAG = 'tag';
	const LOCATION = 'location';
	const GEOGRAPHY = 'geography';

	public static function getList()
	{
		return [
			self::ALL 	=> 'All'
			, self::USER => 'Videos'
			, self::TAG => 'Tag'
			, self::LOCATION => 'Location'
			, self::GEOGRAPHY => 'Geography'
		];
	}
}