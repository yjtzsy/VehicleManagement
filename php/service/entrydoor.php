<?php
/**
 * 入口函数
 */

ini_set("date.timezone", "Asia/Shanghai");
header('content-Type:text/html;charset=utf-8');

include_once (dirname(dirname(__FILE__)).'/utility/global.var.php');
include_once (PROJECT_DOMAIN_ROOT . '/utility/validator.class.php');
include_once (PROJECT_DOMAIN_ROOT . '/service/action.class.php');
include_once (PROJECT_DOMAIN_ROOT . '/service/errorcode.class.php');
include_once (PROJECT_DOMAIN_ROOT . '/service/myobject.class.php');

GLogger(__FILE__, __LINE__, __FUNCTION__, "DataExchange Started....");

$g_RV = $g_ReturnValue;

// 日志输出
function GLogger($F, $L, $Func, $logStr = "", $level = null) {
	try {
		global $g_Log;

		if (G_DEBUG) {
			$g_Log -> Writer(G_TAG, $F, $L, $Func, $logStr, $level);
		}
		return true;
	} catch (Exception $e) {
		return false;
	}
}

$reqJson = "";

if (array_key_exists('QUERY_STRING', $_SERVER)) {
	$reqJson = trim(rawurldecode($_SERVER['QUERY_STRING']));
}

if (empty($reqJson)) {
	$reqJson = trim(rawurldecode(file_get_contents("php://input")));
}

if (!empty($reqJson)) {
	GLogger(__FILE__, __LINE__, __FUNCTION__, "Request message body -> {$reqJson}");

	// 解析请求消息体，转为stdClass对象
	$de_reqJson = json_decode($reqJson);
	if (is_null($de_reqJson) || (strcasecmp(PHP_VERSION, '5.3.0') >= 0 && json_last_error() != JSON_ERROR_NONE) || empty($de_reqJson -> request) || empty($de_reqJson -> request -> action)) {
		$g_Log -> Writer(G_TAG, __FILE__, __LINE__, __FUNCTION__, "Request message body unlegal.");
		g_Response(ErrorCode::FAILED);
		exit();
	}

	GLogger(__FILE__, __LINE__, __FUNCTION__, "Parsed request message body  -> " . print_r($de_reqJson, true));

	$request = $de_reqJson -> request;

	if (empty($request -> action)) {
		Glogger(__FILE__, __LINE__, __FUNCTION__, "Request Parameters Error: Not Found 'action' property.");

		g_Response(ErrorCode::FAILED);
		exit();
	}

	if (!property_exists($request, 'content')) {
		Glogger(__FILE__, __LINE__, __FUNCTION__, "Request Parameters Error: Not Found 'content' property.");
		g_Response(ErrorCode::FAILED);
		exit();
	}
} else {
	GLogger(__FILE__, __LINE__, __FUNCTION__, "请求消息体为空");
	g_Response(ErrorCode::FAILED);
	exit();
}

function g_Response($errorCode = ErrorCode::SUCCESS, $_action = null, $_content = null) {
	global $g_Log, $g_Utility, $g_RV, $action;

	$g_RV -> errorCode = !isset($errorCode) ? ErrorCode::SUCCESS : $errorCode;
	$g_RV -> time = time();
	$g_RV -> action = isset($_action) ? $_action : $action;
	$g_RV -> content = $_content;

	$g_Resp = array("response" => $g_RV);

	if (strcasecmp(PHP_VERSION, '5.4.0') >= 0) {
		$g_RV_JSON = json_encode($g_Resp, JSON_UNESCAPED_UNICODE);
	} else {
		$g_RV_JSON = json_encode($g_Resp);

		if (defined('RETURN_JSON_CODETYPE') && RETURN_JSON_CODETYPE == "UTF-8") {
			$g_RV_JSON = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), $g_RV_JSON);
		}
	}

	GLogger(__FILE__, __LINE__, __FUNCTION__, "DataExchange Ended, Responsing($g_RV_JSON)");
	$g_Utility -> Response($g_RV_JSON);
	exit();
}

// 页面错误响应函数
function g_CustomError($errno, $errstr, $errfile, $errline) {
	global $action;
	g_Response(ErrorCode::FAILED, $action, array("errno" => $errno, "errstr" => $errstr, "errfile" => $errfile, "errline" => $errline));
	exit();
}

/// 连接数据库
$db_link = null;
if (array_key_exists('g_CR_Utility', $GLOBALS) && $GLOBALS['g_CR_Utility']['g_CR_DBLink'])
{
	GLogger(__FILE__, __LINE__, __FUNCTION__, $GLOBALS);
    $db_link = $GLOBALS['g_CR_Utility']['g_CR_DBLink'];

    $g_Log->Writer(G_TAG, __FILE__, __LINE__, __FUNCTION__, "g_CR_Utility(".print_r($GLOBALS['g_CR_Utility'], true).")");
}
if (!isset($db_link) || !$db_link->connect)
{
    GLogger(__FILE__, __LINE__, __FUNCTION__, "创建连接sgcc_ces7数据库实例对象失败");

    g_Response(ErrorCode::DB_MYSQL_LINK_FAILED);
    exit();
}

 
 

// 解析结果值，转换为对象
function RowFetchObject (&$row, $result, $db_link)
{
    if (!isset($db_link))
    {
        global $db_link;
    }

    $row = $db_link->FetchObject($result);
    if ($row)
    {
        return true;
    }
    else
    {
        $row = NULL;
        return false;
    }
}
// 解析结果值，转换为数组
function RowFetchArray (&$row, $result, $db_link)
{
    if (!isset($db_link))
    {
        global $db_link;
    }

    $row = $db_link->FetchArray($result);
    if ($row)
    {
        return true;
    }
    else
    {
        $row = NULL;
        return false;
    }
}


?>