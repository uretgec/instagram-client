<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Enum;

class MediaType
{
	const IMAGE = 'image';
	const VIDEO = 'video';

	public static function getList()
	{
		return [
			self::IMAGE 	=> 'images'
			, self::VIDEO => 'videos'
		];
	}
}