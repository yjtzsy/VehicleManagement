<?php

class ErrorCode
{
	private function __construct() {}

	CONST SUCCESS = '0x0000'; 						// 成功
	CONST FAILED = '0x0001';						// 失败
	CONST THREAD = '0x0002';						// 抛出异常

	CONST SYSTEM_ALREADY_LOGIN = '0x0010';			// 系统已登录
	CONST SYSTEM_NOT_LOGIN = '0x0011';				// 系统未登录

	CONST REQUEST_ACTION_ERROR = '0x0020';			// 请求Action出错
	CONST PARAM_ACTION_UNKNOWN = '0x0021';			// 请求Action未知
	CONST PARAM_ACTION_NOTEXISTS = '0x0022';		// 请求Action不存在

	CONST REQUEST_CONTENT_ERROR = '0x0030';			// 请求content出错
	CONST PARAM_CONTENT_NULL = '0x0031';			// 请求content内容为空
	CONST PARAM_CONTENT_NOTEXISTS = '0x0032';		// 请求content不存在
	CONST PARAM_OFFSET_ISBIG = '0x0033';			// offset过大

	CONST PARAM_NOT_VALID = '0x0040';				// 参数不合法

	CONST DB_MYSQL_LINK_FAILED = '0x0050';			// MYSQL数据库连接实例对象失败
	CONST DB_MYSQL_OPERATE_FAILED = '0x0051';		// MYSQL数据库操作失败

	CONST WS_URL_ERROR = '0x0060';					// WebService请求地址错误
	CONST WS_PASSWORD_ERROR = '0x0061';				// WebService密码验证错误
	CONST WS_RESPONSE_ERROR = '0x0062';				// WebService响应失败
	CONST WS_PARAM_NOT_VALID = '0x0063';			// WebService参数验证失败
	CONST WS_NOT_INSTANCE = '0x0064';				// WebService对象未实例化

	CONST LOGIN_FAILED = '0x1000';					// 登录失败
	CONST LOGIN_TIMEOUT = '0x1001';					// 登录超时

	CONST LOGIN_USERID_FORMAT_ERROR = '0x1010';		// 登录用户名格式错误
	CONST LOGIN_USERID_NOTEXISTS = '0x1011';		// 登录用户名不存在
	CONST LOGIN_PASSWORD_ERROR = '0x1012';				// 登录密码错误
	CONST LOGIN_USERID_UNVALID_OR_NOTEXISTS = '0x1013';	// 登录用户名参数不合法
	CONST LOGIN_MAXLLOWED_ERROR = '0x1014';			// 登录超过最大连接数

	CONST SESSION_ERROR = "0x1020";					// SESSION错误
	CONST SESSION_UNVALID_OR_NOTEXISTS = "0x1021";	// SESSION失效
	CONST SESSION_LENGTH_ERROR = "0x1022";			// SESSION长度不合法
	
	CONST PLAT_NOT_LOGIN = '0x1040';				// GSOAP没有登录
	CONST PLAT_ALREADY_LOGIN = '0x1041';			// GSOAP已经登录

	CONST UPLOAD_ERROR = '0x1050';					// 上传失败
	CONST UPLOAD_PHOTO_EXT_ERROR = '0x1051';		// 上传图片文件格式错误
	CONST UPLOAD_EXCEL_EXT_ERROR = '0x1052';		// 上传Excel文件格式错误

	CONST XML_SEND_SERVICE_ERROR = '0x2000';		// XML发送至远程服务器失败
	CONST XML_ANALYSIS_FAILED = "0x2001";			// XML报文解析失败
	CONST XML_REQUEST_ERROR = '0x2002';				// XML返回错误
	CONST XML_OPTID_ERROR = "0x2003";				// XML发送OPTID错误
	CONST XML_REQUEST_NU_FORMAT_ERROR = '0x2004';	// XML请求报文格式错误

	CONST XML_RESPONSE_NU_ERROR = '0x2005';			// XML响应报文NU错误
	CONST XML_RESPONSE_NU_TIMEOUT = '0x2006';		// XML响应报文NU超时

	CONST REMOTE_SERVER_REQUEST_ERROR = '0x2010';	// 远程服务器响应失败

	CONST DEVICE_NOT_ONLINE = '0x3000';				// 设备不在线
	CONST GET_STREAM_IPTOKEN_FAILED = '0x3010';		// 请求流IPTOKEN失败
	CONST GET_REALTIME_RTMP_FAILED = '0x3020';		// 请求实时流RTMP失败
	CONST PLAY_RTMP_STREAM_FAILED = '0x3021';		// 播放RTMP流失败
	CONST STOP_RTMP_STREAM_FAILED = '0x3022';		// 停止RTMP流失败
	
	
	
}

?>
