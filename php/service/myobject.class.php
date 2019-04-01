<?php

class FuelInfoStruct{
	public $index;
	public $name;
	public $modifyDateTime;
	public $remark;
}

class VehicleInfoStruct{
	public $index;
	public $ID;
	public $VIN_NO;
	public $ENGINE_SERIAL_NUMBER;
	public $Model;
	public $Brand;
	public $Fuel_Index;
	public $Color;
	public $Seating;
	public $Time;
	public $Mileage;
	public $Oil_Wear;
	public $TankSize;
	public $Maximum_Load;
	public $Total_mass;
	public $Overall_Dimension;
	public $V_Dept;
	public $V_Dept_Manager;
	public $V_Employee_Manager;
	public $Register_Time;
	public $Responsible_Officer;
	public $FirstLeading_Person;
	public $SecondLeading_Person;
}

class VehicleApplcationInfoStruct{
	public $index;
	public $VehicleInfo_Index;
	public $VehicleID;
	public $VehicleDept;
	public $VehicleModel;
	public $UseDept;
	public $UseContent;
	public $Car_owner;
	public $Driving_route;
	public $Schedule;
	public $Driver;
	public $Time;
	public $Replies;
	public $Contractor;
	public $Status;
	public $ModifyDateTime;
	public $Remark;
}

class OilConsumptionInfoStruct{
	public $index;
	public $VehicleInfo_Index;
	public $ID;
	public $VIN_NO;
	public $Date;
	public $First_Refueling_Mileage;
	public $Total_Mileage;
	public $Oil_Number;
	public $Oil_Person;
	public $Registrant;
	public $Driver;
	public $ModifyDateTime;
	public $Remark;
}

class MainTainInfoStruct{
	public $index;
	public $VehicleInfo_Index;
	public $ID;
	public $VIN_NO;
	public $Date;
	public $MainTain_Reason;
	public $MainTain_Content;
	public $Next_MainTain_Date;
	public $Repairman;	
	public $Driver;
	public $Cost;
	public $Registrant;
	public $RegistDatetime;
	public $ModifyDateTime;
	public $Remark;
}

class HistoryGPSDataStruct{
	public $PUID;
	public $ResIdx;
	public $Latitude;
	public $Longitude;
	public $Bearing;
	public $Speed;
	public $Altitude;
	public $UTC;
	public $State;
	public $MaxSpeed;
	public $MinSpeed;
}

class VehicleApprovalInfoStruct{
	public $Index;
	public $VehicleInfo_Index;
	public $ID;
	public $V_Dept;
	public $V_Dept_Manager;
	public $Person;
	public $BeginTime;
	public $EndTime;
	public $SubmitDate;
	public $ModifyDateTime;
	public $Remark;
}
?>