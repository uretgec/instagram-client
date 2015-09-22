<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Enum;

class MethodType
{
	const GET 	= 1;
	const POST 	= 2;
	const DEL 	= 3;

	public static function getList()
	{
		return [
			self::GET 	=> 'Get'
			, self::POST => 'Post'
			, self::DEL => 'Del'
		];
	}
}