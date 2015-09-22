<?php
/** 
 * User: Tuna
 * Date: 16.09.2015
 * Time: 01:32
 * Company: Uretgec
 * URI: www.uretgec.com
 */
namespace Oauth2r\Instagram\Config;

class PatternConfig
{
	/*Users*/
	const GET_USERS 									= 1;
	const GET_USERS_SELF_FEED 				= 2;
	const GET_USERS_MEDIA_RECENT 			= 3;
	const GET_USERS_MEDIA_LIKED 			= 4;
	const GET_USERS_SEARCH						= 5;
	const GET_USERS_FOLLOWS 					= 6;
	const GET_USERS_FOLLOWED_BY 			= 7;
	const GET_USERS_SELF_REQUESTED_BY = 8;
	const GET_USERS_RELATIONSHIP 			= 9;
	const POST_USERS_RELATIONSHIP 		= 10;

	/*Media*/
	const GET_MEDIA 									= 11;
	const GET_MEDIA_SHORTCODE 				= 12;
	const GET_MEDIA_SEARCH 						= 13;
	const GET_MEDIA_POPULAR 					= 14;
	const GET_MEDIA_COMMENTS 					= 15;
	const POST_MEDIA_COMMENTS 				= 16;
	const DEL_MEDIA_COMMENTS					= 17;
	const GET_MEDIA_LIKES 						= 18;
	const POST_MEDIA_LIKES 						= 19;
	const DEL_MEDIA_LIKES 						= 20;

	/*Tag*/
	const GET_TAGS 										= 21;
	const GET_TAGS_MEDIA_RECENT 			= 22;
	const GET_TAGS_SEARCH 						= 23;

	/*Location*/
	const GET_LOCATIONS 							= 24;
	const GET_LOCATIONS_MEDIA_RECENT 	= 25;
	const GET_LOCATIONS_SEARCH 				= 26;

	/*Geography*/
	const GET_GEOGRAPHY 							= 27;

	/*Subscription*/
	const GET_SUBSCRIBES 							= 28;
	const DEL_SUBSCRIBES 							= 29;
	const POST_SUBSCRIBES_USERS 			= 30;
	const POST_SUBSCRIBES_TAGS 				= 31;
	const POST_SUBSCRIBES_LOCATIONS 	= 32;
	const POST_SUBSCRIBES_GEOGRAPHYS 	= 33;

	/*Auth - Access Token*/
	const AUTHORIZE 									= 34;
	const ACCESS_TOKEN								= 35;

	public static function getParameters($pattern = null)
	{
		$patterns =  [
			self::GET_USERS 										=> []
			, self::GET_USERS_SELF_FEED 				=> [ParameterConfig::COUNT, ParameterConfig::MIN_ID, ParameterConfig::MAX_ID]
			, self::GET_USERS_MEDIA_RECENT 			=> [ParameterConfig::COUNT,ParameterConfig::MAX_TIMESTAMP,ParameterConfig::MIN_TIMESTAMP,ParameterConfig::MAX_ID,ParameterConfig::MAX_ID]
			, self::GET_USERS_MEDIA_LIKED 			=> [ParameterConfig::COUNT,ParameterConfig::MAX_LIKED_ID]
			, self::GET_USERS_SEARCH 						=> [ParameterConfig::Q,ParameterConfig::COUNT]
			, self::GET_USERS_FOLLOWS 					=> []
			, self::GET_USERS_FOLLOWED_BY				=> []
			, self::GET_USERS_SELF_REQUESTED_BY => []
			, self::GET_USERS_RELATIONSHIP			=> []
			, self::POST_USERS_RELATIONSHIP 		=> [ParameterConfig::ACTION]

			, self::GET_MEDIA 									=> []
			, self::GET_MEDIA_SHORTCODE 				=> []
			, self::GET_MEDIA_SEARCH 						=> [ParameterConfig::LAT,ParameterConfig::MIN_TIMESTAMP,ParameterConfig::MAX_TIMESTAMP,ParameterConfig::LNG,ParameterConfig::DISTANCE]
			, self::GET_MEDIA_POPULAR 					=> []
			, self::GET_MEDIA_COMMENTS 					=> []
			, self::POST_MEDIA_COMMENTS 				=> []
			, self::DEL_MEDIA_COMMENTS 					=> []
			, self::GET_MEDIA_LIKES 						=> []
			, self::POST_MEDIA_LIKES 						=> []
			, self::DEL_MEDIA_LIKES 						=> []

			, self::GET_TAGS 										=> []
			, self::GET_TAGS_MEDIA_RECENT 			=> [ParameterConfig::MIN_TAG_ID,ParameterConfig::MAX_TAG_ID]
			, self::GET_TAGS_SEARCH 						=> []

			, self::GET_LOCATIONS 							=> []
			, self::GET_LOCATIONS_MEDIA_RECENT 	=> [ParameterConfig::MIN_TIMESTAMP,ParameterConfig::MIN_ID,ParameterConfig::MAX_TIMESTAMP,ParameterConfig::MAX_ID]
			, self::GET_LOCATIONS_SEARCH 				=> [ParameterConfig::DISTANCE,ParameterConfig::LAT,ParameterConfig::LNG,ParameterConfig::FACEBOOK_PLACE_ID,ParameterConfig::FOURSQUARE_ID,ParameterConfig::FOURSQUARE_V2_ID,ParameterConfig::ACCESS_TOKEN]

			, self::GET_GEOGRAPHY 							=> [ParameterConfig::COUNT,ParameterConfig::MIN_ID]

			, self::GET_SUBSCRIBES 							=> []
			, self::DEL_SUBSCRIBES 							=> [ParameterConfig::ID]
			, self::POST_SUBSCRIBES_USERS 			=> []
			, self::POST_SUBSCRIBES_TAGS 				=> [ParameterConfig::OBJECT_ID]
			, self::POST_SUBSCRIBES_LOCATIONS 	=> [ParameterConfig::OBJECT_ID]
			, self::POST_SUBSCRIBES_GEOGRAPHYS 	=> [ParameterConfig::LNG,ParameterConfig::LAT,ParameterConfig::RADIUS]

			, self::AUTHORIZE										=> []
			, self::ACCESS_TOKEN  							=> []
		];

		if($pattern === null)
			return $patterns;

		return isset($patterns[$pattern]) ? $patterns[$pattern] : null;
	}

	public static function getRequiredParameters($pattern = null)
	{
		$patterns =  [
			self::GET_USERS 										=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_SELF_FEED 				=> [ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_MEDIA_RECENT 			=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_MEDIA_LIKED 			=> [ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_SEARCH 						=> [ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_FOLLOWS 					=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_FOLLOWED_BY 			=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_SELF_REQUESTED_BY => [ParameterConfig::ACCESS_TOKEN]
			, self::GET_USERS_RELATIONSHIP 			=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]
			, self::POST_USERS_RELATIONSHIP 		=> [ParameterConfig::USER_ID,ParameterConfig::ACCESS_TOKEN]

			, self::GET_MEDIA 									=> [ParameterConfig::MEDIA_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_MEDIA_SHORTCODE 				=> [ParameterConfig::SHORTCODE,ParameterConfig::ACCESS_TOKEN]
			, self::GET_MEDIA_SEARCH 						=> [ParameterConfig::ACCESS_TOKEN]
			, self::GET_MEDIA_POPULAR						=> [ParameterConfig::ACCESS_TOKEN]
			, self::GET_MEDIA_COMMENTS 					=> [ParameterConfig::MEDIA_ID,ParameterConfig::ACCESS_TOKEN]
			, self::POST_MEDIA_COMMENTS 				=> [ParameterConfig::MEDIA_ID,ParameterConfig::TEXT,ParameterConfig::ACCESS_TOKEN]
			, self::DEL_MEDIA_COMMENTS 					=> [ParameterConfig::MEDIA_ID,ParameterConfig::COMMENT_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_MEDIA_LIKES 						=> [ParameterConfig::MEDIA_ID,ParameterConfig::ACCESS_TOKEN]
			, self::POST_MEDIA_LIKES 						=> [ParameterConfig::MEDIA_ID,ParameterConfig::ACCESS_TOKEN]
			, self::DEL_MEDIA_LIKES 						=> [ParameterConfig::MEDIA_ID,ParameterConfig::ACCESS_TOKEN]

			, self::GET_TAGS 										=> [ParameterConfig::TAG_NAME,ParameterConfig::ACCESS_TOKEN]
			, self::GET_TAGS_MEDIA_RECENT 			=> [ParameterConfig::TAG_NAME,ParameterConfig::ACCESS_TOKEN]
			, self::GET_TAGS_SEARCH 						=> [ParameterConfig::Q,ParameterConfig::ACCESS_TOKEN]

			, self::GET_LOCATIONS 							=> [ParameterConfig::LOCATION_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_LOCATIONS_MEDIA_RECENT 	=> [ParameterConfig::LOCATION_ID,ParameterConfig::ACCESS_TOKEN]
			, self::GET_LOCATIONS_SEARCH 				=> [ParameterConfig::ACCESS_TOKEN]

			, self::GET_GEOGRAPHY 							=> [ParameterConfig::CLIENT_ID,ParameterConfig::GEO_ID,ParameterConfig::ACCESS_TOKEN]

			, self::GET_SUBSCRIBES 							=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET]
			, self::DEL_SUBSCRIBES 							=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::OBJECT,ParameterConfig::ID]
			, self::POST_SUBSCRIBES_USERS 			=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::OBJECT,ParameterConfig::ASPECT,ParameterConfig::VERIFY_TOKEN,ParameterConfig::REDIRECT_URL]
			, self::POST_SUBSCRIBES_TAGS 				=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::OBJECT,ParameterConfig::ASPECT,ParameterConfig::VERIFY_TOKEN,ParameterConfig::REDIRECT_URL]
			, self::POST_SUBSCRIBES_LOCATIONS 	=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::OBJECT,ParameterConfig::ASPECT,ParameterConfig::VERIFY_TOKEN,ParameterConfig::REDIRECT_URL]
			, self::POST_SUBSCRIBES_GEOGRAPHYS 	=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::OBJECT,ParameterConfig::ASPECT,ParameterConfig::VERIFY_TOKEN]

			, self::AUTHORIZE										=> [ParameterConfig::CLIENT_ID,ParameterConfig::REDIRECT_URL,'code' => ParameterConfig::RESPONSE_TYPE,ParameterConfig::SCOPE]
			, self::ACCESS_TOKEN  							=> [ParameterConfig::CLIENT_ID,ParameterConfig::CLIENT_SECRET,ParameterConfig::GRANT_TYPE,ParameterConfig::REDIRECT_URL,ParameterConfig::CODE]
		];

		if($pattern === null)
			return $patterns;

		return isset($patterns[$pattern]) ? $patterns[$pattern] : null;
	}

	public static function getUrl($pattern = null)
	{
		$patterns =  [
			self::GET_USERS 										=> 'v1/users/{user_id}'
			, self::GET_USERS_SELF_FEED 				=> 'v1/users/self/feed'
			, self::GET_USERS_MEDIA_RECENT 			=> 'v1/users/{user_id}/media/recent'
			, self::GET_USERS_MEDIA_LIKED 			=> 'v1/users/self/media/liked'
			, self::GET_USERS_SEARCH 						=> 'v1/users/search'
			, self::GET_USERS_FOLLOWS 					=> 'v1/users/{user_id}/follows'
			, self::GET_USERS_FOLLOWED_BY 			=> 'v1/users/{user-id}/followed-by'
			, self::GET_USERS_SELF_REQUESTED_BY => 'v1/users/self/requested-by'
			, self::GET_USERS_RELATIONSHIP 			=> 'v1/users/{user_id}/relationship'
			, self::POST_USERS_RELATIONSHIP 		=> 'v1/users/{user_id}/relationship'

			, self::GET_MEDIA 									=> 'v1/media/{media_id}'
			, self::GET_MEDIA_SHORTCODE 				=> 'v1/media/shortcode/{shortcode}'
			, self::GET_MEDIA_SEARCH 						=> 'v1/media/search'
			, self::GET_MEDIA_POPULAR						=> 'v1/media/popular'
			, self::GET_MEDIA_COMMENTS 					=> 'v1/media/{media_id}}/comments'
			, self::POST_MEDIA_COMMENTS 				=> 'v1/media/{media_id}}/comments'
			, self::DEL_MEDIA_COMMENTS 					=> 'v1/media/{media_id}/comments/{comment_id}'
			, self::GET_MEDIA_LIKES 						=> 'v1/media/{media_id}/likes'
			, self::POST_MEDIA_LIKES 						=> 'v1/media/{media_id}/likes'
			, self::DEL_MEDIA_LIKES 						=> 'v1/media/{media_id}/likes'

			, self::GET_TAGS 										=> 'v1/tags/{tag_name}'
			, self::GET_TAGS_MEDIA_RECENT 			=> 'v1/tags/{tag_name}/media/recent'
			, self::GET_TAGS_SEARCH 						=> 'v1/tags/search'

			, self::GET_LOCATIONS 							=> 'v1/locations/{location_id}'
			, self::GET_LOCATIONS_MEDIA_RECENT 	=> 'v1/locations/{location_id}/media/recent'
			, self::GET_LOCATIONS_SEARCH 				=> 'v1/locations/search'

			, self::GET_GEOGRAPHY 							=> 'v1/geographies/{geo_id}/media/recent'

			, self::GET_SUBSCRIBES 							=> 'v1/subscriptions/'
			, self::DEL_SUBSCRIBES 							=> 'v1/subscriptions/'
			, self::POST_SUBSCRIBES_USERS 			=> 'v1/subscriptions/'
			, self::POST_SUBSCRIBES_TAGS 				=> 'v1/subscriptions/'
			, self::POST_SUBSCRIBES_LOCATIONS 	=> 'v1/subscriptions/'
			, self::POST_SUBSCRIBES_GEOGRAPHYS 	=> 'v1/subscriptions/'

			, self::AUTHORIZE										=> 'oauth/authorize'
			, self::ACCESS_TOKEN  							=> 'oauth/access_token'
		];

		if($pattern === null)
			return $patterns;

		return isset($patterns[$pattern]) ? $patterns[$pattern] : null;
	}
}