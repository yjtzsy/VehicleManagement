<?php
	
	$doc = new DOMDocument();
	$doc->loadXML(stripslashes($_POST["excelcontent"]));
	
	$root = $doc->getElementsByTagName("Root");
	$rootattributes = $root->item(0);
	$WorksheetName = "工作薄";
	$WorksheetTitle = "工作薄标题";
	$ExpandedColumnCount = 30;
	$DefaultColumnWidth = 100;
	foreach($rootattributes->attributes as $a)
	{
		if($a->nodeName=="WorksheetName")
		{
			$WorksheetName = $a->nodeValue;
		}
		else if($a->nodeName=="WorksheetTitle")
		{
			$WorksheetTitle = $a->nodeValue;
		}
		else if($a->nodeName=="ExpandedColumnCount")
		{
			$ExpandedColumnCount = $a->nodeValue;
		}
		else if($a->nodeName=="DefaultColumnWidth")
		{
			$DefaultColumnWidth = $a->nodeValue;
		}
	}
	header("Content-Type: application/vnd.ms-excel;");
	header("Content-Disposition: inline; filename=".iconv("utf-8","gb2312","$WorksheetTitle").".xls");	
	echo stripslashes("<?xml version=\"1.0\" encoding=\"utf-8\"?><Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">"); 
	echo "<Styles>";
	echo "<Style ss:ID=\"Default\" ss:Name=\"Normal\"><Alignment ss:Vertical=\"Center\"/><Borders/><Font ss:FontName=\"宋体\" x:CharSet=\"134\" ss:Size=\"12\"/>   <Interior/><NumberFormat/><Protection/></Style>";
	
	// 分解样式单	
	$stylesheet = $doc->getElementsByTagName("StyleSheet")->item(0);	
	echo parsexml($stylesheet);
	echo "</Styles>";

	echo "\n<Worksheet  ss:Name=\"".$WorksheetName."\">\n<Table ss:DefaultColumnWidth=\"".$DefaultColumnWidth."\" ss:DefaultRowHeight=\"20\" ss:ExpandedColumnCount=\"".$ExpandedColumnCount."\">\n";
	$columns = $doc->getElementsByTagName("Columns")->item(0);	
	echo parsexml($columns);
	
	// 建立文档标题行
	$titles = $doc->getElementsByTagName("Title")->item(0);	
	echo parsexml($titles);

	$contents = $doc->getElementsByTagName("Contents")->item(0);
	
	echo parsexml($contents);
	
	echo "</Table>\n</Worksheet>\n</Workbook>\n";


function parsexml($t_node)
{
	$xmlstr = "";
	foreach($t_node->childNodes as $childnode)
	{	
		if(count($childnode->childNodes) > 0)
		{
			$xmlstr .= "\n<".$childnode->nodeName." ".getattributes($childnode)." >";	
			$xmlstr .= parsexml($childnode);
			$xmlstr .= "</".$childnode->nodeName.">";
		}
		else
		{
			$xmlstr .= trim($childnode->nodeValue);
		}
		
	}
	return $xmlstr;
}

function getattributes($t_node)
{
	$xmlstr = "";
	if(count($t_node->attributes) < 0) return;
	foreach($t_node->attributes as $attribute)
	{
		$xmlstr .= mapattributeprefix($attribute->nodeName)."=\"".$attribute->nodeValue."\" ";
		//$xmlstr .= " ss:".$attribute->nodeName."=\"".$attribute->nodeValue."\" ";
	}
	return $xmlstr;
}

function mapattributeprefix($t_attributename)
{
	switch($t_attributename)
	{
		case "Family":
		case "CharSet":
			$prefix = " x:".$t_attributename;
			break;
		case "Face":
			$prefix = " html:".$t_attributename;
			break;
		case "xmlns":
			$prefix = " ".$t_attributename;
			break;
		default:
			$prefix = " ss:".$t_attributename;
			break;
	}
	return $prefix;
}
?>
