set NAMES UTF8;

drop database if exists CR_CUSTOM_VehicleManagement;
create database CR_CUSTOM_VehicleManagement;

USE CR_CUSTOM_VehicleManagement;

drop table if exists `VehicleInfo`;
create table `VehicleInfo`(
    `Index` bigint(8) unsigned not null auto_increment comment '索引',
    `ID` varchar(255) not null comment '车牌号',
    `VIN_NO` varchar(16) not null comment '车架号',
    `ENGINE_SERIAL_NUMBER` varchar(255) not null comment '发动机序列号',
    `Model` varchar(255) not null comment '车型',
    `Brand` varchar(255) not null comment '品牌',
    `Fuel_Index` bigint(8) not null comment '燃料种类',
    `Color` varchar(255) not null comment '车辆颜色',
    `Seating` int(8) not null comment '座位数',
    `Time` datetime not null comment '配发时间',
    `Mileage` bigint(8) not null comment '里程',
    `Oil_Wear` varchar(8) not null comment '油耗',
    `TankSize` varchar(8) not null comment '油箱容积',
    `Maximum_Load` varchar(16) not null comment '最大载重',
    `Total_mass` varchar(64) not null comment '总质量',
    `Overall_Dimension` varchar(255) not null comment '外廓尺寸',
    `V_Dept` varchar(255) not null comment '车属单位',
    `V_Dept_Manager` varchar(255) not null comment '车辆管理部门',
    `V_Employee_Manager` varchar(32) not null comment '车辆管理人员',
    `Register_Time` date not null comment '入档日期',
    `Responsible_Officer` varchar(32) not null comment '负责单位主官',
    `FirstLeading_Person` varchar(32) not null comment '第一负责人',
    `SecondLeading_Person` varchar(32) not null comment '第二负责人',
    `ModifyDateTime` datetime not null comment '修改时间',
    `Remark` text null comment '备注',
    UNIQUE KEY `ID` (`ID`) USING BTREE,
    UNIQUE KEY `VIN_NO` (`VIN_NO`) USING BTREE,
    UNIQUE KEY `ENGINE_SERIAL_NUMBER` (`ENGINE_SERIAL_NUMBER`) USING BTREE,
    primary key (`Index`)
)engine=innodb auto_increment=1 default charset=utf8 comment '车辆信息表';

drop table if exists `MainTainInfo`;
create table `MainTainInfo`(
    `Index` bigint(8) unsigned not null auto_increment comment '索引',
    `VehicleInfo_Index` bigint(8) not null comment '车辆信息索引',
    `Date` date not null comment '日期',
    `MainTain_Reason` varchar(255) not null comment '维修原因',
    `MainTain_Content` text not null comment '维修内容',
    `Next_MainTain_Date` date not null comment '下次保养时间',
    `Repairman` varchar(32) not null comment '维修工',
    `Driver` varchar(32) not null comment '司机',
    `Cost` varchar(32) not null comment '费用',
    `ModifyDateTime` datetime not null comment '修改时间',
    `Remark` text null comment '备注',
    primary key (`Index`)
)engine=innodb auto_increment=1 default charset=utf8 comment '维修信息表';

drop table if exists `FuelInfo`;
create table `FuelInfo`(
    `Index` bigint(8) unsigned not null auto_increment comment '索引',
    `Name` varchar(32) not null comment '名称',
    `ModifyDateTime` datetime not null comment '修改时间',
    `Remark` text null comment '备注',
    primary key (`Index`)
)engine=innodb auto_increment=1 default charset=utf8 comment '燃料信息表';

drop table if exists `OilConsumptionInfo`;
create table `OilConsumptionInfo`(
    `Index` bigint(8) unsigned not null auto_increment comment '索引',
    `VehicleInfo_Index` bigint(8) not null comment '车辆信息索引',
    `Date` date not null comment '加油日期',
    `First_Refueling_Mileage` varchar(32) not null comment '初次加油里程数',
    `Total_Mileage` varchar(32) not null comment '总里程数',
    `Oil_Number` varchar(32) not null comment '加油数量（升）',
    `Oil_Person` varchar(32) not null comment '加油员',
    `Registrant` varchar(32) NOT NULL COMMENT '登记人',
    `Driver` varchar(32) not null comment '驾驶员',
    `ModifyDateTime` datetime not null comment '修改时间',
    `Remark` text null comment '备注',
    primary key (`Index`)
)engine=innodb auto_increment=1 default charset=utf8 comment '油耗信息表';

drop table if exists `VehicleUseApplicationInfo`;
create table `VehicleUseApplicationInfo`(
    `Index` bigint(8) unsigned not null auto_increment comment '索引',
    `VehicleInfo_Index` bigint(8) not null comment '车辆信息索引',
    `VehicleDept` varchar(255) NOT NULL COMMENT '出车单位',
    `VehicleModel` varchar(32) NOT NULL COMMENT '车辆型号',
    `UseDept` varchar(255) not null comment '用车单位',
    `UseContent` text not null comment '出车事由',
    `Car_owner` varchar(32) not null comment '带车人',
    `Driving_route` text not null comment '行驶路线',
    `Schedule` varchar(255) not null comment '出车行程',
    `Driver` varchar(32) not null comment '驾驶员',
    `Time` datetime not null comment '用车时间',
    `Replies` varchar(32) not null comment '批复人',
    `Contractor` varchar(32) not null comment '承办人',
    `Status` enum('1','0') not null comment '状态0未审核，1已审批',
    `ModifyDateTime` datetime not null comment '修改时间',
    `Remark` text null comment '备注',
    primary key (`Index`)
)engine=innodb auto_increment=1 default charset=utf8 comment '车辆使用申请信息表';


insert into fuelinfo values('1','0#柴油',now(),null);
insert into fuelinfo values('2','92#乙醇清洁汽油',now(),null);
insert into fuelinfo values('3','95#乙醇清洁汽油',now(),null);
insert into fuelinfo values('4','98#乙醇清洁汽油',now(),null);

drop table if exists `vehicleapprovalinfo`;
CREATE TABLE `vehicleapprovalinfo` (
  `Index` bigint(8) unsigned NOT NULL AUTO_INCREMENT,
  `VehicleInfo_Index` bigint(8) NOT NULL COMMENT '车辆基本信息索引',
  `Person` varchar(255) NOT NULL COMMENT '用车人',
  `BeginTime` datetime NOT NULL COMMENT '开始时间',
  `EndTime` datetime NOT NULL COMMENT '结束时间',
  `SubmitDate` date NOT NULL COMMENT '提交日期',
  `ModifyDateTime` datetime NOT NULL COMMENT '修改时间',
  `Remark` text COMMENT '备注',
  PRIMARY KEY (`Index`,`Person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='车辆审批信息表';


