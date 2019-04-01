var Client={
	select:"",
	store:[],
	store_new:[],
	storeID:[],
	register:[],
	register_excel:[],
	oilCount:[],
	oilCount_excel:[],
	Fuel:[],
	apply:[],
	register_index:null,
	oil_index:null,
	flag:true,
	GetVehicleApplicationInfo:function(){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.apply=[];
				var content=rv.response.content;
				for(var i=0;i<content.length;i++){
					var str=content[i].Driving_route.split("|");
					var out_time=content[i].Schedule.split("|")[0].substr(2);
					var in_time=content[i].Schedule.split("|")[1].substr(2);
					var time=content[i].Time.substr(0,10).split("-");
					var reg=/(\w*)M(.*)D(.*)H(.*)m/g
				    out_time=out_time.replace(reg,"$1月$2日$3时$4分");
				    in_time=in_time.replace(reg,"$1月$2日$3时$4分");
					Client.apply.push({
						VehicleID:content[i].VehicleID,
						VehicleDept:content[i].VehicleDept,
						VehicleModel:content[i].VehicleModel,
						UseDept:content[i].UseDept,
						UseContent:content[i].UseContent,
						Car_owner:content[i].Car_owner,
						Driving_route:"&#160;起点：&#160;"+str[0]+"&#160;目的地:&#160;"+str[1],
						out_time:out_time,
						in_time:in_time,
						Driver:content[i].Driver,
						Time:time[0]+"年"+time[1]+"月"+time[2]+"日",
						Replies:content[i].Replies,
						Contractor:content[i].Contractor,
						Status:content[i].Status,
						Remark:content[i].Remark
					});
				}
			}
		}
		Ajax.SendAjax("GetVehicleApplicationInfo",{},callback);
	},
	//用车审请单
	AddVehicleApplicationInfo:function(req,res){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				var obj=$(".exam input");
				$("#Remark").val("");
				obj.each(function(item,value){
					if(value.value=="重置"||value.value=="保存并导出"){
						return;
					}else{
						value.value="";
					}
				});
				alert("保存成功");
			}else{
				alert("提交失败！");
				return false;
			}
		}
		Ajax.SendAjax(
			'AddVehicleApplicationInfo',
			{
				UseDept : req.UseDept,
				VehicleDept : req.VehicleDept,
				VehicleModel : req.VehicleModel,
				VehicleInfo_Index : req.VehicleInfo_Index,
				UseContent : req.UseContent,
				Car_owner : req.Car_owner,
				Driving_route : req.Driving_route,
				Schedule : req.Schedule,
				Driver : req.Driver,
				Time : req.Time,
				Replies : req.Replies,
				Contractor : req.Contractor,
				Remark : req.Remark
			},callback);
	},
	GetVehicleInfo:function(ID){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				if(typeof ID == "undefined" || ID == ""){
					Client.storeID=[];
				}
				Client.store=[];
				Client.store_new=[];
				var res=rv.response.content;
				for(var i=0;i<res.length;i++){
					if(typeof ID == "undefined" || ID == ""){
						Client.storeID[res[i].ID]={index:res[i].index,VIN_NO: res[i].VIN_NO};
					}
					var index = res[i].index;
					var IDS = res[i].ID;
					var VIN_NO = res[i].VIN_NO;
					var ENGINE_SERIAL_NUMBER = res[i].ENGINE_SERIAL_NUMBER;
					var Model = res[i].Model;
					var Fuel_Index = Client.Fuel[res[i].Fuel_Index];
					var Color = res[i].Color;
					var Seating = res[i].Seating;
					var Time = res[i].Time;
					Time = Time.substring(0,10);
					var Mileage = res[i].Mileage;
					var Oil_Wear = res[i].Oil_Wear;
					var TankSize = res[i].TankSize;
					var Maximum_Load = res[i].Maximum_Load;
					var Total_mass = res[i].Total_mass;
					var Overall_Dimension = res[i].Overall_Dimension;
					var V_Dept = res[i].V_Dept;
					var V_Dept_Manager = res[i].V_Dept_Manager;
					var V_Employee_Manager = res[i].V_Employee_Manager;
					var Register_Time = res[i].Register_Time;
					var Responsible_Officer = res[i].Responsible_Officer;
					var FirstLeading_Person = res[i].FirstLeading_Person;
					var SecondLeading_Person = res[i].SecondLeading_Person;
					var remark = res[i].Remark;
					var arr=[
					   IDS,
					   VIN_NO,
					   ENGINE_SERIAL_NUMBER,
					   V_Dept_Manager,
					   V_Employee_Manager,
					   Model,
					   Time,
					   Color,
					   Fuel_Index,
					   Seating,
					   Mileage,
					   Oil_Wear,
					   TankSize,
					   Total_mass,
					   Maximum_Load,
					   Overall_Dimension,
					   V_Dept,
					   Responsible_Officer,
					   FirstLeading_Person,
					   SecondLeading_Person,
					   Register_Time,
					   remark
					];
					Client.store_new.push(arr);
					Client.store.push({
						index:index,
						ID: IDS,
						VIN_NO: VIN_NO,
						ENGINE_SERIAL_NUMBER: ENGINE_SERIAL_NUMBER,
						Model: Model,
						Fuel_Index: Fuel_Index,
						Color: Color,
						Seating: Seating,
						Time: Time,
						Mileage: Mileage,
						Oil_Wear: Oil_Wear,
						TankSize: TankSize,
						Maximum_Load: Maximum_Load,
						Total_mass: Total_mass,
						Overall_Dimension: Overall_Dimension,
						V_Dept: V_Dept,
						V_Dept_Manager: V_Dept_Manager,
						V_Employee_Manager: V_Employee_Manager,
						Register_Time: Register_Time,
						Responsible_Officer: Responsible_Officer,
						FirstLeading_Person: FirstLeading_Person,
						SecondLeading_Person:SecondLeading_Person,
						remark:remark
					});
				}
				var html="";
				for(var i=0;i<Client.store.length;i++){
					html +="	<tr class='basic_pointer' myType='noActive' attribute="+Client.store[i].index+" str_index="+i+">";
					html +="		<td>"+(i+1)+"</td>";
					html +="		<td>"+Client.store[i].ID+"</td>";
					html +="		<td>"+Client.store[i].VIN_NO+"</td>";
					html +="		<td>"+Client.store[i].V_Dept+"</td>";
					html +="		<td>"+Client.store[i].V_Dept_Manager+"</td>";
					html +="		<td>"+Client.store[i].V_Employee_Manager+"</td>";
					html +="		<td>"+Client.store[i].Responsible_Officer+"</td>";
					html +="		<td>"+Client.store[i].FirstLeading_Person+"</td>";
					html +="		<td>"+Client.store[i].SecondLeading_Person+"</td>";
					html +="	</tr>";
				}
				$("#basic_content").html(html);
				$(".basic_pointer").off().on('click',function(){
					$(".basic_pointer").css("background","#FFFFFF");
					$(this).css("background","#F3EDAF");
					$(".basic_pointer").attr("myType","noActive");
					$(this).attr("myType","Active");
				}).on('dblclick',function(){
					$(".basic_pointer").css("background","#FFFFFF");
					$(this).css("background","#F3EDAF");
					$(".basic_pointer").attr("myType","noActive");
					$(this).attr("myType","Active");
					var str_index=$(this).attr("str_index");
					var index=$(this).attr("attribute");
					Custom.addBasicInfo(Client.store[str_index]);
					Custom.showMask();
				});
				$("#modify").off().on("click",function(){
					var index=$(".basic_pointer[myType='Active']").attr("attribute");
					var str_index=$(".basic_pointer[myType='Active']").attr("str_index");
					if(index!=null){
						Custom.addBasicInfo(Client.store[str_index],index);
						Custom.showMask();
						index=null;
					}else{
						alert("请点击列表选中一条数据在进行操作");
						return false;
					}
				});
				$("#delete").off().on("click",function(){
					var index=$(".basic_pointer[myType='Active']").attr("attribute");
					if(index!=undefined){
						var r=confirm("该操作将删除车辆基本信息以及相关信息，确定要继续吗?")
					    if (r==true)
					    {
						    Client.DeleteVehicleInfo(index);
						}
					}else{
						alert("请点击列表选中一条数据在进行操作");
						return false;
					}
				});
				var html = "";
				for(var i=0;i<Client.store.length;i++){
					html +="	<tr attribute="+Client.store[i].index+">";
					html +="        <td style='width:39px;'><input style='width:39px;' type='checkbox'/></td>";
					html +="		<td style='width:105px;'>"+Client.store[i].ID+"</td>";
					html +="		<td style='width:113px;'>"+Client.store[i].V_Dept+"</td>";
					html +="		<td style='width:143px;'>"+Client.store[i].V_Employee_Manager+"</td>";
					html +="		<td style='width:110px;'><input/></td>";
					html +="	</tr>";
				}
				$(".apply_content").html(html);
			}
		}
		Ajax.SendAjax("GetVehicleInfo",{ID : ID},callback);
	},
	AddVehicleInfo:function(req){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleInfo();
				Custom.hideMask();
				$(".add_box").remove();
			}else{
				alert("提交失败！");
				return false;
			}
		}
		Ajax.SendAjax(
			'AddVehicleInfo',
			{
				ID: req.ID,
				VIN_NO: req.VIN_NO,
				ENGINE_SERIAL_NUMBER: req.ENGINE_SERIAL_NUMBER,
				Model: req.Model,
				Brand: req.Brand,
				Fuel_Index: req.Fuel_Index,
				Brand:"",
				Color: req.Color,
				Seating: req.Seating,
				Time: req.Time,
				Mileage: req.Mileage,
				Oil_Wear: req.Oil_Wear,
				TankSize: req.TankSize,
				Maximum_Load: req.Maximum_Load,
				Total_mass: req.Total_mass,
				Overall_Dimension: req.Overall_Dimension,
				V_Dept: req.V_Dept,
				V_Dept_Manager: req.V_Dept_Manager,
				V_Employee_Manager: req.V_Employee_Manager,
				Register_Time: req.Register_Time,
				Responsible_Officer: req.Responsible_Officer,
				FirstLeading_Person: req.FirstLeading_Person,
				SecondLeading_Person:req.SecondLeading_Person,
				remark:req.remark
			},callback);
	},
	ModifyVehicleInfo:function(req,index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleInfo();
				Custom.hideMask();
				$(".add_box").remove();
			}else{
				alert("修改失败！");
				return false;
			}
		}
		Ajax.SendAjax(
			'ModifyVehicleInfo',
			{
				index:index,
				Model: req.Model,
				Brand: req.Brand,
				Fuel_Index: req.Fuel_Index,
				Color: req.Color,
				Seating: req.Seating,
				Time: req.Time,
				Mileage: req.Mileage,
				Oil_Wear: req.Oil_Wear,
				TankSize: req.TankSize,
				Maximum_Load: req.Maximum_Load,
				Total_mass: req.Total_mass,
				Overall_Dimension: req.Overall_Dimension,
				V_Dept: req.V_Dept,
				V_Dept_Manager: req.V_Dept_Manager,
				V_Employee_Manager: req.V_Employee_Manager,
				Register_Time: req.Register_Time,
				Responsible_Officer: req.Responsible_Officer,
				FirstLeading_Person: req.FirstLeading_Person,
				SecondLeading_Person:req.SecondLeading_Person,
				remark:req.remark
			},callback);
	},
	GetFuelInfo:function(){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.Fuel=[];
				for(var i=0;i<rv.response.content.length;i++){
					Client.Fuel[rv.response.content[i].index]=rv.response.content[i].name;
					Client.select +="<option value ='"+rv.response.content[i].index+"'>"+rv.response.content[i].name+"</option>"
				}
			}
		}
		Ajax.SendAjax("GetFuelInfo",{},callback);
	},
	GetVehicleMainTainInfo:function(ID){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.register_index=null;
				Client.register_excel=[];
				Client.register=[];
				var con=rv.response.content;
				var html="";
				for(var i=0;i<con.length;i++){
					Client.register[con[i].index]=con[i];
					Client.register_excel.push(con[i]);
					html +="	<tr class='reg_pointer' attribute="+con[i].index+">";
					html +="		<td>"+(i+1)+"</td>";
					html +="		<td>"+con[i].ID+"</td>";
					html +="		<td>"+con[i].VIN_NO+"</td>";
					html +="		<td>"+con[i].Date+"</td>";
					html +="		<td>"+con[i].MainTain_Reason+"</td>";
					html +="		<td>"+con[i].MainTain_Content+"</td>";
					html +="		<td>"+con[i].Next_MainTain_Date+"</td>";
					html +="		<td>"+con[i].Repairman+"</td>";
					html +="		<td>"+con[i].Driver+"</td>";
					html +="		<td>"+con[i].Cost+"</td>";
					html +="	</tr>";
				}
				$("#register_content").html(html);
				$(".reg_pointer").off().on('click',function(){
				    $(".reg_pointer").css("background","#FFFFFF");
					$(this).css("background","#F3EDAF");
					Client.register_index=$(this).attr("attribute");
				});
			}else{
				return;
			}
		}
		Ajax.SendAjax("GetVehicleMainTainInfo",{ID : ID},callback);
	},
	AddVehicleMainTainInfo:function(Registrant,mainTainList){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleMainTainInfo($("#reg_search").val());
				Custom.hideMask();
			    $(".add_registered").remove();
			}else{
				alert("提交失败！");
				return false;
			}
		}
		Ajax.SendAjax("AddVehicleMainTainInfo",{Registrant : Registrant,mainTainList:mainTainList},callback);
	},
	ModifyVehicleMainTainInfo:function(reg){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleMainTainInfo($("#reg_search").val());
				Custom.hideMask();
			    $(".add_registered").remove();
			}else{
				alert("修改失败！");
				return false;
			}
		}
		Ajax.SendAjax("ModifyVehicleMainTainInfo",{
			MainTainInfo_Index : reg.MainTainInfo_Index,
			Registrant:reg.Registrant,
			Date : reg.Date,
			MainTain_Reason : reg.MainTain_Reason,
			MainTain_Content : reg.MainTain_Content,
			Next_MainTain_Date : reg.Next_MainTain_Date,
			Repairman : reg.Repairman,
			Driver : reg.Driver ,
			Cost : reg.Cost},callback);
	},
	GetNextMainTainDateTime:function(VehicleInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				$("#nextKeepDate").val(rv.response.content.NextTime);
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("GetNextMainTainDateTime",{VehicleInfo_Index : VehicleInfo_Index},callback);
	},
	GetOilConsumptionInfo:function(ID){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.oil_index=null;
				Client.oilCount_excel=[];
				Client.oilCount=[];
				var con=rv.response.content;
				var html="";
				var IDNum;
				if(con[0]&&con[0].ID){
					IDNum=con[0].ID;
				}
				Client.flag=true;
				for(var i=0;i<con.length;i++){
					if(IDNum!=con[i].ID){
						Client.flag=false;
					}
					Client.oilCount[con[i].index]=con[i];
					Client.oilCount_excel.push(con[i]);
					html +="	<tr class='oil_pointer' attribute="+con[i].index+">";
					html +="		<td style='width:50px;'>"+(i+1)+"</td>";
					html +="		<td>"+con[i].ID+"</td>";
					html +="		<td>"+con[i].VIN_NO+"</td>";
					html +="		<td>"+con[i].Date+"</td>";
					html +="		<td>"+con[i].First_Refueling_Mileage+"</td>";
					html +="		<td>"+con[i].Total_Mileage+"</td>";
					html +="		<td>"+con[i].Oil_Number+"</td>";
					if(con[i].Total_Mileage>0)
					{
						html +="		<td>"+(con[i].Oil_Number/con[i].Total_Mileage).toFixed(5)+"</td>";
					}else{
						html +="		<td>-</td>";
					}
					html +="		<td>"+con[i].Oil_Person+"</td>";
					html +="		<td>"+con[i].Driver+"</td>";
					html +="	</tr>";
				}
				$("#oil_content").html(html);
				$(".oil_pointer").off().on('click',function(){
				    $(".oil_pointer").css("background","#FFFFFF");
					$(this).css("background","#F3EDAF");
					Client.oil_index=$(this).attr("attribute");
				});
			}else{
				return;
			}
		}
		Ajax.SendAjax("GetOilConsumptionInfo",{ID : ID},callback);
	},
	AddOilConsumptionInfo:function(Registrant,oilList){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetOilConsumptionInfo($("#oil_search").val());
				Custom.hideMask();
			    $(".add_OilCount").remove();
			}else{
				alert("提交失败！");
				return false;
			}
		}
		Ajax.SendAjax("AddOilConsumptionInfo",{Registrant:Registrant,oilList:oilList},callback);
	},
	ModifyOilConsumptionInfo:function(reg){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetOilConsumptionInfo($("#oil_search").val());
				Custom.hideMask();
			    $(".add_OilCount").remove();
			}else{
				alert("修改失败！");
				return false;
			}
		}
		Ajax.SendAjax("ModifyOilConsumptionInfo",{
			OilConsumptionInfo_Index : reg.OilConsumptionInfo_Index,
			Registrant:reg.Registrant,
			Date : reg.Date,
			First_Refueling_Mileage : reg.First_Refueling_Mileage,
			Total_Mileage : reg.Total_Mileage,
			Oil_Number : reg.Oil_Number,
			Oil_Person : reg.Oil_Person,
			Driver : reg.Driver},callback);
	},
	GetTotalMileage:function(VehicleInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				$("#firstRefuelMileage").val(rv.response.content.TotalMileage);
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("GetTotalMileage",{VehicleInfo_Index : VehicleInfo_Index},callback);
	},
	ExportExcelForVehicleInfo:function(arr){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				var url=document.location.toString();
				var url=url.toLocaleUpperCase();
				var vehicle="VehicleManagement".toLocaleUpperCase();
				var ip=url.split(vehicle)[0];
				var download=ip+"VehicleManagement/php/service/download.php"
				var path=rv.response.content.Path;
				path=encodeURIComponent(path);
				var url_path=download+"?path="+path;
				window.open(url_path);
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("ExportExcelForVehicleInfo",{RowData : arr},callback);
	},
	DeleteVehicleInfo:function(VehicleInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleInfo();
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("DeleteVehicleInfo",{VehicleInfo_Index : VehicleInfo_Index},callback);
	},
	DeleteVehicleMainTainInfo:function(MainTainInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleMainTainInfo($("#reg_search").val());
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("DeleteVehicleMainTainInfo",{MainTainInfo_Index : MainTainInfo_Index},callback);
	},
	DeleteOilConsumptionInfo:function(OilConsumptionInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetOilConsumptionInfo($("#oil_search").val());
				Custom.hideMask();
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("DeleteOilConsumptionInfo",{OilConsumptionInfo_Index : OilConsumptionInfo_Index},callback);
	},
	AddVehicleApprovalInfo:function(date,dataList){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleApprovalInfo($("#search_Time").val());
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("AddVehicleApprovalInfo",{date : date,dataList:dataList},callback);
	},
	GetVehicleApprovalInfo:function(date){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				var content=rv.response.content;
				var html = "";
				for(var i=0;i<content.length;i++){
					html +="	<tr attribute="+content[i].Index+" class='apply_pointer' style='cursor:pointer;'>";
					html +="		<td style='width:100px;'>"+content[i].ID+"</td>";
					html +="		<td style='width:100px;'>"+content[i].V_Dept+"</td>";
					html +="		<td style='width:100px;'>"+content[i].V_Dept_Manager+"</td>";
					html +="		<td style='width:100px;'>"+content[i].Person+"</td>";
					html +="		<td style='width:330px;'>"+content[i].BeginTime+"-"+content[i].EndTime+"</td>";
					html +="	</tr>";
				}
				$(".apply_query").html(html);
				var index;
				$(".apply_pointer").off().on('click',function(){
					$(".apply_pointer").css("background","#FFFFFF");
					$(this).css("background","#F3EDAF");
					index=$(this).attr("attribute");
				});
				$("#apply_delete").off().on("click",function(){
					if(index!=undefined){
						var r=confirm("确定要删除该数据吗?")
					    if (r==true)
					    {
						    Client.DeleteVehicleApprovalInfo($("#search_Time").val(),index);
						}
					}else{
						alert("请点击列表选中一条数据在进行操作");
						return false;
					}
				});
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("GetVehicleApprovalInfo",{date : date},callback);
	},
	DeleteVehicleApprovalInfo:function(date,ApprovalInfo_Index){
		var callback=function(rv){
			if(rv.response.errorCode=="0x0000"){
				Client.GetVehicleApprovalInfo($("#search_Time").val());
			}else{
				Ajax.Construct(rv.response.errorCode)
			}
		}
		Ajax.SendAjax("DeleteVehicleApprovalInfo",{date : date,ApprovalInfo_Index:ApprovalInfo_Index},callback);
	},
	end:true
}
