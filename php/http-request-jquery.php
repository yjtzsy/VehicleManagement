<html> 
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"></meta>
	
	<style>
	.pro_label {width:130px;text-align:center;}
	.submit_div {width:300px;text-align:center;margin-top:20px;}
	
	</style>
	 
	<script type="text/javascript" src="../src/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="../src/jquery/lib/jquery.json-2.4.js"></script>
	
	<script type="text/javascript">

	jQuery(document).ready(function () {
		
		if(false){
			data = {
				request: {
					action: 'GetFuelInfo',
					content: {
					}
				}
			};	
		}

		if(false){
			data = {
				request: {
					action: 'AddVehicleInfo',
					content: {
						ID: '皖AKD102',
						VIN_NO: '56B12C',
						ENGINE_SERIAL_NUMBER: '998712344355656768676SE',
						Model: '小型轿车',
						Brand: '三菱',
						Fuel_Index: '2',
						Color: '皓月白',
						Seating: '5',
						Time: '2018-10-17',
						Mileage: '76543',
						Oil_Wear: '10',
						TankSize: '55',
						Maximum_Load: '56000',
						Total_mass: '14000',
						Overall_Dimension: '4600*2400*2200',
						V_Dept: '个人',
						V_Dept_Manager: '个人',
						V_Employee_Manager: '曾恒旭',
						Register_Time: '2012-12-1',
						Responsible_Officer: '曾恒旭',
						FirstLeading_Person: '曾恒旭',
						SecondLeading_Person:'曾恒旭'
					}
				}
			};	
		}

		if(false){
			data = {
				request: {
					action: 'GetVehicleInfo',
					content: {
						ID : ''
					}
				}
			};	
		}

		if(false){
			data = {
				request: {
					action: 'ModifyVehicleInfo',
					content: {
						index : '3',
						Model: '小型轿车',
						Brand: '三菱',
						Fuel_Index: '2',
						Color: '皓月白',
						Seating: '5',
						Time: '2018-10-17',
						Mileage: '76543',
						Oil_Wear: '10',
						TankSize: '55',
						Maximum_Load: '56000',
						Total_mass: '14000',
						Overall_Dimension: '4600*2400*2200',
						V_Dept: '个人',
						V_Dept_Manager: '个人',
						V_Employee_Manager: '曾恒旭',
						Register_Time: '2012-12-3',
						Responsible_Officer: '曾恒旭',
						FirstLeading_Person: '曾恒旭',
						SecondLeading_Person:'曾恒旭'
					}
				}
			};	
		}

		if(false){
			data = {
				request: {
					action: 'CheckVehicleUniqueColumn',
					content: {
						ID : '皖AKD102',
						VIN_NO:'56B12C'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'AddVehicleApplicationInfo',
					content: {
						UseDept : '个人',
						VehicleDept : '个人',
						VehicleModel : '三菱',
						VehicleInfo_Index : '3',
						UseContent : '上班',
						Car_owner : '曾恒旭',
						Driving_route : '合肥南站#合肥西站#创始科技',
						Schedule : 'b#2018Y10M18D15H20m|e#2018Y10M18D15H21m',
						Driver : '曾恒旭',
						Time : '2018-10-18 15:58:13',
						Replies : '曾恒旭',
						Contractor : '曾恒旭',
						Remark : ''
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'AddOilConsumptionInfo',
					content: {
						Registrant : '曾恒旭',
						oilList : [{
							VehicleInfo_Index : '1',
							Date : '2018-10-20',
							First_Refueling_Mileage:'1000',
							Total_Mileage : '1200',
							Oil_Number : '22',
							Oil_Person : '曾恒旭',
							Driver : '曾恒旭'
						},{
							VehicleInfo_Index : '1',
							Date : '2018-10-21',
							First_Refueling_Mileage:'1200',
							Total_Mileage : '1400',
							Oil_Number : '22',
							Oil_Person : '曾恒旭',
							Driver : '曾恒旭'
						},{
							VehicleInfo_Index : '1',
							Date : '2018-10-22',
							First_Refueling_Mileage:'1400',
							Total_Mileage : '1600',
							Oil_Number : '22',
							Oil_Person : '曾恒旭',
							Driver : '曾恒旭'
						}]
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'AddVehicleMainTainInfo',
					content: {
						Registrant : '曾恒旭',
						mainTainList : [{
							VehicleInfo_Index : '1',
							Date : '2018-10-20',
							MainTain_Reason : '正常保养',
							MainTain_Content : '1.更换机油，机滤。2.清洗节气阀。3.更换空气滤芯。4.更换空调滤芯。5.行车安全监测。6.洗车',
							Next_MainTain_Date : '2019-05-20',
							Repairman : '曾恒旭',
							Driver : '曾恒旭',
							Cost : '3470'
						},{
							VehicleInfo_Index : '1',
							Date : '2018-10-21',
							MainTain_Reason : '轮胎漏气',
							MainTain_Content : '1.更换气门嘴。2.更换轮胎。3.动平台。4.四轮定位。',
							Next_MainTain_Date : '2019-05-20',
							Repairman : '曾恒旭',
							Driver : '曾恒旭',
							Cost : '1560'
						},{
							VehicleInfo_Index : '1',
							Date : '2018-10-22',
							MainTain_Reason : '电池馈电',
							MainTain_Content : '1.更换电池。2.行车电脑升级。3.安全监测线路。4.工时。',
							Next_MainTain_Date : '2019-05-20',
							Repairman : '曾恒旭',
							Driver : '曾恒旭',
							Cost : '5500'
						}]
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetVehicleApplicationInfo',
					content: {
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetOilConsumptionInfo',
					content: {
						ID : ''
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'ModifyOilConsumptionInfo',
					content: {
						OilConsumptionInfo_Index : '1',
						Date : '2011-01-02'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetVehicleMainTainInfo',
					content: {
						ID : ''
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'ModifyVehicleMainTainInfo',
					content: {
						MainTainInfo_Index : '1',
						Date : '2011-01-02'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetNextMainTainDateTime',
					content: {
						VehicleInfo_Index : '1'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetTotalMileage',
					content: {
						VehicleInfo_Index : '1'
					}
				}
			};
		}

		if(true){
			data = {
				request: {
					action: 'ExportExcelForVehicleInfo',
					content: {
						Title : '文档标题',
						Subject : '文档主题',
						Description :'文档的描述信息',
						Keywords : '文档关键词',
						Category : '文档的分类',
						RowData : []
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'DeleteVehicleInfo',
					content: {
						VehicleInfo_Index : '1',
						DeleteFlag : '0'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'DeleteVehicleMainTainInfo',
					content: {
						MainTainInfo_Index : '2',
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'DeleteOilConsumptionInfo',
					content: {
						OilConsumptionInfo_Index : '2',
					}
				}
			};
		}

		if(true){
			data = {
				request: {
					action: 'GetDeviceHistoryGPSData',
					content: {
						beginTime : '2018-01-01 00:00:00',
						endTime : '2019-01-01 00:00:00',
						PUID : '',
						VehicleID : '03383',
						offset : '0',
						count : '1000'

					}
				}
			};
		}
		
		if(false){
			data = {
				request: {
					action: 'AddVehicleApprovalInfo',
					content: {
						date : '2019-01-07',
						dataList : [{
							VehicleInfo_Index : '1',
							Person : '增恒旭',
							BeginTime : '2019-01-07 08:00:00',
							EndTime : '2019-01-08 18:00:00'
						},{
							VehicleInfo_Index : '2',
							Person : '增恒旭',
							BeginTime : '2019-01-07 08:00:00',
							EndTime : '2019-01-08 18:00:00'
						}]
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'GetVehicleApprovalInfo',
					content: {
						date : '2019-01-07'
					}
				}
			};
		}

		if(false){
			data = {
				request: {
					action: 'DeleteVehicleApprovalInfo',
					content: {
						date : '2019-01-07',
						ApprovalInfo_Index :'1'
					}
				}
			};
		}
		var jsonStr = jQuery.toJSON(data);
		
		jQuery('#request').val(jsonStr);
			
	});
	
	var send_http_request = function () {
		try {
			var jsonStr = jQuery('#request').val();
			
			jQuery.ajax({
				url: 'service/index.php',
				method: 'post',
				data: jsonStr,
				dataType: 'json',
				processData: false,
				success: function (data, ts) {
					jQuery('#response').val(jQuery.toJSON(data));
				},
				error: function (xhr, ts) {
					jQuery('#response').val('请求出错');
				}
			});
			
		}
		catch (e) {
			alert("excep -> " + e.name + "," + e.message);
		}
	};

	</script>
	
</head>

<body>
	<table>
		<tr>
			<td>请求报文主体：</td>
			<td><textarea id="request" rows="10" cols="100" style="width:800px;height:300px;"></textarea></td>
		</tr>
		<tr>
			<td><button onclick="send_http_request();">发送请求</button></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>响应报文主体：</td>
			<td><textarea id="response" rows="10" cols="100" style="width:800px;height:300px;"></textarea></td>
		</tr>
	</table>

</body>
</html>