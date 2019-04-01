var Custom={
	Load:function(){
		var html="";
		html +="<div id='wrap'>";
	    html +="    <div id='title'>";
	    html +="        <span class='select'>用车申请单</span>";
	    html +="        <span>车辆基础信息表</span>";
	    html +="        <span>车辆维修保养登记表</span>";
	    html +="        <span>单车油耗统计表</span>";
	    html +="        <span>用车审批单</span>";
	    html +="        <span>已审核车辆信息</span>";
	    html +="    </div>";
	    html +="    <ul id='content'>";
	    html +="        <li class='show' id='examine'></li>";
	    html +="        <li id='basicInfo'></li>";
	    html +="        <li id='register'></li>";
	    html +="        <li id='count'></li>";
	    html +="        <li id='apply'></li>";
	    html +="        <li id='query_apply'></li>";
	    html +="    </ul>";
	    html +="</div>";
		$("body").html(html);
		Client.GetVehicleApplicationInfo();
		Client.GetFuelInfo();
		Custom.GetExamine();
		Custom.GetBasicInfo();
		Client.GetVehicleInfo("");
		Custom.GetRegister();
		Custom.GetOilCount();
		Custom.GetApply();
		Custom.GetQueryApply();
		Custom.Init();
		Custom.Css_Resize();
		$('#title span').click(function() {
	        var i = $(this).index();
	        switch(i.toString()){
	        	case "1":
	        	   Client.GetVehicleInfo("");
	        	break;
	        	case "2":
	        	   Client.GetVehicleMainTainInfo("");
	        	break;
	        	case "3":
	        	   Client.GetOilConsumptionInfo("");
	        	break;
	        	case "4":
	        	   Custom.GetApply();
	        	break;
	        	case "5":
	        	   Client.GetVehicleApprovalInfo($("#search_Time").val());
	        	break;
	        }
	        $(this).addClass('select').siblings().removeClass('select');
	        $('#content li').eq(i).show().siblings().hide();
	    });
	},
	Init: function () {
		try {
			var user = window.location.search.replace('?','');
			var name=user.split('=')[0].toUpperCase();
				var id=user.split('=')[1];
			if(name!=undefined&&id!=undefined){
				switch (id) {
					case '1':
					    $(".control").css("display","block");
						break;
					case '2':
					case '3':
					case '4':
					    $(".control").css("display","none");
						break;
					default:
						$(".control").css("display","none");
						break;
				}
			}else{
				$(".control").css("display","none");
			}
		}
		catch (e) {
			alert(e.message);
			return false;
		} 
	},
	//用车申审批单
	GetExamine:function(){
		var html="";
		html +="<div style='width:auto;height:auto;'>";
		html +="	<table id='examine' class='exam' border='1'  cellspacing='0' cellpadding='0'>";
		html +="		<tr>";
		html +="			<td colspan='8'>";
		html +="				<span style='float:left;'>出车时间：</span>";
		html +="				<div class='time_box'><input id='departureTime' type='text' style='margin-top:5px;'/></div>";
		html +="			</td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>用车单位</td><td colspan='3'><input style='width:200px;' name='UseDept'/></td>";
		html +="			<td colspan='1' rowspan='2'>批准首长</td><td colspan='3' rowspan='2'></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>出车单位</td><td colspan='3'><input style='width:200px;' name='VehicleDept'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>用车事由</td><td colspan='3'><input style='width:200px;' name='UseContent'/></td>";
		html +="			<td colspan='1'>承办人</td><td colspan='3'><input style='width:200px;' name='Contractor'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td>车型</td><td><input name='VehicleModel'/></td>";
		html +="			<td>车牌号</td><td><input name='VehicleInfo_Index'/></td>";
		html +="			<td>带车人</td><td><input name='Car_owner'/></td>";
		html +="			<td>驾驶员</td><td><input name='Driver'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>出车时间</td>";
		html +="			<td colspan='3'>";
        html +="                <div class='time_box'><div class='min_time'><input type='number' min='1' max='12' name='out_M'/></div><span>月</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='31' name='out_D'/></div><span>日</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='60' name='out_H'/></div><span>时</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='60' name='out_m'/></div><span>分</span></div>";
		html +="			</td>";
		html +="			<td colspan='1'>返回时间</td>";
		html +="			<td colspan='3'>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='12' name='in_M'/></div><span>月</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='31' name='in_D'/></div><span>日</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='60' name='in_H'/></div><span>时</span></div>";
		html +="				<div class='time_box'><div class='min_time'><input type='number' min='1' max='60' name='in_m'/></div><span>分</span></div>";
		html +="			</td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>行驶线路</td>";
		html +="		    <td colspan='7'>";
		html +="				<div class='time_box'><span style='float:left;padding-left:15px;'>起点：</span><div class='place'><input style='width:250px;' name='start'/></div></div>";
		html +="				<div class='time_box'><span style='float:left;'>目的地：</span><div class='place'><input style='width:250px;' name='dest'/></div></div>";
		html +="			</td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td colspan='1'>备注</td><td colspan='7'><textarea id='Remark'></textarea></td>";
		html +="		</tr>";
		html +="	</table>";
		html +="	<div class='sub_box'>";
		html +="		<input id='reset' type='button' value='重置' style='float:left;width:50px;height:30px;cursor:pointer;'/>";
		html +="		<input id='submit' type='button' value='保存' style='float:left;width:50px;height:30px;cursor:pointer;margin-left:100px;'>";
		html += "             <form name=\'excelform\' id=\'excelform\' method=\'post\' action=\'php/createexcel.php\' target=\'_self\' enctype=\'application/x-www-form-urlencoded\' style=\"display:;\" >";
		html += "                   <input name=\"excelcontent\" id=\"excelcontent\" type=hidden value='' />"
		html += "             </form>";
		html +="        </input>";
		html +="	</div>";
		html +="</div>";
		$("#examine").html(html);
		var w=$(window).width();
		var h=$(window).height();
		if(w<1024){
			w=1024;
		}
		if(h<768){
			h=768;
		}
		$("body").css({
			width:w+"px",
			height:h+"px"
		});
		$("#departureTime").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		$("#reset").off().on('click',function(){
			var obj=$(".exam input");
			$("#Remark").val("");
			obj.each(function(item,value){
				if(value.value=="重置"||value.value=="保存并导出"){
					return;
				}else{
					value.value="";
				}
			});
		});
		$("#submit").off().on('click',function(){
			var flag=true;
			var obj=$(".exam input");
			obj.each(function(item,value){
				if(value.value==""||value.value==undefined){
					if(value.name=="Contractor"){
						return true;
					}
					if(value.name=="VehicleModel"){
						return true;
					}
					alert("表单未填写完整，请填写完整后在进行保存并导出！");
					flag=false;
					return false;
				}
			});
			if(flag){
				var ID=$("input[name='VehicleInfo_Index']")[0].value;
				var VehicleInfo_Index;
				if(Client.storeID[ID]!=""&&Client.storeID[ID]!=undefined){
					VehicleInfo_Index =Client.storeID[ID].index;
					var out_time=$("input[name='out_M']")[0].value+'M'+$("input[name='out_D']")[0].value+'D'+$("input[name='out_H']")[0].value+'H'+$("input[name='out_m']")[0].value+'m';
					var in_time=$("input[name='in_M']")[0].value+'M'+$("input[name='in_D']")[0].value+'D'+$("input[name='in_H']")[0].value+'H'+$("input[name='in_m']")[0].value+'m';
					var Driving_route=$("input[name='start']")[0].value+"|"+$("input[name='dest']")[0].value;
					var req={
						UseDept : $("input[name='UseDept']")[0].value,
						VehicleDept : $("input[name='VehicleDept']")[0].value,
						VehicleModel : $("input[name='VehicleModel']")[0].value,
						VehicleInfo_Index :VehicleInfo_Index,
						UseContent : $("input[name='UseContent']")[0].value,
						Car_owner : $("input[name='Car_owner']")[0].value,
						Driving_route : Driving_route,
						Schedule : 'b#'+out_time+'|e#'+in_time,
						Driver : $("input[name='Driver']")[0].value,
						Time : $("#departureTime").val(),
						Replies : "",
						Contractor : $("input[name='Contractor']")[0].value,
						Remark : $("#Remark").val()
					};
					var res={
						UseDept : $("input[name='UseDept']")[0].value,
						VehicleDept : $("input[name='VehicleDept']")[0].value,
						VehicleModel : $("input[name='VehicleModel']")[0].value,
						VehicleInfo_Index : $("input[name='VehicleInfo_Index']")[0].value,
						UseContent : $("input[name='UseContent']")[0].value,
						Car_owner : $("input[name='Car_owner']")[0].value,
						Driving_route : "&#160;起点：&#160;"+$("input[name='start']")[0].value+"&#160;目的地:&#160;"+$("input[name='dest']")[0].value,
						out_time:$("input[name='out_M']")[0].value+'月'+$("input[name='out_D']")[0].value+'日'+$("input[name='out_H']")[0].value+'时'+$("input[name='out_m']")[0].value+'分',
						in_time : $("input[name='in_M']")[0].value+'月'+$("input[name='in_D']")[0].value+'日'+$("input[name='in_H']")[0].value+'时'+$("input[name='in_m']")[0].value+'分',
						Driver : $("input[name='Driver']")[0].value,
						Time : $("#departureTime").val(),
						Contractor : $("input[name='Contractor']")[0].value,
						Remark : $("#Remark").val()
					};
					Client.AddVehicleApplicationInfo(req,res);
				}else{
					alert("该车辆未被录入！请检查车号");
					return false;
				}
			}else{
				return false;
			}
		});
	},	
	GetBasicInfo:function(){
		var html="";
		html +="<div class='bu_box'>";
		html +="     <input class='control' id='Import' type='button' value='导入' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html += "    <input class='control' id='subm' type='button' value='导出' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'>";
		html += "         <form name=\'excelform\' id=\'excelform\' method=\'post\' action=\'php/createexcel.php\' target=\'_self\' enctype=\'application/x-www-form-urlencoded\' style=\"display:;\" >";
		html += "               <input name=\"excelcontent\" id=\"excelcontent\" type=hidden value='' />"
		html += "          </form>";
		html +="     </input>";
		html +="     <input class='control' id='add' type='button' value='添加' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="	 <input class='control' id='modify' type='button' value='修改' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="	 <input class='control' id='delete' type='button' value='删除' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="     <input id='basic_search' placeholder='搜索' style='border:1px solid #C5C5C7;float:right; margin:10px;border-radius:5px;text-align:left;'/>";
		html +="</div>";
		html +="<div class='basic_box'>";
		html +="<table id='basic' class='basicinfo' border='1'  cellspacing='0' cellpadding='0'>";
		html +="	<tr>";
		html +="		<th>序号</th>";
		html +="		<th>车牌号</th>";
		html +="		<th>车架号</th>";
		html +="		<th>车属单位</th>";
		html +="		<th>车辆管理部门</th>";
		html +="		<th>车辆管理人员</th>";
		html +="		<th>负责单位主官</th>";
		html +="		<th>第一负责人</th>";
		html +="		<th>第二负责人</th>";
		html +="	</tr>";
		html +="    <tbody id='basic_content'></tbody>";
		html +="</table>";
		html +="</div>";
		$("#basicInfo").html(html);
		$("#add").off().on('click',function(){
			Custom.addBasicInfo();
			Custom.showMask();
		});
		$("#subm").off().on("click",function(){
            Client.ExportExcelForVehicleInfo(Client.store_new);
		});
		$('#basic_search').bind('keyup',function(event){       
	         Client.GetVehicleInfo(event.target.value); 
        });
        $("#Import").off().on("click",function(){
        	var html="";
			html +="<div class='Import_Excel'>";
			html +="  <form id='upload' enctype='multipart/form-data' method='post'>";
			html +="    <div style='margin:50px 0px;'>";
			html +="       <input id='Excel-Uploader' name='Excel-Uploader' type='file' style='width:220px;'/>";
			html +="    </div>";
			html +="	<div class='po_box'>";
			html +="		<input id='Import_close' type='button' value='关闭' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:40px;'/>";
			html +="		<input id='Import_sub' type='button' value='提交' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:60px;'/>";
			html +="	</div>";
			html +="  </form>";
			html +="</div>";	
			html +="<div id='mask' class='mask'></div>";
			$("body").append(html);
			Custom.showMask();
			$("#Import_close").off().on('click',function(){
				Custom.hideMask();
				$(".Import_Excel").remove();
			});
			$("#Import_sub").off().on("click",function(){
				var fileParam = {
					request:{
						action:'UploadExcelToDB',
						content:''
					}
				};
				var len=$("#Excel-Uploader").val();
				var fileParams = $.toJSON(fileParam);
				var format=len.split(".")[1];
				if(typeof len!=undefined&&len!=""){
					if(format=="xlsx"||format=="xls"){
						var r=confirm("该操作将清空原有数据，确定要继续操作吗?")
					    if (r==true)
					    {
					        $("#upload").ajaxSubmit({
								url:'php/service/index.php?'+ encodeURIComponent(fileParams),
								dataType:'json', 
								success: function(data) {
									if(data.response.errorCode=="0x0000"){
										$(".Import_Excel").remove();
										Custom.hideMask();
										alert("数据导入成功");
										Client.GetVehicleInfo("");
									}else{
										alert("数据导入失败，请联系管理人员。");
										return false;
									}
								}
						  	});
					    }
					}else{
						alert("上传格式不正确！请选择xlsx或xls的文件");
						return false;
					}
				}else{
					alert("请选择上传文件");
					return false;
				}
			});
        });
	},
	addBasicInfo:function(obj,index,str_index){
		var html="";
		html +="<div class='add_box'>";
		html +="	<div class='title_box'>";
		html +="		车辆管理部门：<input style='width:140px;text-align:left;' name='V_Dept_Manager'/>";
		html +="		车辆管理人员：<input style='width:140px;text-align:left;' name='V_Employee_Manager'/>";
		html +="		入档日期：<input style='width:140px;text-align:left;' name='Register_Time' id='registerTime'/>";
		html +="	</div>";
		html +="	<table border='1'  cellspacing='0' cellpadding='0'>";
		html +="		<tr>";
		html +="			<td >车属单位</td>";
		html +="			<td ><input name='V_Dept'/></td>";
		html +="			<td style='color:red;'>车架号</td>";
		html +="			<td ><input class='must' name='VIN_NO'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td style='color:red;'>车牌号码</td>";
		html +="			<td ><input class='must' name='ID'/></td>";
		html +="			<td style='color:red;'>发动机号</td>";
		html +="			<td ><input class='must' name='ENGINE_SERIAL_NUMBER'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >厂牌型号</td>";
		html +="			<td ><input name='Model'/></td>";
		html +="			<td >配发时间（yyyy-mm-dd）</td>";
		html +="			<td ><input id='issueTime' style='width:150px;' name='Time'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >车辆颜色</td>";
		html +="			<td ><input name='Color'/></td>";
		html +="			<td >燃油种类</td>";
		html +="			<td ><select id='select'>"+Client.select+"</select></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >座位数</td>";
		html +="			<td ><input type='number' name='Seating' style='margin-left:15px;'/></td>";
		html +="			<td >初始里程（km）</td>";
		html +="			<td ><input name='Mileage' type='number' style='margin-left:15px;'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >标准油耗（百公里）</td>";
		html +="			<td ><input name='Oil_Wear'/></td>";
		html +="			<td >油箱容量（L）</td>";
		html +="			<td ><input name='TankSize'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >总质量（Kg）</td>";
		html +="			<td ><input name='Total_mass'/></td>";
		html +="			<td >最大载重（Kg）</td>";
		html +="			<td ><input name='Maximum_Load'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >外廓尺寸（mm）</td>";
		html +="			<td >";
		html +="				<div class='time_b'>&nbsp;&nbsp;&nbsp;长<input type='number' style='font-size:12px;' name='L'/></div></div>";
		html +="				<div class='time_b'>宽<input type='number' style='font-size:12px;' name='W'/></div></div>";
		html +="				<div class='time_b'>高<input type='number' style='font-size:12px;' name='H'/></div></div>";
		html +="			</td>";
		html +="			<td >负责单位主官</td>";
		html +="			<td ><input name='Responsible_Officer'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >第一负责人</td>";
		html +="			<td ><input name='FirstLeading_Person'/></td>";
		html +="			<td >第二负责人</td>";
		html +="			<td ><input name='SecondLeading_Person'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td style='height:50px;'>备注</td><td style='height:50px;' colspan='3' rowspan='3'><textarea class='textara' id='remark'></textarea></td>";
		html +="		</tr>";
		html +="	</table>";
		html +="	<div class='po_box'>";
		html +="		<input id='close' type='button' value='关闭' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:250px;'/>";
		html +="		<input id='sub' type='button' value='提交' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:160px;'/>";
		html +="	</div>";
		html +="</div>";
		html +="<div id='mask' class='mask'></div>";
		$("body").append(html);
		$("#registerTime").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		$("#issueTime").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		if(obj!=undefined){
			$("input[name='ID']").attr('readonly',true);
			$("input[name='VIN_NO']").attr('readonly',true);
			$("input[name='ENGINE_SERIAL_NUMBER']").attr('readonly',true);
			$("input[name='ID']").val(obj.ID);
			$("input[name='VIN_NO']").val(obj.VIN_NO);
			$("input[name='ENGINE_SERIAL_NUMBER']").val(obj.ENGINE_SERIAL_NUMBER);
			$("input[name='Model']").val(obj.Model);
			$("#select").find("option:contains('"+obj.Fuel_Index+"')").attr("selected",true);
			$("input[name='Color']").val(obj.Color);
			$("input[name='Seating']").val(obj.Seating);
			$("input[name='Time']").val(obj.Time==undefined?"":obj.Time.substr(0,10));
			$("input[name='Mileage']").val(obj.Mileage);
			$("input[name='Oil_Wear']").val(obj.Oil_Wear);
			$("input[name='TankSize']").val(obj.TankSize);
			$("input[name='Maximum_Load']").val(obj.Maximum_Load);
			var ob=obj.Overall_Dimension.split("*");
			$("input[name='L']").val(ob[0]);
			$("input[name='W']").val(ob[1]);
			$("input[name='H']").val(ob[2]);
			$("input[name='Total_mass']").val(obj.Total_mass);
			$("input[name='Overall_Dimension']").val(obj.Overall_Dimension);
			$("input[name='V_Dept']").val(obj.V_Dept);
			$("input[name='V_Dept_Manager']").val(obj.V_Dept_Manager);
			$("input[name='V_Employee_Manager']").val(obj.V_Employee_Manager);
			$("input[name='Register_Time']").val(obj.Register_Time);
			$("input[name='Responsible_Officer']").val(obj.Responsible_Officer);
			$("input[name='FirstLeading_Person']").val(obj.FirstLeading_Person);
			$("input[name='SecondLeading_Person']").val(obj.SecondLeading_Person);
			$("#remark").val(obj.remark);
		}
		if(index==undefined&&obj!=undefined){
			$('.add_box input').attr('disabled',true);
			$('.add_box select').attr('disabled',true);
			$('.add_box textarea').attr('disabled',true);
			$("#close").attr("disabled",false);
			$("#sub").css("display","none");
			$("#close").css({
				"margin":"10px 0px"
			});
		}
		$("#close").off().on('click',function(){
			Custom.hideMask();
			$(".add_box").remove();
		});
		var VIN_NO_FLAG=false;
		var ENGINE_SERIAL_NUMBER_FLAG=false;
		var ID_FLAG=false;
		$("#sub").off().on('click',function(){
			var flag=true;
			var ob=$(".must");
			ob.each(function(item,value){
				if(value.value==""||value.value==undefined){
					alert("请填写必填选项！");
					flag=false;
					return false;
				}
			});
			var time=$("input[name='Time']")[0].value;
			if(checkDate(time)){
				var Overall_Dimension=$("input[name='L']")[0].value+"*"+$("input[name='W']")[0].value+"*"+$("input[name='H']")[0].value;
				var req={
					ID: $("input[name='ID']")[0].value,
					VIN_NO: $("input[name='VIN_NO']")[0].value,
					ENGINE_SERIAL_NUMBER: $("input[name='ENGINE_SERIAL_NUMBER']")[0].value,
					Model: $("input[name='Model']")[0].value,
					Fuel_Index: $("#select").val(),
					Color: $("input[name='Color']")[0].value,
					Seating: $("input[name='Seating']")[0].value || 0,
					Time: time,
					Mileage: $("input[name='Mileage']")[0].value || 0,
					Oil_Wear: $("input[name='Oil_Wear']")[0].value,
					TankSize: $("input[name='TankSize']")[0].value,
					Maximum_Load: $("input[name='Maximum_Load']")[0].value,
					Total_mass: $("input[name='Total_mass']")[0].value,
					Overall_Dimension: Overall_Dimension,
					V_Dept: $("input[name='V_Dept']")[0].value,
					V_Dept_Manager: $("input[name='V_Dept_Manager']")[0].value,
					V_Employee_Manager: $("input[name='V_Employee_Manager']")[0].value,
					Register_Time: $("input[name='Register_Time']")[0].value,
					Responsible_Officer: $("input[name='Responsible_Officer']")[0].value,
					FirstLeading_Person: $("input[name='FirstLeading_Person']")[0].value,
					SecondLeading_Person:$("input[name='SecondLeading_Person']")[0].value,
					remark:$("#remark").val()
				};
				if(flag){
					if(obj==undefined){
						Ajax.SendAjax("CheckVehicleUniqueColumn",{ID:req.ID},function(rv){
							if(rv.response.content>0){
								alert("该车辆已被录入！请检查车辆号码!");
								return false;
							}else{
								Ajax.SendAjax("CheckVehicleUniqueColumn",{VIN_NO:req.VIN_NO},function(rv){
									if(rv.response.content>0){
										alert("该车辆已被录入！请检查车架号码!");
										return false;
									}else{
										if(VIN_NO_FLAG&&ENGINE_SERIAL_NUMBER_FLAG&&ID_FLAG){
						                    Client.AddVehicleInfo(req);
										}else{
											alert("添加失败，请检查车牌号、车架号和发动机号");
											return false;
										}
									}
								});
							}
						});
					}else{
						Client.ModifyVehicleInfo(req,index);
					}
				}
			}
		});
		$("input[name='ID']").off().on("blur",function(e){
			$("input[name='ID']").val(e.target.value.toUpperCase());
			var value=e.target.value;
			if(value==undefined||value==""){
				return false;
			}
			var pat=new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]"); 
			if(pat.test(value)==true) 
			{ 
				alert('车牌号包含非法字符!请重新书写');
			    ID_FLAG=false;
			    return false;
			}else{
				ID_FLAG=true;
				return false;
			}
		});
		$("input[name='VIN_NO']").off().on("blur",function(e){
			$("input[name='VIN_NO']").val(e.target.value.toUpperCase());
			var value=e.target.value;
			if(value==undefined||value==""){
				return false;
			}
			var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
			var pat=new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]"); 
			if(pat.test(value)==true) 
			{ 
				alert('车架号包含非法字符!请重新书写');
			    VIN_NO_FLAG=false;
			    return false;
			}else if(reg.test(value)){
				VIN_NO_FLAG=false;
				alert("车架号包含中文！请重新书写");
				return false;
			}else if(value.length>17){
				VIN_NO_FLAG=false;
				alert("车架号位应小于十七位！请重新书写");
				return false;
			}else{
				VIN_NO_FLAG=true;
				return false;
			}
		});
		$("input[name='ENGINE_SERIAL_NUMBER']").off().on("blur",function(e){
			$("input[name='ENGINE_SERIAL_NUMBER']").val(e.target.value.toUpperCase());
			var value=e.target.value;
			if(value==undefined||value==""){
				return false;
			}
			var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
			var pat=new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]"); 
			if(pat.test(value)==true) 
			{ 
				alert('发动机号包含非法字符!请重新书写');
			    ENGINE_SERIAL_NUMBER_FLAG=false;
			    return false;
			}else if(reg.test(value)){
				VIN_NO_FLAG=false;
				alert("发动机号包含中文！请重新书写");
				return false;
			}else if(value.length>8){
				ENGINE_SERIAL_NUMBER_FLAG=false;
				alert("发动机号应小于八位！请重新书写");
				return false;
			}else{
				ENGINE_SERIAL_NUMBER_FLAG=true;
				return false;
			}
		});
		var date = new Date();
	    var Y = date.getFullYear() + '-';
	    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
	    var D = (date.getDate()<10 ? '0'+date.getDate():date.getDate());
	    $("#registerTime").val(Y+M+D);
	    $("#issueTime").val(Y+M+D);
	},
	
	GetRegister:function(){
		var html="";
		html +="<div class='regi_box'>";
		html += "    <input class='control' id='reg_button' class='reg_button' type='button' value='导出' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 20px;'>";
		html += "         <form name=\'excelform\' id=\'excelform\' method=\'post\' action=\'php/createexcel.php\' target=\'_self\' enctype=\'application/x-www-form-urlencoded\' style=\"display:;\" >";
		html += "               <input name=\"excelcontent\" id=\"excelcontent\" type=hidden value='' />"
		html += "          </form>";
		html +="     </input>";
		html +="     <input class='control' id='add_register' type='button' value='添加' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="     <input class='control' id='add_modify' type='button' value='修改' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="     <input class='control' id='add_delete' type='button' value='删除' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="     <input id='reg_search' placeholder='搜索' style='border:1px solid #C5C5C7;float:right; margin:10px;border-radius:5px;text-align:left;'/>";
		html +="</div>";
		html +="<div class='register_box'>";
		html +="<table id='registered' class='register' border='1'  cellspacing='0' cellpadding='0'>";
		html +="	<tr>";
		html +="		<th style='width:50px;'>序号</th>";
		html +="		<th style='width:100px;'>车辆牌号</th>";
		html +="		<th style='width:100px;'>车架号</th>";
		html +="		<th style='width:100px;'>日期</th>";
		html +="		<th style='width:150px;'>维修原因</th>";
		html +="		<th style='width:200px;'>保养维护内容</th>";
		html +="		<th style='width:120px;'>预计下次保养日期</th>";
		html +="		<th style='width:100px;'>修理工</th>";
		html +="		<th style='width:100px;'>驾驶员</th>";
		html +="		<th style='width:100px;'>费用</th>";
		html +="	</tr>";
		html +="    <tbody id='register_content'></tbody>";
		html +="</table>";
		html +="</div>";
		$("#register").html(html);
		Client.GetVehicleMainTainInfo("");
		$("#add_register").off().on('click',function(){
			Custom.addRegisterInfo();
			Custom.showMask();
		});
		$('#reg_search').bind('keyup',function(event){       
	         Client.GetVehicleMainTainInfo(event.target.value); 
       });
        $("#add_modify").off().on("click",function(){
        	if(Client.register_index==null){
        		alert("请选择一条数据");
        		return false;
        	}else{
        		Custom.showMask();
        		Custom.addRegisterInfo(Client.register[Client.register_index]);
        	}
        });
        $("#add_delete").off().on("click",function(){
        	if(Client.register_index==null){
        		alert("请选择一条数据");
        		return false;
        	}else{
        		var r=confirm("确定要删除这条数据吗?")
			    if (r==true)
			    {
			    	Client.DeleteVehicleMainTainInfo(Client.register_index);
			    }
        	}
        });
		$("#reg_button").off().on("click",function(){
			Excel.CreateManagerRegisterToExcel(getTime(),Client.register_excel)
		});
	},
	//车辆保养登记
	addRegisterInfo:function(reg){
		var html="";
		html +="<div class='add_registered'>";
		html +="	<div class='title_box'>";
		html +="         <div class='registed_box'><span>姓名：</span><input style='width:250px;' name='Registrant' type='text'/></div>";
		html +="	</div>";
		html +="	<table class='register_form' border='1'  cellspacing='0' cellpadding='0'>";
		html +="		<tr>";
		html +="			<td >车辆牌号</td>";
		html +="			<td ><input id='ID_Register' name='ID'/></td>";
		html +="			<td >车架号</td>";
		html +="			<td ><span id='VIN_NO_Register'></span></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >日期（yyyy-mm-dd）</td>";
		html +="			<td ><input id='keepDate' name='Date'/></td>";
		html +="			<td >维修原因</td>";
		html +="			<td ><input name='MainTain_Reason'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >预计下次保养日期（yyyy-mm-dd）</td>";
		html +="			<td ><input id='nextKeepDate' name='Next_MainTain_Date'/></td>";
		html +="			<td >修理工</td>";
		html +="			<td ><input name='Repairman'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >驾驶员</td>";
		html +="			<td ><input name='driver'/></td>";
		html +="			<td >费用</td>";
		html +="			<td ><input name='Cost'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td style='height:50px;'>保养维护内容</td><td style='height:50px;' colspan='3' rowspan='3'><textarea id='MainTain_Content' class='textara'></textarea></td>";
		html +="		</tr>";
		html +="	</table>";
		html +="	<div class='po_box'>";
		html +="		<input id='reg_close' type='button' value='关闭' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:280px;'/>";
		html +="		<input id='reg_sub' type='button' value='提交' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:60px;'/>";
		html +="	</div>";
		html +="</div>";	
		html +="<div id='mask' class='mask'></div>";
		$("body").append(html);
		$("#keepDate").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		$("#nextKeepDate").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		if(reg){
			$("input[name='ID']").attr("readonly","readonly");
			$("input[name='Registrant']").val(reg.Registrant);
			$("input[name='ID']").val(reg.ID);
			$("#VIN_NO_Register").html(reg.VIN_NO);
			$("input[name='Date']").val(reg.Date);
			$("input[name='Next_MainTain_Date']").val(reg.Next_MainTain_Date);
			$("input[name='MainTain_Reason']").val(reg.MainTain_Reason);
			$("input[name='Repairman']").val(reg.Repairman);
			$("input[name='driver']").val(reg.Driver);
			$("input[name='Cost']").val(reg.Cost);
			$("#MainTain_Content").val(reg.MainTain_Content);
		}else{
			$("input[name='ID']").removeAttr("readonly");
		}
		$("#reg_close").off().on('click',function(){
			Custom.hideMask();
			$(".add_registered").remove();
		});
		$("#ID_Register").off().on("blur",function(){
			var ID=$(this).val();
			if(Client.storeID[ID]==""||Client.storeID[ID]==undefined){
				alert("该车辆未被录入!");
	    		return false;
		    }else{
		    		var VIN_NO=Client.storeID[ID].VIN_NO;
			        $("#VIN_NO_Register").html(VIN_NO);
			        Client.GetNextMainTainDateTime(Client.storeID[ID].index);
		    	}
			});
		var arr=new Array();
		$("#reg_sub").off().on("click",function(){
			var MainTain_Content= $("#MainTain_Content").val();
			var flag=true;
			var obj=$(".add_registered input");
			obj.each(function(item,val){
				if(val.value==""||val.value==undefined){
					alert("表单未填写完整");
					flag=false;
					return false;
				}
			});
			if(MainTain_Content==""||MainTain_Content==undefined){
				alert("表单未填写完整");
				flag=false;
				return false;
			}
			if(flag){
				var Registrant=$("input[name='Registrant']")[0].value
				var ID=$("input[name='ID']")[0].value;
				var Date=$("input[name='Date']")[0].value;
				var Next_MainTain_Date=$("input[name='Next_MainTain_Date']")[0].value;
				if(checkDate(Date)&&checkDate(Next_MainTain_Date)){
					arr.push({
						VehicleInfo_Index : Client.storeID[ID].index,
						Date : Date,
						MainTain_Reason : $("input[name='MainTain_Reason']")[0].value,
						MainTain_Content : MainTain_Content,
						Next_MainTain_Date : Next_MainTain_Date,
						Repairman : $("input[name='Repairman']")[0].value,
						Driver : $("input[name='driver']")[0].value,
						Cost : $("input[name='Cost']")[0].value
					});
					if(reg){
						var obj={
							MainTainInfo_Index : reg.index,
							Registrant:$("input[name='Registrant']")[0].value,
							Date : Date,
							MainTain_Reason : $("input[name='MainTain_Reason']")[0].value,
							MainTain_Content : MainTain_Content,
							Next_MainTain_Date : Next_MainTain_Date,
							Repairman : $("input[name='Repairman']")[0].value,
							Driver : $("input[name='driver']")[0].value,
							Cost : $("input[name='Cost']")[0].value
						};
						Client.ModifyVehicleMainTainInfo(obj);
					}else{
						Client.AddVehicleMainTainInfo(Registrant,arr);
					}
				}
			}
		});
	},
	GetOilCount:function(){
		var html="";
		html +="<div class='reg_box'>";
		html += "    <input class='control' id='regist_button' class='regist_button' type='button' value='导出' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 20px;'>";
		html += "         <form name=\'excelform\' id=\'excelform\' method=\'post\' action=\'php/createexcel.php\' target=\'_self\' enctype=\'application/x-www-form-urlencoded\' style=\"display:;\" >";
		html += "               <input name=\"excelcontent\" id=\"excelcontent\" type=hidden value='' />"
		html += "          </form>";
		html +="     </input>";
		html +="    <input class='control' id='add_OilCount' type='button' value='添加' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="    <input class='control' id='oil_modify' type='button' value='修改' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="    <input class='control' id='oil_delete' type='button' value='删除' style='float:right;width:40px;height:25px;cursor:pointer;margin:10px 10px;'/>";
		html +="    <input id='oil_search' placeholder='搜索' style='border:1px solid #C5C5C7;float:right; margin:10px;border-radius:5px;text-align:left;'/>";
		html +="</div>";
		html +="<div class='oilCount_box'>";
		html +="<table id='oilCount' class='OilCount' border='1'  cellspacing='0' cellpadding='0'>";
		html +="	<tr>";
		html +="		<th style='width:50px;'>序号</th>";
		html +="		<th>车牌号</th>";
		html +="		<th>车架号</th>";
		html +="		<th>加油日期</th>";
		html +="		<th>初期加油里程数</th>";
		html +="		<th>本次里程</th>";
		html +="		<th>加油数量（升）</th>";
		html +="		<th>油耗统计</th>";
		html +="		<th>加油员</th>";
		html +="		<th>驾驶员</th>";
		html +="	</tr>";
		html +="    <tbody id='oil_content'></tbody>";
		html +="</table>";
		html +="</div>";
		$("#count").html(html);
		Client.GetOilConsumptionInfo("");
		$("#add_OilCount").off().on('click',function(){
			Custom.addOilCountInfo();
			Custom.showMask();
		});
		$('#oil_search').bind('keyup',function(event){       
	         Client.GetOilConsumptionInfo(event.target.value); 
        });
        $("#oil_modify").off().on("click",function(){
        	if(Client.oil_index==null){
        		alert("请选择一条数据");
        		return false;
        	}else{
        		Custom.showMask();
        		Custom.addOilCountInfo(Client.oilCount[Client.oil_index]);
        	}
        });
        $("#oil_delete").off().on("click",function(){
        	if(Client.oil_index==null){
        		alert("请选择一条数据");
        		return false;
        	}else{
        		Custom.showMask();
        		var r=confirm("确定要删除这条数据吗?")
			    if (r==true)
			    {
			    	Client.DeleteOilConsumptionInfo(Client.oil_index);
			    }
        	}
        });
		$("#regist_button").off().on("click",function(){
			Excel.CreateManagerCountToExcel(getTime(),Client.oilCount_excel)
		});
	},
	addOilCountInfo:function(reg){
		var html="";
		html +="<div class='add_OilCount'>";
		html +="	<div class='title_box'>";
		html +="         <div class='registed_box'><span>姓名：</span><input name='regist' style='width:250px;' type='text'/></div>";
		html +="	</div>";
		html +="	<table class='OilCount_form' border='1'  cellspacing='0' cellpadding='0'>";
		html +="		<tr>";
		html +="			<td >车辆牌号</td>";
		html +="			<td ><input id='ID_OilCount' name='Oil_ID'/></td>";
		html +="			<td >车架号</td>";
		html +="			<td ><span id='VIN_NO_OilCount'></span></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >加油日期（yyyy-mm-dd）</td>";
		html +="			<td ><input id='addOilDate' name='Oil_Date'/></td>";
		html +="			<td >初期加油里程数（km）</td>";
		html +="			<td ><input id='firstRefuelMileage' name='First_Refueling_Mileage'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >本次里程（km）</td>";
		html +="			<td ><input name='Total_Mileage' disabled=true value='0'/></td>";
		html +="			<td >加油数量（升）</td>";
		html +="			<td ><input name='Oil_Number'/></td>";
		html +="		</tr>";
		html +="		<tr>";
		html +="			<td >加油员</td>";
		html +="			<td ><input name='Oil_Person'/></td>";
		html +="			<td >驾驶员</td>";
		html +="			<td ><input name='Oil_Driver'/></td>";
		html +="		</tr>";
		html +="	</table>";
		html +="	<div class='po_box'>";
		html +="		<input id='oil_close' type='button' value='关闭' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:280px;'/>";
		html +="		<input id='oil_sub' type='button' value='提交' style='float:left;border:1px solid black;width:80px;height:30px;cursor:pointer;margin-left:60px;'/>";
		html +="	</div>";
		html +="</div>";	
		html +="<div id='mask' class='mask'></div>";
		$("body").append(html);
		$("#addOilDate").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd'})
		});
		if(reg){
			$("input[name='Oil_ID']").attr("readonly","readonly");
			$("input[name='regist']").val(reg.Registrant);
			$("input[name='Oil_ID']").val(reg.ID);
			$("#VIN_NO_OilCount").html(reg.VIN_NO);
			$("input[name='Oil_Date']").val(reg.Date);
			$("input[name='First_Refueling_Mileage']").val(reg.First_Refueling_Mileage);
			$("input[name='Total_Mileage']").val(reg.Total_Mileage);
			$("input[name='Oil_Number']").val(reg.Oil_Number);
			$("input[name='Oil_Person']").val(reg.Oil_Person);
			$("input[name='Oil_Driver']").val(reg.Driver);
		}else{
			$("input[name='Oil_ID']").removeAttr("readonly");
		}
		$("#oil_close").off().on('click',function(){
			Custom.hideMask();
			$(".add_OilCount").remove();
		});
		$("#ID_OilCount").off().on("blur",function(){
			var ID=$(this).val();
			if(Client.storeID[ID]==""||Client.storeID[ID]==undefined){
				alert("该车辆未被录入!");
	    		return false;
		    }else{
	    		var VIN_NO=Client.storeID[ID].VIN_NO;
		        $("#VIN_NO_OilCount").html(VIN_NO);
		        Client.GetTotalMileage(Client.storeID[ID].index)
		    }
		});
		var arr=new Array();
		$("#oil_sub").off().on("click",function(){
			var flag=true;
			var obj=$(".add_OilCount input");
			obj.each(function(item,val){
				if(val.value==""||val.value==undefined){
					alert("表单未填写完整");
					flag=false;
					return false;
				}
			});
			if(flag){
				var Registrant=$("input[name='regist']")[0].value;
				var ID=$("input[name='Oil_ID']")[0].value;
				var Date=$("input[name='Oil_Date']")[0].value;
				if(checkDate(Date)){
					arr.push({
						VehicleInfo_Index : Client.storeID[ID].index,
						Date : Date,
						First_Refueling_Mileage:$("input[name='First_Refueling_Mileage']")[0].value,
						Total_Mileage : $("input[name='Total_Mileage']")[0].value,
						Oil_Number : $("input[name='Oil_Number']")[0].value,
						Oil_Person : $("input[name='Oil_Person']")[0].value,
						Driver :$("input[name='Oil_Driver']")[0].value
					});
					if(reg){
						var obj={
							OilConsumptionInfo_Index : reg.index,
							Date : Date,
							First_Refueling_Mileage:$("input[name='First_Refueling_Mileage']")[0].value,
							Total_Mileage : $("input[name='Total_Mileage']")[0].value,
							Oil_Number : $("input[name='Oil_Number']")[0].value,
							Oil_Person : $("input[name='Oil_Person']")[0].value,
							Driver :$("input[name='Oil_Driver']")[0].value
						};
						Client.ModifyOilConsumptionInfo(obj);
					}else{
						Client.AddOilConsumptionInfo(Registrant,arr);
					}
				}
			}
		});
	},
	GetApply:function(){
		var html="";
		html +="<div class='applyInfo_box'>";
		html +="<table id='applyInfo' class='applyInfo' style='width:100%;' border='1'  cellspacing='0' cellpadding='0'>";
		html +="	<tr>";
		html +="		<th style='height:30px;width:50px;'>序号</th>";
		html +="		<th>车号</th>";
		html +="		<th>用车单位</th>";
		html +="		<th>出车单位</th>";
		html +="		<th style='width:300px;'>用车事由</th>";
		html +="		<th>承办人</th>";
		html +="		<th>带车人</th>";
		html +="		<th>驾驶员</th>";
		html +="		<th>出车时间</th>";
		html +="		<th>操作</th>";
		html +="	</tr>";
		for(var i=0;i<Client.apply.length;i++){
			html +="	<tr class='apply_box' attribute='"+JSON.stringify(Client.apply[i])+"'>";
			html +="		<td>"+(i+1)+"</td>";
			html +="		<td>"+Client.apply[i].VehicleID+"</td>";
			html +="		<td>"+Client.apply[i].UseDept+"</td>";
			html +="		<td>"+Client.apply[i].VehicleDept+"</td>";
			html +="		<td>"+Client.apply[i].UseContent+"</td>";
			html +="		<td>"+Client.apply[i].Contractor+"</td>";
			html +="		<td>"+Client.apply[i].Car_owner+"</td>";
			html +="		<td>"+Client.apply[i].Driver+"</td>";
			html +="		<td>"+Client.apply[i].Time+"</td>";
			html +="		<td style='width:60px;'>";
			html += "          <input class='apply_sub' type='button' value='导出' style='width:50px;height:25px;cursor:pointer;margin:5px 5px;'>";
			html += "             <form name=\'excelform\' id=\'excelform\' method=\'post\' action=\'php/createexcel.php\' target=\'_self\' enctype=\'application/x-www-form-urlencoded\' style=\"display:;\" >";
			html += "                 <input name=\"excelcontent\" id=\"excelcontent\" type=hidden value='' />"
			html += "             </form>";
			html +="           </input>";
			html +="        </td>";
			html +="	</tr>";
		}
		html +="</table>";
		html +="</div>";
		$("#apply").html(html);
		$(".apply_sub").off().on("click",function(){
			var res=$(this).parent().parent().attr("attribute");
			Excel.CreateManagerExamineToExcel(getTime(),$.parseJSON(res));
		});
	},
	GetQueryApply:function(){
		var html="";
		html +="<div class='already_apply'>";
		html +="   <div class='apply_add' style='float:left;'>";
		html +="        <div class='table_apply_box'>";
		html +="        <table class='table_apply' border='1'  cellspacing='0' cellpadding='0'>";
		html +="          <thead>";
		html +="	         <tr>";
		html +="               <th style='width:30px;'><input style='width:30px;' type='checkbox'/></th>";
		html +="		       <th style='width:80px;'>车牌号</th>";
		html +="		       <th style='width:80px;'>车属单位</th>";
		html +="		       <th style='width:100px;'>车辆管理部门</th>";
		html +="		       <th style='width:100px;'>用车人</th>";
		html +="	         </tr>";
		html +="          </thead>";
		html +="          <tbody class='apply_content'>";
		html +="          <tbody>";
		html +="        </table>";
		html +="        </div>";
		html +="        <div class='apply_control'>";
		html +="            <span for='leave_Time'>时间:</span>";
		html +="            <input id='leave_Time' style='width:130px;border:1px solid grey;'/> - ";
		html +="            <input id='return_Time' style='width:130px;border:1px solid grey;'/>";
		html +="            <input id='apply_button' type='button' style='cursor:pointer;margin-left:30px;' value='审批'/>"
		html +="        </div>";
		html +="   </div>";
		html +="   <div class='apply_search' style='float:left;'>";
		html +="        <div style='float:left;width:100%;text-align:left;padding:10px 0px;'>";
		html +="            <span for='search_Time'>时间:</span>";
		html +="            <input id='search_Time' style='border:1px solid grey;'/>";
		html +="            <input style='float:right;cursor:pointer;margin-right:10px;' id='apply_delete' type='button' value='删除'/>";
		html +="        </div>";
		html +="        <div class='apply_query_box'>";
		html +="        <table border='1'  cellspacing='0' cellpadding='0' >";
		html +="          <thead>";
		html +="	         <tr>";
		html +="		       <th style='width:119px;'>车牌号码</th>";
		html +="		       <th style='width:118px;'>车属单位</th>";
		html +="		       <th style='width:119px;'>管理单位</th>";
		html +="		       <th style='width:119px;'>用车人</th>";
		html +="		       <th style='width:199px;'>时间</th>";
		html +="	         </tr>";
		html +="          </thead>";
		html +="          <tbody class='apply_query' border='1'>";
		html +="          </tbody>";
		html +="        </table>";
		html +="        </div>";
		html +="   </div>";
		html +="</div>";
		$("#query_apply").html(html);
		Custom.Query_Apply_CSS();
		var date = new Date();
	    var Y = date.getFullYear() + '-';
	    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
	    var D = (date.getDate()<10 ? '0'+date.getDate():date.getDate());
	    $("#search_Time").val(Y+M+D);
	    Client.GetVehicleApprovalInfo($("#search_Time").val());
		$("thead input[type=checkbox]").change(function() {
		   if(this.checked){
		   	  $("tbody input[type=checkbox]").prop("checked",true);
		   }else{
		   	  $("tbody input[type=checkbox]").prop("checked",false);
		   }
		});
		$("#apply_button").off().on("click",function(){
			var dataList=new Array();
			var leave_Time=$("#leave_Time").val();
			var return_Time=$("#return_Time").val();
			if(leave_Time==""||return_Time==""){
				alert("请选择时间！");
				return false;
			}
			var leave_Stamp=new Date(leave_Time).getTime();
			var return_Stamp=new Date(return_Time).getTime();
			leave_Stamp=parseInt(leave_Stamp);
			return_Stamp=parseInt(return_Stamp);
			if(return_Stamp<leave_Stamp){
				alert("结束时间要大于起始时间！");
				return false;
			}
			var obj=$("tbody input[type=checkbox]:checked");
			obj.each(function(index,item){
				var items=$(item).parent().parent().children();
				var drivers=$(items[4]).children().val();
				var VehicleInfo_Index=$(item).parent().parent().attr("attribute");
				dataList.push({
					VehicleInfo_Index:VehicleInfo_Index,
					Person:drivers,
					BeginTime:leave_Time,
					EndTime:return_Time
				});
			});
			var time=Y+M+D;
			if(dataList.length==0){
				alert("请选择勾选车辆信息。");
				return false;
			}else{
				Client.AddVehicleApprovalInfo(time,dataList);
			}
		});
	},
	Query_Apply_CSS:function(){
		$("#leave_Time").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})
		});
		$("#return_Time").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})
		});
		$("#search_Time").off().on("click",function(){
			WdatePicker({dateFmt:'yyyy-MM-dd',onpicked:function(){
				Client.GetVehicleApprovalInfo($(this).val());
			}})
		});
	},
	Css_Control:function(){
		var w=$(window).width();
		var h=$(window).height();
		if(w<1024){
			w=1024;
		}
		if(h<768){
			h=768;
		}
		$("body").css({
			width:w+"px",
			height:h+"px"
		});
		$("#title").css({
			width:w+"px",
			height:"30px"
		});
		$(".basicInfo").css({
			height:h+"px"
		});
		$(".basic_box").css({
			width:w+"px",
			height:(h-95)+"px",
			"overflow-y":"auto",
			"overflow-x":"hidden"
		});
		$(".regi_box").css({
			width:w+"px",
			height:"30px"
		});
		$(".register_box").css({
			width:w+"px",
			height:(h-95)+"px",
			"overflow-y":"auto",
			"overflow-x":"hidden"
		});
		$(".reg_box").css({
			width:w+"px",
			height:"30px",
		});
		$(".oilCount_box").css({
			width:w+"px",
			height:(h-100)+"px",
			"overflow-y":"auto",
			"overflow-x":"hidden"
		});
		$(".applyInfo_box").css({
			width:(w-10)+"px",
			height:(h-50)+"px",
			"overflow-y":"auto",
			"overflow-x":"hidden",
			"padding-right":"10px"
		});
		$(".table_apply_box").css({
			width:"800px",
			height:(h-150)+"px",
			"margin-top":"45px",
			"margin-bottom":"10px",
			"overflow-y":"auto",
			"overflow-x":"hidden"
		});
		$(".apply_search").css({
			width:(w-820)+"px",
			height:(h-90)+"px",
			"margin-left":"20px"
		});
		$(".apply_query_box").css({
			width:(w-830)+"px",
			height:(h-120)+"px",
			"overflow-y":"auto",
			"overflow-x":"hidden"
		});
		$(".apply_control").css({
			width:"800px",
			height:"30px"
		});
	},
	Css_Resize:function(){
		$(window).resize(function(){
			Custom.Css_Control();
		});
		Custom.Css_Control();
	},
	showMask:function(){     
       $("#mask").height(document.body.scrollHeight);
	   $("#mask").width(document.body.scrollWidth);
	   $("#mask").fadeTo(200, 0.5);
	   $(window).resize(function(){
	      $("#mask").height(document.body.scrollHeight);
	      $("#mask").width(document.body.scrollWidth);
	   });
    }, 
    hideMask:function(){             
        $("#mask").fadeOut(200);    
    },
	end:true
}
function getTime() {
    var date = new Date();
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var D = date.getDate() + ' ';
    var h = date.getHours() + ':';
    var m = date.getMinutes() + ':';
    var s = date.getSeconds();
    return Y+M+D+h+m+s;
}
function checkDate(time){ 
	var reg=/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/; 
	if(!time.match(reg)){
		alert("日期填写格式不正确，请按“1970-00-00方式书写”");
		return false; 
	}else{ 
	    return true;
	}
}