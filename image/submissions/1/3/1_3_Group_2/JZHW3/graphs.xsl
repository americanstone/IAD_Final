<?xml version="1.0"?>
<!--  graphs.xsl
      Jing Zhao
      CSC 626: Web Technologies
      Assignment 3
      3/5/2012 -->
      
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

	<xsl:output method="html"/>
	
	<xsl:template match="charts">
		<html>
		<head>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
  			<xsl:for-each select="chart">
				<script type="text/javascript">
				<!-- Load the Visualization API -->
				google.load('visualization', '1.0', {'packages':['corechart']});
				google.load('visualization', '1', {'packages': ['geochart']});
				google.load('visualization', '1', {packages:['gauge']});
				
				<!-- Set a callback to run when the Google Visualization API is loaded. -->
				google.setOnLoadCallback(drawChart);
			
				function drawChart() {
			
				<!-- Create the data table. --> 
        		var data = new google.visualization.DataTable();
        		<xsl:for-each select="columns/column">
        			data.addColumn('<xsl:value-of select="@type"/>', '<xsl:value-of select="@name"/>');
       			</xsl:for-each>   			
       			
                <xsl:choose>
                	<xsl:when test="@type='pie'"> 
                		<xsl:call-template name="pieChart">
                			<xsl:with-param name="ChartID" select="@id"/>
                		</xsl:call-template>
                	</xsl:when>
                	<xsl:when test="@type='bar'"> 
                		<xsl:call-template name="barChart">
                			<xsl:with-param name="ChartID" select="@id"/>
                		</xsl:call-template>
                	</xsl:when>
                	<xsl:when test="@type='bubble'"> 
                		<xsl:call-template name="bubbleChart">
                			<xsl:with-param name="ChartID" select="@id"/>
                		</xsl:call-template>
                	</xsl:when>
                	<xsl:when test="@type='geo'"> 
                		<xsl:call-template name="geoChart">
                			<xsl:with-param name="ChartID" select="@id"/>
                		</xsl:call-template>
                	</xsl:when>
                	<xsl:when test="@type='gauge'"> 
                		<xsl:call-template name="gauge">
                			<xsl:with-param name="ChartID" select="@id"/>
                		</xsl:call-template>
                	</xsl:when>
                </xsl:choose>       
                chart.draw(data, options);
     			}
			
				</script>
  			</xsl:for-each>
  		</head>
  		<body>
  			<xsl:for-each select="chart">
  				<xsl:variable name="CharID" select="@id"/>
    			<!--Div that will hold charts-->
   				<p><div id="{$CharID}" align="center"></div></p>
   			</xsl:for-each>
 		</body>
	 	</html>
	</xsl:template>
		 
	<!-- Template for pie chart -->
	<xsl:template name="pieChart">			
		<xsl:param name="ChartID"/>
		data.addRows([
       	<xsl:for-each select="rows/row">
       		['<xsl:value-of select="@name"/>', <xsl:value-of select="@value"/>]
       		<xsl:if test="position()!=last()">
       			<xsl:text>,</xsl:text>
       		</xsl:if>
       	</xsl:for-each>
       	]);
       	<!-- Set chart options -->
        var options = {'title':'<xsl:value-of select="title"/>',
                       'width':<xsl:value-of select="@width"/>,
                       'height':<xsl:value-of select="@height"/>};
		var chart = new google.visualization.PieChart(document.getElementById('<xsl:value-of select="$ChartID"/>'));	
	</xsl:template>
	
	<!-- Template for bar chart -->
	<xsl:template name="barChart">			
		<xsl:param name="ChartID"/>
		data.addRows([
       	<xsl:for-each select="rows/row">
       		['<xsl:value-of select="@name"/>', <xsl:value-of select="@value1"/>, <xsl:value-of select="@value2"/>]
       		<xsl:if test="position()!=last()">
       			<xsl:text>,</xsl:text>
       		</xsl:if>
       	</xsl:for-each>
       	]);
       	<!-- Set chart options -->
       	<xsl:variable name="vAxis">
       		<xsl:for-each select="columns/column">
       			<xsl:if test="position()=1">
       				<xsl:value-of select="@name"/>
       			</xsl:if>
       		</xsl:for-each>
       	</xsl:variable>
        var options = {'title':'<xsl:value-of select="title"/>',
        			   vAxis: {title: '<xsl:value-of select="$vAxis"/>'},
                       'width':<xsl:value-of select="@width"/>,
                       'height':<xsl:value-of select="@height"/>};
		var chart = new google.visualization.BarChart(document.getElementById('<xsl:value-of select="$ChartID"/>'));	
	</xsl:template>
	
	<!-- Template for bubble chart -->
	<xsl:template name="bubbleChart">			
		<xsl:param name="ChartID"/>
	
		data.addRows([
       	<xsl:for-each select="rows/row">
       		['<xsl:value-of select="@name1"/>', <xsl:value-of select="@value1"/>, <xsl:value-of select="@value2"/>, '<xsl:value-of select="@name2"/>', <xsl:value-of select="@value3"/>]
       		<xsl:if test="position()!=last()">
       			<xsl:text>,</xsl:text>
       		</xsl:if>
       	</xsl:for-each>
       	]);
       	<!-- Set chart options -->
       	<xsl:variable name="hAxis">
       		<xsl:for-each select="columns/column">
       			<xsl:if test="position()=2">
       				<xsl:value-of select="@name"/>
       			</xsl:if>
       		</xsl:for-each>
       	</xsl:variable>
       	<xsl:variable name="vAxis">
       		<xsl:for-each select="columns/column">
       			<xsl:if test="position()=3">
       				<xsl:value-of select="@name"/>
       			</xsl:if>
       		</xsl:for-each>
       	</xsl:variable>
        var options = {'title':'<xsl:value-of select="title"/>',
        			   hAxis:{title: '<xsl:value-of select="$hAxis"/>'},
        			   vAxis: {title: '<xsl:value-of select="$vAxis"/>'},
         			   bubble: {textStyle: {fontSize: 11}},
                       'width':<xsl:value-of select="@width"/>,
                       'height':<xsl:value-of select="@height"/>};
		var chart = new google.visualization.BubbleChart(document.getElementById('<xsl:value-of select="$ChartID"/>'));	
	</xsl:template>
	
	<!-- Template for geo chart -->
	<xsl:template name="geoChart">			
		<xsl:param name="ChartID"/>
		data.addRows([
       	<xsl:for-each select="rows/row">
       		['<xsl:value-of select="@name"/>', <xsl:value-of select="@value"/>]
       		<xsl:if test="position()!=last()">
       			<xsl:text>,</xsl:text>
       		</xsl:if>
       	</xsl:for-each>
       	]);
       	<!-- Set chart options -->
        var options = {'title':'<xsl:value-of select="title"/>',
                       'width':<xsl:value-of select="@width"/>,
                       'height':<xsl:value-of select="@height"/>};
		var chart = new google.visualization.GeoChart(document.getElementById('<xsl:value-of select="$ChartID"/>'));	
	</xsl:template>
	
	<!-- Template for gauge -->
	<xsl:template name="gauge">			
		<xsl:param name="ChartID"/>
		data.addRows([
       	<xsl:for-each select="rows/row">
       		['<xsl:value-of select="@name"/>', <xsl:value-of select="@value"/>]
       		<xsl:if test="position()!=last()">
       			<xsl:text>,</xsl:text>
       		</xsl:if>
       	</xsl:for-each>
       	]);
       	<!-- Set chart options -->
        var options = {'title':'<xsl:value-of select="title"/>',
                       'width':<xsl:value-of select="@width"/>,
                       'height':<xsl:value-of select="@height"/>,
          				redFrom: 90, redTo: 100,
         				yellowFrom:75, yellowTo: 90,
          				minorTicks: 5
        };
		var chart = new google.visualization.Gauge(document.getElementById('<xsl:value-of select="$ChartID"/>'));	
	</xsl:template>
	
</xsl:stylesheet>