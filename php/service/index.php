<?php
ob_start();
session_set_cookie_params(5 * 24 * 60 * 60);
session_start();

// 默认时区
ini_set("date.timezone", "Asia/Shanghai");
header('content-Type:text/html;charset=utf-8');

include_once ('entrydoor.php');

switch($request->action) {
	case Action::GetFuelInfo :
		$arr_RV = GetFuelInfo($request -> content);
		break;
	case Action::AddVehicleInfo :
		$arr_RV = AddVehicleInfo($request -> content);
		break;
	case Action::GetVehicleInfo :
		$arr_RV = GetVehicleInfo($request -> content);
		break;
	case Action::ModifyVehicleInfo :
		$arr_RV = ModifyVehicleInfo($request -> content);
		break;
	case Action::CheckVehicleUniqueColumn:
		$arr_RV = CheckVehicleUniqueColumn($request->content);
		break;
	case Action::AddVehicleApplicationInfo:
		$arr_RV = AddVehicleApplicationInfo($request->content);
		break;
	case Action::GetVehicleApplicationInfo:
		$arr_RV = GetVehicleApplicationInfo($request->content);
		break;
	case Action::AddOilConsumptionInfo:
		$arr_RV = AddOilConsumptionInfo($request->content);
		break;
	case Action::ModifyOilConsumptionInfo:
		$arr_RV = ModifyOilConsumptionInfo($request->content);
		break;
	case Action::GetOilConsumptionInfo:
		$arr_RV = GetOilConsumptionInfo($request->content);
		break;
	case Action::AddVehicleMainTainInfo:
		$arr_RV = AddVehicleMainTainInfo($request->content);
		break;
	case Action::GetVehicleMainTainInfo:
		$arr_RV = GetVehicleMainTainInfo($request->content);
		break;
	case Action::ModifyVehicleMainTainInfo:
		$arr_RV = ModifyVehicleMainTainInfo($request->content);
		break;
	case Action::GetNextMainTainDateTime:
		$arr_RV = GetNextMainTainDateTime($request->content);
		break;
	case Action::GetTotalMileage:
		$arr_RV = GetTotalMileage($request->content);
		break;
	case Action::ExportExcelForVehicleInfo:
		$arr_RV = ExportExcelForVehicleInfo($request->content);
		break;
	case Action::UploadExcelToDB:
		$arr_RV = UploadExcelToDB($request->content);
		break;
	case Action::DeleteVehicleInfo:
		$arr_RV = DeleteVehicleInfo($request->content);
		break;
	case Action::DeleteVehicleMainTainInfo:
		$arr_RV = DeleteVehicleMainTainInfo($request->content);
		break;
	case Action::DeleteOilConsumptionInfo:
		$arr_RV = DeleteOilConsumptionInfo($request->content);
		break;
	case Action::GetDeviceHistoryGPSData:
		$arr_RV = GetDeviceHistoryGPSData($request->content);
		break;

	case Action::GetVehicleApprovalInfo:
		$arr_RV = GetVehicleApprovalInfo($request->content);
		break;
	case Action::AddVehicleApprovalInfo:
		$arr_RV = AddVehicleApprovalInfo($request->content);
		break;
	case Action::DeleteVehicleApprovalInfo:
		$arr_RV = DeleteVehicleApprovalInfo($request->content);
		break;
	
	default :
		GLogger(__FILE__, __LINE__, __FUNCTION__, "检测到未知的action名称，action=" . $action);
		g_Response(ErrorCode::FAILED, Action::UnknownAction);
		exit();
		break;
}

if ($arr_RV['errorCode'] == ErrorCode::DB_MYSQL_LINK_FAILED) {
	try {
		$errorStr = $db_link -> GetError("string");
		GLogger(__FILE__, __LINE__, __FUNCTION__, "MYSQL 数据库操作失败，详细错误：$errorStr");
	} catch(Exception $e) {
	}
}

g_Response($arr_RV['errorCode'], $request -> action, $arr_RV['content']);

/**
 * 获取所有燃料信息
 */
function GetFuelInfo($param) {
	try {
		global $db_link;
		$aRet = array('errorCode' => ErrorCode::SUCCESS);
		
		$query = "SELECT * FROM FuelInfo";
		
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取所有燃料信息SQL=" . $query);
		
		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$fuelInfoArr = array();
			while(RowFetchObject($row, $result, $db_link))
			{
				$fuelInfo = new FuelInfoStruct();
				$fuelInfo->index = $row->Index;
				$fuelInfo->name = $row->Name;
				$fuelInfo->modifyDateTime = $row->ModifyDateTime;
				$fuelInfo->remark = $row->Remark;
				array_push($fuelInfoArr, $fuelInfo);
			}
			$aRet['content'] = $fuelInfoArr;	
		}
		return $aRet;
	} catch(Exception $e) {
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取所有燃料信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

/**
 * 添加车辆信息
 * @param
 * 			ID
 * 			VIN_NO
 * 			ENGINE_SERIAL_NUMBER
 * 			Model
 * 			Fuel_Index
 * 			Color
 * 			Seating
 * 			Time
 * 			Mileage
 * 			Oil_Wear
 * 			TankSize
 * 			Maximum_Load
 * 			Total_mass
 * 			Overall_Dimension
 * 			V_Dept
 * 			V_Dept_Manager
 * 			V_Employee_Manager
 * 			Register_Time
 * 			Responsible_Officer
 * 			FirstLeading_Person
 * 			SecondLeading_Person
 */
function AddVehicleInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->ID)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数ID:".$param->ID);
			return $aRet;
		}

		if(!isset($param->VIN_NO)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数VIN_NO:".$param->VIN_NO);
			return $aRet;
		}

		if(!isset($param->ENGINE_SERIAL_NUMBER)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数ENGINE_SERIAL_NUMBER:".$param->ENGINE_SERIAL_NUMBER);
			return $aRet;
		}

		if(!isset($param->Model)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Model:".$param->Model);
			return $aRet;
		}

		if(!isset($param->Fuel_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Fuel_Index:".$param->Fuel_Index);
			return $aRet;
		}

		if(!isset($param->Color)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Color:".$param->Color);
			return $aRet;
		}

		if(!isset($param->Seating)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Seating:".$param->Seating);
			return $aRet;
		}

		if(!isset($param->Time)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Time:".$param->Time);
			return $aRet;
		}

		if(!isset($param->Mileage)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Mileage:".$param->Mileage);
			return $aRet;
		}

		if(!isset($param->Oil_Wear)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Oil_Wear:".$param->Oil_Wear);
			return $aRet;
		}

		if(!isset($param->TankSize)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数TankSize:".$param->TankSize);
			return $aRet;
		}

		if(!isset($param->Maximum_Load)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Maximum_Load:".$param->Maximum_Load);
			return $aRet;
		}

		if(!isset($param->Total_mass)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Total_mass:".$param->Total_mass);
			return $aRet;
		}

		if(!isset($param->Overall_Dimension)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Overall_Dimension:".$param->Overall_Dimension);
			return $aRet;
		}

		if(!isset($param->V_Dept)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数V_Dept:".$param->V_Dept);
			return $aRet;
		}

		if(!isset($param->V_Dept_Manager)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数V_Dept_Manager:".$param->V_Dept_Manager);
			return $aRet;
		}

		if(!isset($param->V_Employee_Manager)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数V_Employee_Manager:".$param->V_Employee_Manager);
			return $aRet;
		}

		if(!isset($param->Register_Time)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Register_Time:".$param->Register_Time);
			return $aRet;
		}

		if(!isset($param->Responsible_Officer)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数Responsible_Officer:".$param->Responsible_Officer);
			return $aRet;
		}

		if(!isset($param->FirstLeading_Person)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数FirstLeading_Person:".$param->FirstLeading_Person);
			return $aRet;
		}

		if(!isset($param->SecondLeading_Person)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息参数错误,参数SecondLeading_Person:".$param->SecondLeading_Person);
			return $aRet;
		}

		if(!isset($param->remark)){
			$param->remark = '';
		}

		$query = "INSERT INTO VehicleInfo(`ID`,`VIN_NO`,`ENGINE_SERIAL_NUMBER`,`Model`,`Fuel_Index`,`Color`,`Seating`,`Time`,`Mileage`,`Oil_Wear`,`TankSize`,`Maximum_Load`,`Total_mass`,`Overall_Dimension`,`V_Dept`,`V_Dept_Manager`,`V_Employee_Manager`,`Register_Time`,`Responsible_Officer`,`FirstLeading_Person`,`SecondLeading_Person`,`ModifyDateTime`, `Remark`) VALUES('$param->ID','$param->VIN_NO','$param->ENGINE_SERIAL_NUMBER','$param->Model','$param->Fuel_Index','$param->Color',$param->Seating,'$param->Time',$param->Mileage,'$param->Oil_Wear','$param->TankSize','$param->Maximum_Load','$param->Total_mass','$param->Overall_Dimension','$param->V_Dept','$param->V_Dept_Manager','$param->V_Employee_Manager','$param->Register_Time','$param->Responsible_Officer','$param->FirstLeading_Person','$param->SecondLeading_Person',now(),'$param->remark')";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetVehicleInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->ID)){
			$param->ID = '';
		}

		$query = "SELECT v.*,f.Name as FuelName FROM VehicleInfo v inner join fuelinfo f on f.`Index` = v.Fuel_Index WHERE v.`ID` LIKE '%".$param->ID."%'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆信息SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$vehicleInfoArr = array();

			while(RowFetchObject($row, $result, $db_link)){
				$vehicleInfo = new VehicleInfoStruct();
				$vehicleInfo->index = $row->Index;
				$vehicleInfo->ID = $row->ID;
				$vehicleInfo->VIN_NO = $row->VIN_NO;
				$vehicleInfo->ENGINE_SERIAL_NUMBER = $row->ENGINE_SERIAL_NUMBER;
				$vehicleInfo->Model = $row->Model;
				$vehicleInfo->Brand = $row->Brand;
				$vehicleInfo->Fuel_Index = $row->Fuel_Index;
				$vehicleInfo->FuelName = $row->FuelName;
				$vehicleInfo->Color = $row->Color;
				$vehicleInfo->Seating = $row->Seating;
				$vehicleInfo->Time = $row->Time;
				$vehicleInfo->Mileage = $row->Mileage;
				$vehicleInfo->Oil_Wear = $row->Oil_Wear;
				$vehicleInfo->TankSize = $row->TankSize;
				$vehicleInfo->Maximum_Load = $row->Maximum_Load;
				$vehicleInfo->Total_mass = $row->Total_mass;
				$vehicleInfo->Overall_Dimension = $row->Overall_Dimension;
				$vehicleInfo->V_Dept = $row->V_Dept;
				$vehicleInfo->V_Dept_Manager = $row->V_Dept_Manager;
				$vehicleInfo->V_Employee_Manager = $row->V_Employee_Manager;
				$vehicleInfo->Register_Time = $row->Register_Time;
				$vehicleInfo->Responsible_Officer = $row->Responsible_Officer;
				$vehicleInfo->FirstLeading_Person = $row->FirstLeading_Person;
				$vehicleInfo->SecondLeading_Person = $row->SecondLeading_Person;
                $vehicleInfo->Remark = $row->Remark;
				array_push($vehicleInfoArr, $vehicleInfo);
			}

			$aRet['content'] = $vehicleInfoArr;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function ModifyVehicleInfo($param)
{
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "修改车辆信息参数错误,参数index:".$param->index);
			return $aRet;
		}

		$update = "";

		if(isset($param->Model)){
			$update .= " `Model` = '$param->Model',";
		}

		if(isset($param->Brand)){
			$update .= " `Brand` = '$param->Brand',";
		}

		if(isset($param->Fuel_Index)){
			$update .= " `Fuel_Index` = '$param->Fuel_Index',";
		}

		if(isset($param->Color)){
			$update .= " `Color` = '$param->Color',";
		}

		if(isset($param->Seating)){
			$update .= " `Seating` = '$param->Seating',";
		}

		if(isset($param->Time)){
			$update .= " `Time` = '$param->Time',";
		}

		if(isset($param->Mileage)){
			$update .= " `Mileage` = '$param->Mileage',";
		}

		if(isset($param->Oil_Wear)){
			$update .= " `Oil_Wear` = '$param->Oil_Wear',";
		}

		if(isset($param->TankSize)){
			$update .= " `TankSize` = '$param->TankSize',";
		}

		if(isset($param->Maximum_Load)){
			$update .= " `Maximum_Load` = '$param->Maximum_Load',";
		}

		if(isset($param->Total_mass)){
			$update .= " `Total_mass` = '$param->Total_mass',";
		}

		if(isset($param->Overall_Dimension)){
			$update .= " `Overall_Dimension` = '$param->Overall_Dimension',";
		}

		if(isset($param->V_Dept)){
			$update .= " `V_Dept` = '$param->V_Dept',";
		}

		if(isset($param->V_Dept_Manager)){
			$update .= " `V_Dept_Manager` = '$param->V_Dept_Manager',";
		}

		if(isset($param->V_Employee_Manager)){
			$update .= " `V_Employee_Manager` = '$param->V_Employee_Manager',";
		}

		if(isset($param->Register_Time)){
			$update .= " `Register_Time` = '$param->Register_Time',";
		}

		if(isset($param->Responsible_Officer)){
			$update .= " `Responsible_Officer` = '$param->Responsible_Officer',";
		}

		if(isset($param->FirstLeading_Person)){
			$update .= " `FirstLeading_Person` = '$param->FirstLeading_Person',";
		}

		if(isset($param->SecondLeading_Person)){
			$update .= " `SecondLeading_Person` = '$param->SecondLeading_Person',";
		}

		if(isset($param->remark)){
			$update .= " `remark` = '$param->remark',";
		}

		
		$query = "UPDATE VehicleInfo SET ".$update." ModifyDateTime = now() WHERE `Index`='$param->index'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改车辆信息SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改车辆信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

/**
 * 检车车辆信息唯一字段
 * @param
 * 			ID
 * 			VIN_NO
 */
function CheckVehicleUniqueColumn($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		$whereSQL = "";

		if(isset($param->ID)){
			$whereSQL .= " AND `ID` = '$param->ID' ";
		}

		if(isset($param->VIN_NO)){
			$whereSQL .= " AND `VIN_NO` = '$param->VIN_NO' ";
		}

		if(isset($param->ENGINE_SERIAL_NUMBER)){
			$whereSQL .= " AND `ENGINE_SERIAL_NUMBER` = '$param->ENGINE_SERIAL_NUMBER' ";
		}

		if($whereSQL == ''){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		$query = "SELECT COUNT(*) AS Count FROM VehicleInfo WHERE 1=1 ".$whereSQL;
		GLogger(__FILE__, __LINE__, __FUNCTION__, "检测车辆唯一字段SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$count = "";
			while(RowFetchObject($row, $result, $db_link)){
				$count = $row->Count;
			}

			$aRet['content'] = $count;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "检测车辆唯一字段发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

/**
 * 添加用车申请
 * @param
 *			UseDept
 *			VehicleDept
 *			VehicleModel
 *			VehicleInfo_Index
 *			UseContent
 *			Car_owner
 *			Driving_route
 *			Schedule
 *			Driver
 *			Time
 *			Replies
 *			Contractor
 *			Remark
 */
function AddVehicleApplicationInfo($param)
{
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->UseDept)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数userDept:".$param->userDept);
			return $aRet;
		}
				
		if(!isset($param->UseContent)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数UseContent:".$param->UseContent);
			return $aRet;
		}
		
		if(!isset($param->VehicleInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数VehicleInfo_Index:".$param->VehicleInfo_Index);
			return $aRet;
		}
		
		if(!isset($param->Car_owner)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Car_owner:".$param->Car_owner);
			return $aRet;
		}
		
		if(!isset($param->Driving_route)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Driving_route:".$param->Driving_route);
			return $aRet;
		}
		
		if(!isset($param->Schedule)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Schedule:".$param->Schedule);
			return $aRet;
		}
		
		if(!isset($param->Driver)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Driver:".$param->Driver);
			return $aRet;
		}
		
		if(!isset($param->Time)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Time:".$param->Time);
			return $aRet;
		}
		
		if(!isset($param->Replies)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Replies:".$param->Replies);
			return $aRet;
		}

		if(!isset($param->Contractor)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数Contractor:".$param->Contractor);
			return $aRet;
		}

		if(!isset($param->VehicleDept)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数VehicleDept:".$param->VehicleDept);
			return $aRet;
		}

		if(!isset($param->VehicleModel)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息参数错误,参数VehicleModel:".$param->VehicleModel);
			return $aRet;
		}

		if(!isset($param->remark)){
			$param->remark = '';
		}

		$query = "INSERT INTO VehicleUseApplicationInfo (`UseDept`,`VehicleDept`,`VehicleModel`,`VehicleInfo_Index`,`UseContent`,`Car_owner`,`Driving_route`,`Schedule`,`Driver`,`Time`,`Replies`,`Contractor`,`Status`,`ModifyDateTime`,`Remark`) VALUES('$param->UseDept','$param->VehicleDept','$param->VehicleModel','$param->VehicleInfo_Index','$param->UseContent','$param->Car_owner','$param->Driving_route','$param->Schedule','$param->Driver','$param->Time','$param->Replies','$param->Contractor','0',now(),'$param->Remark')";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息SQL:".$query);

		$result = $db_link->Query($query);

		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车申请信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function AddOilConsumptionInfo($param){
	try{
		global $db_link;

		$aRet = array(
			errorCode => ErrorCode::SUCCESS
		);

		
		if(!isset($param->Registrant)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Registrant:".$param->Registrant);
			return $aRet;
		}
		
		if(!isset($param->oilList)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数oilList:".$param->oilList);
			return $aRet;
		}

		if(is_array($param->oilList) && count($param->oilList) > 0)
		{	
			$valueSQL = "";
			foreach($param->oilList as $row)
			{
				if(!isset($row->VehicleInfo_Index)){
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数vehicleInfo_Index:".$row->vehicleInfo_Index);
					return $aRet;
				}
		
				if(!isset($row->Date))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Date:".$row->Date);
					return $aRet;
				}

				if(!isset($row->First_Refueling_Mileage))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数First_Refueling_Mileage:".$row->First_Refueling_Mileage);
					return $aRet;
				}

				if(!isset($row->Total_Mileage))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Total_Mileage:".$row->Total_Mileage);
					return $aRet;
				}

				if(!isset($row->Oil_Number))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Oil_Number:".$row->Oil_Number);
					return $aRet;
				}

				if(!isset($row->Oil_Person))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Oil_Person:".$row->Oil_Person);
					return $aRet;
				}

				if(!isset($row->Driver))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数Driver:".$row->Driver);
					return $aRet;
				}

				if(!isset($row->Remark))
				{
					$param->Remark = '';
				}

				$valueSQL .= "('$row->VehicleInfo_Index', '$row->Date','$row->First_Refueling_Mileage','$row->Total_Mileage','$row->Oil_Number','$row->Oil_Person','$param->Registrant','$row->Driver',now(),'$row->Remark'),";
			}
			
			$valueSQL = rtrim($valueSQL, ",");

			$query = "INSERT INTO OilConsumptioninfo(`VehicleInfo_Index`,`Date`,`First_Refueling_Mileage`,`Total_Mileage`,`Oil_Number`,`Oil_Person`,`Registrant`,`Driver`,`ModifyDateTime`,`Remark`) VALUES".$valueSQL;

			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息SQL:".$query);

			$result = $db_link->Query($query);

			if(!$result){
				GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
				$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
				return $aRet;
			}

		}
		else{
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息参数错误,参数oilList不是数据:".$row->oilList);
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加用车油耗信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}


function GetOilConsumptionInfo($param)
{
	try{
		global $db_link;
		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->ID)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车油耗信息参数错误,参数ID:".$param->ID);
			return $aRet;
		}

		$query = "SELECT oc.*, vi.`ID`, vi.`VIN_NO` FROM oilconsumptioninfo oc inner join vehicleinfo vi on vi.`Index` = oc.`VehicleInfo_Index` WHERE vi.`ID` LIKE '%{$param->ID}%' ORDER BY vi.`ID` ASC,oc.`Date` ASC";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车油耗信息SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$content = array();

			while(RowFetchObject($row, $result, $db_link)){
				$options = new OilConsumptionInfoStruct();
				$options->index = $row->Index;
				$options->VehicleInfo_Index = $row->VehicleInfo_Index;
				$options->ID = $row->ID;
				$options->VIN_NO = $row->VIN_NO;
				$options->Date = $row->Date;
				$options->First_Refueling_Mileage = $row->First_Refueling_Mileage;
				$options->Total_Mileage = $row->Total_Mileage;
				$options->Oil_Number = $row->Oil_Number;
				$options->Oil_Person = $row->Oil_Person;
				$options->Registrant = $row->Registrant;
				$options->Driver = $row->Driver;
				$options->ModifyDateTime = $row->ModifyDateTime;
				$options->Remark = $row->Remark;

				array_push($content, $options);
			}

			$aRet['content'] = $content;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车油耗信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function ModifyOilConsumptionInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->OilConsumptionInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "修改用车油耗信息参数错误,OilConsumptionInfo_Index:".$param->OilConsumptionInfo_Index);
			return $aRet;
		}

		$updateSQL = "";
		if(isset($param->Date)){
			$updateSQL .= " `Date` = '$param->Date',";
		}

		if(isset($param->First_Refueling_Mileage)){
			$updateSQL .= " `First_Refueling_Mileage` = '$param->First_Refueling_Mileage',";
		}

		if(isset($param->Total_Mileage)){
			$updateSQL .= " `Total_Mileage` = '$param->Total_Mileage',";
		}

		if(isset($param->Oil_Number)){
			$updateSQL .= " `Oil_Number` = '$param->Oil_Number',";
		}

		if(isset($param->Oil_Person)){
			$updateSQL .= " `Oil_Person` = '$param->Oil_Person',";
		}

		if(isset($param->Registrant)){
			$updateSQL .= " `Registrant` = '$param->Registrant',";
		}

		if(isset($param->Driver)){
			$updateSQL .= " `Driver` = '$param->Driver',";
		}

		$query = "UPDATE oilconsumptioninfo set ".$updateSQL." `ModifyDateTime`=now() WHERE `Index`='$param->OilConsumptionInfo_Index'";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改用车油耗信息SQL:".$query);

		$result = $db_link->Query($query);

		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改用车油耗信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function AddVehicleMainTainInfo($param)
{
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->Registrant)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Registrant:".$param->Registrant);
			return $aRet;
		}

		if(!isset($param->mainTainList)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数mainTainList:".$param->mainTainList);
			return $aRet;
		}

		if(is_array($param->mainTainList) && count($param->mainTainList) > 0)
		{	
			$valueSQL = "";
			foreach($param->mainTainList as $row)
			{
				if(!isset($row->VehicleInfo_Index)){
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数vehicleInfo_Index:".$row->vehicleInfo_Index);
					return $aRet;
				}
		
				if(!isset($row->Date))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Date:".$row->Date);
					return $aRet;
				}

				if(!isset($row->MainTain_Reason))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数MainTain_Reason:".$row->MainTain_Reason);
					return $aRet;
				}

				if(!isset($row->MainTain_Content))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数MainTain_Content:".$row->MainTain_Content);
					return $aRet;
				}

				if(!isset($row->Next_MainTain_Date))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Next_MainTain_Date:".$row->Next_MainTain_Date);
					return $aRet;
				}

				if(!isset($row->Repairman))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Repairman:".$row->Repairman);
					return $aRet;
				}

				if(!isset($row->Driver))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Driver:".$row->Driver);
					return $aRet;
				}

				if(!isset($row->Cost))
				{
					$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
					GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数Cost:".$row->Cost);
					return $aRet;
				}

				if(!isset($row->Remark))
				{
					$param->Remark = '';
				}

				$valueSQL .= "('$row->VehicleInfo_Index', '$row->Date','$row->MainTain_Reason','$row->MainTain_Content','$row->Next_MainTain_Date','$row->Repairman','$row->Driver','$row->Cost','$param->Registrant',now(),now(),'$row->Remark'),";
			}
			
			$valueSQL = rtrim($valueSQL, ",");

			$query = "INSERT INTO MainTainInfo(`VehicleInfo_Index`,`Date`,`MainTain_Reason`,`MainTain_Content`,`Next_MainTain_Date`,`Repairman`,`Driver`,`Cost`,`Registrant`,`RegistDatetime`,`ModifyDateTime`,`Remark`) VALUES".$valueSQL;

			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息SQL:".$query);

			$result = $db_link->Query($query);

			if(!$result){
				GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
				$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
				return $aRet;
			}

		}
		else{
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,参数mainTainList不是数据:".$row->mainTainList);
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetVehicleMainTainInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->ID)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取维修保养信息参数错误,参数ID:".$param->ID);
			return $aRet;
		}

		$query = "SELECT mt.*, vi.`ID`, vi.`VIN_NO` FROM maintaininfo mt inner join vehicleinfo vi on vi.`Index` = mt.`VehicleInfo_Index` WHERE vi.`ID` LIKE '%{$param->ID}%' ORDER BY mt.`Date` ASC";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车油耗信息SQL:".$query);

		$result = $db_link->Query($query);
		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$content = array();

			while(RowFetchObject($row, $result, $db_link)){
				$options = new MainTainInfoStruct();
				$options->index = $row->Index;
				$options->VehicleInfo_Index = $row->VehicleInfo_Index;
				$options->ID = $row->ID;
				$options->VIN_NO = $row->VIN_NO;
				$options->Date = $row->Date;
				$options->MainTain_Reason = $row->MainTain_Reason;
				$options->MainTain_Content = $row->MainTain_Content;
				$options->Next_MainTain_Date = $row->Next_MainTain_Date;
				$options->Repairman = $row->Repairman;
				$options->Driver = $row->Driver;
				$options->Cost = $row->Cost;
				$options->Registrant = $row->Registrant;
				$options->RegistDatetime = $row->RegistDatetime;
				$options->ModifyDateTime = $row->ModifyDateTime;
				$options->Remark = $row->Remark;

				array_push($content, $options);
			}

			$aRet['content'] = $content;
		}

		

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取维修保养信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function ModifyVehicleMainTainInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->MainTainInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "修改用车维修保养信息参数错误,MainTainInfo_Index:".$param->MainTainInfo_Index);
			return $aRet;
		}

		$updateSQL = "";
		if(isset($param->Date)){
			$updateSQL .= " `Date` = '$param->Date',";
		}

		if(isset($param->MainTain_Reason)){
			$updateSQL .= " `MainTain_Reason` = '$param->MainTain_Reason',";
		}

		if(isset($param->MainTain_Content)){
			$updateSQL .= " `MainTain_Content` = '$param->MainTain_Content',";
		}

		if(isset($param->Next_MainTain_Date)){
			$updateSQL .= " `Next_MainTain_Date` = '$param->Next_MainTain_Date',";
		}

		if(isset($param->Repairman)){
			$updateSQL .= " `Repairman` = '$param->Repairman',";
		}

		if(isset($param->Driver)){
			$updateSQL .= " `Driver` = '$param->Driver',";
		}

		if(isset($param->Cost)){
			$updateSQL .= " `Cost` = '$param->Cost',";
		}

		
		if(isset($param->Registrant)){
			$updateSQL .= " `Registrant` = '$param->Registrant',";
		}

		if(isset($param->RegistDatetime)){
			$updateSQL .= " `RegistDatetime` = '$param->RegistDatetime',";
		}

		$query = "UPDATE maintaininfo set ".$updateSQL." `ModifyDateTime`=now() WHERE `Index`='$param->MainTainInfo_Index'";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改用车维修保养信息信息SQL:".$query);

		$result = $db_link->Query($query);

		if(!$result){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "数据库获取失败...");
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "修改维修保养信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetVehicleApplicationInfo($param)
{
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		$query = "SELECT vap.*,vi.`ID` as VehicleID  FROM vehicleuseapplicationinfo vap INNER JOIN VehicleInfo vi ON vi.`Index` = vap.`VehicleInfo_Index` WHERE vap.`Status`='1' ";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆用车申请信息SQL:".$query);
		
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
		}
		else{
			$vInfoArr = array();

			while(RowFetchObject($row, $result, $db_link)){

				$vInfo = new VehicleApplcationInfoStruct();

				$vInfo->index = $row->Index;
				$vInfo->VehicleInfo_Index = $row->VehicleInfo_Index;
				$vInfo->VehicleID = $row->VehicleID;
				$vInfo->VehicleDept = $row->VehicleDept;
				$vInfo->VehicleModel = $row->VehicleModel;
				$vInfo->UseDept = $row->UseDept;
				$vInfo->UseContent = $row->UseContent;
				$vInfo->Car_owner = $row->Car_owner;
				$vInfo->Driving_route = $row->Driving_route;
				$vInfo->Schedule = $row->Schedule;
				$vInfo->Driver = $row->Driver;
				$vInfo->Time = $row->Time;
				$vInfo->Replies = $row->Replies;
				$vInfo->Contractor = $row->Contractor;
				$vInfo->Status = $row->Status;
				$vInfo->ModifyDateTime = $row->ModifyDateTime;
				$vInfo->Remark = $row->Remark;

				array_push($vInfoArr, $vInfo);
			}

			$aRet['content'] = $vInfoArr;
		}


		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加维修保养信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}


function GetNextMainTainDateTime($param){
	try{
		global $db_link;
		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->VehicleInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车下次维修保养信息参数错误,VehicleInfo_Index:".$param->VehicleInfo_Index);
			return $aRet;
		}

		$query = "SELECT Next_MainTain_Date as NextTime FROM MainTainInfo WHERE VehicleInfo_Index = '$param->VehicleInfo_Index' ORDER BY `Date` DESC LIMIT 0,1";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取下次保养信息SQL:".$query);
		
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$nexttime = "";
			while(RowFetchObject($row, $result, $db_link)){
				$nexttime = $row->NextTime;
			}

			$aRet['content'] = array(
				'NextTime'=>$nexttime
			);
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车下次维修保养信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetTotalMileage($param)
{
	try{
		global $db_link;
		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->VehicleInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车总里程信息参数错误,VehicleInfo_Index:".$param->VehicleInfo_Index);
			return $aRet;
		}

		$query = "SELECT Total_Mileage AS TotalMileage FROM oilconsumptioninfo WHERE VehicleInfo_Index = '$param->VehicleInfo_Index' ORDER BY `Date` DESC LIMIT 0,1";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取总里程信息SQL:".$query);
		
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$totalMileage = "";
			while(RowFetchObject($row, $result, $db_link)){
				$totalMileage = $row->TotalMileage;
			}

			$aRet['content'] = array(
				'TotalMileage'=>$totalMileage
			);
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取用车总里程信息发生异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function ExportExcelForVehicleInfo($param)
{
	try{
		global $db_link;
		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		require_once "../Classes/PHPExcel.php";

		if(!isset($param->Title)){
			$param->Title = "车辆基本信息";
		}

		if(!isset($param->Subject)){
			$param->Subject = "车辆基本信息";
		}
		
		if(!isset($param->Description)){
			$param->Description = "车辆基本信息";
		}

		if(!isset($param->Keywords)){
			$param->Keywords = "车辆基本信息";
		}

		if(!isset($param->Category)){
			$param->Category = "车辆";
		}

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("创世科技股份有限公司")
					->setLastModifiedBy("创世科技股份有限公司")
					->setTitle($param->Title)
					->setSubject($param->Subject)
					->setDescription($param->Description)
					->setKeywords($param->Keywords)
					->setCategory($param->Category);

		// 设置第一个sheet为工作的sheet
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '车牌号')
					->setCellValue('B1', '车架号')
					->setCellValue('C1', '发动机序列号')
					->setCellValue('D1', '车辆管理部门')
					->setCellValue('E1', '车辆管理人员')
					->setCellValue('F1', '厂牌型号')
					->setCellValue('G1', '配发时间')
					->setCellValue('H1', '车辆颜色')
					->setCellValue('I1', '燃油种类')
					->setCellValue('J1', '座位数')
					->setCellValue('K1', '初始里程（km）')
					->setCellValue('L1', '标准油耗（百公里）')
					->setCellValue('M1', '油箱容量（L）')
					->setCellValue('N1', '总质量（Kg）')
					->setCellValue('O1', '最大载重（Kg）')
					->setCellValue('P1', '外廓尺寸（mm）')
					->setCellValue('Q1', '车属单位')
					->setCellValue('R1', '负责单位主官')
					->setCellValue('S1', '第一负责人')
					->setCellValue('T1', '第二负责人')
					->setCellValue('U1', '入档日期')
					->setCellValue('V1', '备注');

		// 插入数据

		if(!isset($param->RowData)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		$rowArr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V');
		$dataNum = count($param->RowData);
		$cellNum = count($rowArr);
		
		$resultArr = array();
		for($i=0;$i<$dataNum;$i++)
		{
			for($j=0;$j<$cellNum;$j++)
			{
				$targetCell = $rowArr[$j].($i+2);
				$targetCallValue = $param->RowData[$i][$j];

				array_push($resultArr, array(
					'key'=>$targetCell,
					'value'=>$targetCallValue
				));

				$objPHPExcel->getActiveSheet(0)->setCellValue($targetCell, $targetCallValue);	
			}   
		}

		$allTagNum = "A1:V".($dataNum + 1);


		//$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setSize(8)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($allTagNum)->getFont()->setSize(8)->setBold(true);
		
		// 自动换行
		//$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle($allTagNum)->getAlignment()->setWrapText(true);

		// - 全加边框的方法
		$style_array = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			) 
		);
		//$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($style_array);
		$objPHPExcel->getActiveSheet()->getStyle($allTagNum)->applyFromArray($style_array);

		// 只有左边框
		// $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// 设置打印横向
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// 设置打印竖向
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		// 水平居中
		//$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($allTagNum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// 垂直居中
		//$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($allTagNum)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		// 左对齐
		// $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

		// 右对齐
		// $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// 设置边距1英寸 = 2.54厘米) 
		$margin = 0.3 / 2.54; 
		$marginright = 0.3 / 2.54; 
		// 左边距
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
		// 右边距
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin); 
		// 上边距
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
		// 下边距
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);

		// 自动填充宽度
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth('1');

		// 自动填充高度
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight('1');

		// 设置宽度
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension($allTagNum)->setWidth(6);
		
		$objPHPExcel->getActiveSheet()->setTitle('车辆基本信息');

		// 保存Excel 2007格式文件，保存路径为当前路径，名字为export.xlsx
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		$fileName = "车辆基本信息";
		// 增加时间选项
		$time = time();
		$datetime = date('Ymd',$time);
		// 转换字符
		$filePath = iconv('utf-8','gb2312',$fileName);

		$d = date('Y-m-d');
		$dirName = dirname(__FILE__).'/Exports/'.$d;
		if(!file_exists($dirName))
		{
			mkdir($dirName, 0777, true);
		}

		if(file_exists($dirName))
		{	
			// 随机数
			$r = rand(1000, 9999);
			$savePath = $dirName."/".$filePath."_".$datetime."_".$r.".xlsx";
			$objWriter->save($savePath);  
			GLogger(__FILE__,__LINE__,__FUNCTION__,'图片保存路径='.$savePath);
			
			// 输出结果需要在转换回来
			$savePath = iconv('gb2312','utf-8',$savePath);
			$aRet['content'] = array(
				"Path" => $savePath
			);
		}
		else{
			$aRet['errorCode'] = ErrorCode::FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "导出Excel异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}


function UploadExcelToDB($param){
	try{
		global $db_link;
		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!empty($_FILES)){
			$excelFile = $_FILES['Excel-Uploader'];

			$file_ext = strtolower(pathinfo($excelFile['name'], PATHINFO_EXTENSION));

			if (!in_array($file_ext, array('xlsx','xls'))){
                GLogger(__FILE__, __LINE__, __FUNCTION__, "extension($file_ext) not allowed.");
				$aRet['errorCode'] = ErrorCode::UPLOAD_PHOTO_EXT_ERROR;
				return $aRet;
            }

			$d = date('Y-m-d');
			$dirName = dirname(__FILE__).'/Imports/'.$d;
			
			if(!file_exists($dirName))
            {
                mkdir($dirName, 0777, true);
			}
			

			if(file_exists($dirName))
            {
                // 随机数
				$r = rand(1000, 9999);

				$time = time();
				$datetime = date('Ymd',$time);

                $saveName = $datetime."_".$r.".{$file_ext}";
                $savePath = "$dirName/$saveName";
				GLogger(__FILE__,__LINE__,__FUNCTION__,'savePath='.$savePath);
				

				$sqlArr = array();
                if(move_uploaded_file($excelFile['tmp_name'], $savePath))
                {
					// 查询所有油耗信息
					$fuelArr = array();
					$fuelSql = "SELECT * FROM fuelinfo";
					$fuelResult = $db_link->Query($fuelSql);
					if(!$fuelResult){
						$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
						return $aRet;
					}
					else{
						while(RowFetchObject($row, $fuelResult, $db_link)){
							array_push($fuelArr, array(
								'Index'=>$row->Index,
								'Name'=>$row->Name
							));
						}
					}

					// 强行入库（清空数据库，索引恢复。相当于在建一次表）
					$removeSQL = "truncate VehicleInfo;";
					$Dresult = $db_link->Query($removeSQL);
					if(!$Dresult){
						$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
						return $aRet;
					}

					require_once "../Classes/PHPExcel.php";
					require_once '../Classes/PHPExcel/IOFactory.php';
					
					$PHPExcel = new PHPExcel();

					if($file_ext == 'xls'){
						require_once "../Classes/PHPExcel/Reader/Excel5.php";
						$PHPReader = new PHPExcel_Reader_Excel5();
					}
					else{
						require_once "../Classes/PHPExcel/Reader/Excel2007.php";
						$PHPReader = new PHPExcel_Reader_Excel2007();
					}
					
					$PHPExcel = $PHPReader->load($savePath);

					//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
					$currentSheet = $PHPExcel->getSheet(0);

					//获取总列数
					$allColumn = $currentSheet->getHighestColumn();
					//获取总行数
					$allRow = $currentSheet->getHighestRow();

					$sqlNUM = 0;
					$insertSQL = "";
					$insertValue = "";

					//循环读取excel文件,读取一条,插入一条
					//i表示从哪一行开始读取
					for($i=2;$i<=$allRow;$i++)
					{	
						// 获取当前整行数据
						$rowData = $currentSheet->rangeToArray('A' . $i . ':'. $allColumn . $i, NULL, TRUE, FALSE);

						foreach($rowData as $row)
						{
							$ID = $row[0];
							$VIN_NO = $row[1];
							$ENGINE_SERIAL_NUMBER = $row[2];
							$V_Dept_Manager = $row[3];
							$V_Employee_Manager = $row[4];
							$Model = $row[5];
							$Time = $row[6];
							$Color = $row[7];
							$FuelName = $row[8];

							$FuelIndex = "0";
							if(count($fuelArr) > 0){
								foreach($fuelArr as $fuel){
									if($FuelName == $fuel['Name']){
										$FuelIndex = $fuel['Index'];
									}
								}
							}

							$Seating = $row[9];
							$Mileage = $row[10];
							$Oil_Wear = $row[11];
							$TankSize = $row[12];
							$Total_mass = $row[13];
							$Maximum_Load = $row[14];
							$Overall_Dimension = $row[15];
							$V_Dept = $row[16];
							$Responsible_Officer = $row[17];
							$FirstLeading_Person = $row[18];
							$SecondLeading_Person = $row[19];
							$Register_Time = $row[20];
							$Remark = $row[21];


							$insertValue = "('$ID','$VIN_NO','$ENGINE_SERIAL_NUMBER','$Model',null,'$FuelIndex','$Color','$Seating','$Time','$Mileage','$Oil_Wear','$TankSize','$Maximum_Load','$Total_mass','$Overall_Dimension','$V_Dept','$V_Dept_Manager','$V_Employee_Manager','$Register_Time','$Responsible_Officer','$FirstLeading_Person','$SecondLeading_Person',now(),'$Remark')";

							array_push($sqlArr, $insertValue);
						}
					}	

					// 分割数组,以200元素分割一次
					$chunkSql = array_chunk($sqlArr, 200, false);
					
					foreach($chunkSql as $sql){
						
						$valueList = implode(',',$sql);

						$sqlArr = array();
					
						$insertSQL = "INSERT IGNORE INTO `VehicleInfo`(`ID`, `VIN_NO`, `ENGINE_SERIAL_NUMBER`, `Model`, `Brand`, `Fuel_Index`, `Color`, `Seating`, `Time`, `Mileage`, `Oil_Wear`, `TankSize`, `Maximum_Load`, `Total_mass`, `Overall_Dimension`, `V_Dept`, `V_Dept_Manager`, `V_Employee_Manager`, `Register_Time`, `Responsible_Officer`, `FirstLeading_Person`, `SecondLeading_Person`, `ModifyDateTime`, `Remark`) VALUE";
					
						$query = $insertSQL.$valueList;
						GLogger(__FILE__,__LINE__,__FUNCTION__,'Excel解析的SQL='.$query);
						$result = $db_link->Query($query);
						if(!$result){
							$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
							return $aRet;
						}
					}
                }
            }
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "导出Excel异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}


function DeleteVehicleInfo($param){
	try{
		global $db_link;

		$aRey = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->VehicleInfo_Index)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆基本信息参数错误,VehicleInfo_Index:".$param->VehicleInfo_Index);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		if(!isset($param->DeleteFlag)){
			$param->DeleteFlag = 0;
		}

		$query = "";
		if($param->DeleteFlag == 0){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆基本信息类型：删除基本信息");
			$query = "DELETE FROM VehicleInfo WHERE `Index`='$param->VehicleInfo_Index'";
			
		}
		else{
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆基本信息类型：强制删除全部信息");
			$query = "DELETE vi,mi,oi,va FROM `vehicleinfo` vi 	LEFT OUTER JOIN maintaininfo mi on mi.`VehicleInfo_Index` = vi.`Index` LEFT OUTER JOIN oilconsumptioninfo oi on oi.`VehicleInfo_Index` = vi.`Index` LEFT OUTER JOIN vehicleuseapplicationinfo va on va.`VehicleInfo_Index` = vi.`Index` WHERE vi.`Index`='$param->VehicleInfo_Index'";
		}

		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆基本信息SQL=".$query);
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆基本信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function DeleteVehicleMainTainInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->MainTainInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆维修保养参数错误,MainTainInfo_Index:".$param->MainTainInfo_Index);
			return $aRet;
		}

		$query = "DELETE FROM maintaininfo WHERE `Index` = '$param->MainTainInfo_Index'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆维修保养信息：SQL=".$query);
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆维修保养信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function DeleteOilConsumptionInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->OilConsumptionInfo_Index)){
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆维修保养参数错误,OilConsumptionInfo_Index:".$param->OilConsumptionInfo_Index);
			return $aRet;
		}

		$query = "DELETE FROM oilconsumptioninfo WHERE `Index` = '$param->OilConsumptionInfo_Index'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆维修保养信息：SQL=".$query);
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆油耗信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetDeviceHistoryGPSData($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->beginTime) OR !isset($param->endTime)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取设备GPS历史轨迹参数出错,beginTime:".$param->beginTime.",或者endTime:".$param->endTime);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		if(!isset($param->PUID) AND !isset($param->VehicleID)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取设备GPS历史轨迹参数出错,PUID:".$param->PUID.",或者VehicleID:".$param->VehicleID);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		if(!isset($param->offset)){
			$param->offset = 0;
		}

		if(!isset($param->count)){
			$param->count = 200;
		}

		$query = "SELECT hd.PUID, hd.ResIdx, hd.Latitude, hd.Longitude, hd.Bearing, hd.Speed, hd.Altitude, hd.UTC, hd.State, hd.MaxSpeed, hd.MinSpeed FROM cnrms_ces_v8_storage.historygpsdata hd INNER JOIN cnrms_ces_v8.puinfo pi ON pi.PUID = hd.PUID INNER JOIN cnrms_ces_v8.puresourceinfo pr ON pr.PUInfo_Index = pi.`Index` WHERE pr.Type = 'SELF' AND pr.`Enable` = '1' AND pr.Registered = '1' AND (pi.PUID = '$param->PUID' OR pr.`Name` = '$param->VehicleID') AND (hd.UTC BETWEEN '$param->beginTime' AND '$param->endTime') ORDER BY UTC ASC LIMIT {$param->offset}, {$param->count} ";

		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取历史GPS数据SQL=".$query);

		$result = $db_link->Query($query);

		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$gpsDataArr = array();
			while(RowFetchObject($row, $result, $db_link)){
				$gpsData = new HistoryGPSDataStruct();
				$gpsData->PUID = $row->PUID;
				$gpsData->ResIdx = $row->ResIdx;
				$gpsData->Latitude = $row->Latitude;
				$gpsData->Longitude = $row->Longitude;
				$gpsData->Bearing = $row->Bearing;
				$gpsData->Speed = $row->Speed;
				$gpsData->Altitude = $row->Altitude;
				$gpsData->UTC = $row->UTC;
				$gpsData->State = $row->State;
				$gpsData->MaxSpeed = $row->MaxSpeed;
				$gpsData->MinSpeed = $row->MinSpeed;

				array_push($gpsDataArr, $gpsData);
			}

			$aRet['content'] = $gpsDataArr;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆油耗信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function GetVehicleApprovalInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->date)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆审批信息参数错误,date:".$param->date);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		$query = "SELECT vai.`Index`, vai.`VehicleInfo_Index`, vi.ID, vi.V_Dept, vi.V_Dept_Manager, vai.`Person`, vai.BeginTime, vai.EndTime, vai.SubmitDate, vai.ModifyDateTime, vai.`Remark` FROM VehicleApprovalInfo vai INNER JOIN vehicleinfo vi on vi.`Index` = vai.`VehicleInfo_Index` WHERE SubmitDate='$param->date'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆审批信息SQL=".$query);
		
		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}
		else{
			$ApprovalArr = array();
			while(RowFetchObject($row, $result, $db_link)){
				$approvalInfo = new VehicleApprovalInfoStruct();
				$approvalInfo->Index = $row->Index;
				$approvalInfo->VehicleInfo_Index = $row->VehicleInfo_Index;
				$approvalInfo->ID = $row->ID;
				$approvalInfo->V_Dept = $row->V_Dept;
				$approvalInfo->V_Dept_Manager = $row->V_Dept_Manager;
				$approvalInfo->Person = $row->Person;
				$approvalInfo->BeginTime = $row->BeginTime;
				$approvalInfo->EndTime = $row->EndTime;
				$approvalInfo->SubmitDate = $row->SubmitDate;
				$approvalInfo->ModifyDateTime = $row->ModifyDateTime;
				$approvalInfo->Remark = $row->Remark;

				array_push($ApprovalArr, $approvalInfo);
			}
			$aRet['content'] = $ApprovalArr;
		}	
		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆审批信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function AddVehicleApprovalInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->date)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆审批信息参数错误,date:".$param->date);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		if(!isset($param->dataList) OR !count($param->dataList) > 0){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆审批信息参数错误,dataList:".print_r($dataList, true));
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		$valueArr = array();

		foreach($param->dataList as $data){
			array_push($valueArr, "('$data->VehicleInfo_Index', '$data->Person', '$data->BeginTime', '$data->EndTime', '$param->date', now(), null)");
		}
		$insertValue = implode(',', $valueArr);

		$query = "INSERT INTO VehicleApprovalInfo (VehicleInfo_Index, Person, BeginTime, EndTime, SubmitDate, ModifyDateTime, Remark) VALUE ".$insertValue;
		
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加审批记录SQL=".$query);

		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}

		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加车辆审批信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}

function DeleteVehicleApprovalInfo($param){
	try{
		global $db_link;

		$aRet = array(
			'errorCode' => ErrorCode::SUCCESS
		);

		if(!isset($param->ApprovalInfo_Index)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆审批信息参数错误,ApprovalInfo_Index:".$param->ApprovalInfo_Index);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		if(!isset($param->date)){
			GLogger(__FILE__, __LINE__, __FUNCTION__, "删除车辆审批信息参数错误,date:".$param->date);
			$aRet['errorCode'] = ErrorCode::PARAM_NOT_VALID;
			return $aRet;
		}

		$query = "DELETE FROM VehicleApprovalInfo WHERE `Index` = '$param->ApprovalInfo_Index' AND `SubmitDate` = '$param->date'";
		GLogger(__FILE__, __LINE__, __FUNCTION__, "添加审批记录SQL=".$query);

		$result = $db_link->Query($query);
		if(!$result){
			$aRet['errorCode'] = ErrorCode::DB_MYSQL_OPERATE_FAILED;
			return $aRet;
		}


		return $aRet;
	}
	catch(Exception $e){
		GLogger(__FILE__, __LINE__, __FUNCTION__, "获取车辆审批信息异常,异常消息:$e->getMessage()");
		return array('errorCode' => ErrorCode::THREAD);
	}
}
?>