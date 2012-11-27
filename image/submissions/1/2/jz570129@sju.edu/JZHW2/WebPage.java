/******************************************************************************/
/*                                                                            */
/*WebPage.java                                                                */
/*                                                                            */
/* Author: Jing Zhao                                              			  */
/* Date: Feb. 20, 2012                                             		   	  */
/* Course: CSC626                                                             */
/* Homework: HW2                                                              */
/*                                                                            */
/* A class that represents a HTML page parsed from XML file         		  */
/* 																			  */
/* class Image																  */
/* inner class for describing image in a web page                             */
/*                                                                            */
/* Instance Variables: 														  */
/*   rows - how many rows the images are displayed                            */
/*   columns - how many columns the images are displayed	  				  */
/*   imgWidth - width of an image			                                  */
/*   imgHeight - height of an image                                           */
/*   pageTile - title of a web page 						  				  */
/*   pageName - file name of a web page										  */
/*   bgColor - background color of a web page                                 */
/*   images - an array list to store images   								  */
/*                                                                            */
/* Methods:                                                                   */
/*  Accessor and mutator methods for each instance variables                 */
/******************************************************************************/

import java.util.ArrayList;

public class WebPage {
	// how many rows the images are displayed
	private int rows;
	// how many columns the images are displayed
	private int columns;
	// width of an image
	private int imgWidth;
	// height of an image
	private int imgHeight;
	// title of a web page
	private String pageTitle;
	// file name of a web page
	private String pageName;
	// background color of a web page
	private String bgColor;
	// an array list to store images 
	ArrayList<Image> images = new ArrayList<Image>();

	// inner class for describing image in a web page
	class Image {
		// location of the image
		String source;
		// discription of the image
		String description;
	}

	public int getRows() {
		return rows;
	}

	public void setRows(int rows) {
		this.rows = rows;
	}

	public int getColumns() {
		return columns;
	}

	public void setColumns(int columns) {
		this.columns = columns;
	}
	
	public int getImgWidth() {
		return imgWidth;
	}

	public void setImgWidth(int width) {
		this.imgWidth = width;
	}
	
	public int getImgHeight() {
		return imgHeight;
	}

	public void setImgHeight(int height) {
		this.imgHeight = height;
	}

	public String getPageTitle() {
		return pageTitle;
	}

	public void setPageTitle(String title) {
		pageTitle = title;
	}

	public String getPageName() {
		return pageName;
	}

	public void setPageName(String name) {
		pageName = name;
	}

	public String getBgColor() {
		return bgColor;
	}

	public void setBgColor(String color) {
		bgColor = color;
	}

}