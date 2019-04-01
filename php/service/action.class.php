<?php
class Action {
	
	private function __construct() {}
	
	// 获取所有燃料信息
	CONST GetFuelInfo = "GetFuelInfo";

	// 添加车辆信息
	CONST AddVehicleInfo = "AddVehicleInfo";

	// 获取全部车辆信息
	CONST GetVehicleInfo = "GetVehicleInfo";

	// 修改车辆信息
	CONST ModifyVehicleInfo = "ModifyVehicleInfo";

	// 检车车辆信息唯一字段
	CONST CheckVehicleUniqueColumn = "CheckVehicleUniqueColumn";

	// 添加用车申请
	CONST AddVehicleApplicationInfo = "AddVehicleApplicationInfo";

	// 获取用车申请
	CONST GetVehicleApplicationInfo = "GetVehicleApplicationInfo";

	// 添加车辆油耗记录
	CONST AddOilConsumptionInfo = "AddOilConsumptionInfo";

	// 查询车辆油耗记录
	CONST GetOilConsumptionInfo = "GetOilConsumptionInfo";

	// 修改车辆油耗记录
	CONST ModifyOilConsumptionInfo = "ModifyOilConsumptionInfo";

	// 添加车辆维修记录
	CONST AddVehicleMainTainInfo = "AddVehicleMainTainInfo";

	// 查询车辆维修记录
	CONST GetVehicleMainTainInfo = "GetVehicleMainTainInfo";

	// 修改车辆维修记录
	CONST ModifyVehicleMainTainInfo = "ModifyVehicleMainTainInfo";

	// 获取车辆下次维修时间
	CONST GetNextMainTainDateTime = "GetNextMainTainDateTime";

	// 获取车辆总里程
	CONST GetTotalMileage = "GetTotalMileage";

	// 导出Excel
	CONST ExportExcelForVehicleInfo = "ExportExcelForVehicleInfo";

	// 读取Excel数据到DB
	CONST UploadExcelToDB = "UploadExcelToDB";
	
	// 删除车辆基本信息
	CONST DeleteVehicleInfo = "DeleteVehicleInfo";

	// 删除车辆保养信息
	CONST DeleteVehicleMainTainInfo = "DeleteVehicleMainTainInfo";

	// 删除车辆油耗信息
	CONST DeleteOilConsumptionInfo = "DeleteOilConsumptionInfo";

	// 获取设备GPS轨迹
	CONST GetDeviceHistoryGPSData = "GetDeviceHistoryGPSData";

	// ---------------- 未添加 ----------------

	// 获取车辆已审批记录
	CONST GetVehicleApprovalInfo = "GetVehicleApprovalInfo";

	// 添加车辆已审批记录
	CONST AddVehicleApprovalInfo = "AddVehicleApprovalInfo";

	// 删除车辆已审批记录
	CONST DeleteVehicleApprovalInfo = "DeleteVehicleApprovalInfo";

	
	// ---------------- 三期功能 ----------------
	// 获取设备与车辆关系
	CONST GetDeviceVehicleMap = "GetDeviceVehicleMap";

	// 设置设备与车辆关系
	CONST SetDeviceVehicleMap = "SetDeviceVehicleMap";

	// 修改设备与车辆关系
	CONST ModifyDeviceVehicleMap = "ModifyDeviceVehicleMap";

	// 删除设备与车辆关系
	CONST DeleteDeviceVehicleMap = "DeleteDeviceVehicleMap";

	// 未知函数
	CONST UnknownAction = "UnknownAction";

}
?>