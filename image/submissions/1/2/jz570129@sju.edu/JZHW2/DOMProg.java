/******************************************************************************/
/*                                                                            */
/*DOMProg.java                                                                */
/*                                                                            */
/* Author: Jing Zhao                                              			  */
/* Date: Feb. 20, 2012                                             		   	  */
/* Course: CSC626                                                             */
/* Homework: HW2                                                              */
/*                                                                            */
/* A class that is used to parse the given XML and generate HTML files		  */
/*                                                                            */
/* Instance Variables: 														  */
/*   directory - the directory in which image files are stored                */
/*   pageNumber - the page numbers in the XML file  	  					  */
/*   pages - an WebPage array to store informations of WebPage 				  */
/*                                                                            */
/* Methods:                                                                   */
/*   parse(DOMParser parser, InputSource xmlSource)                           */
/*                    - Parses the given XML file                             */
/*   testDOMParser()  - Tests if DOMParser correctly gets the information     */
/*                      from XML file        	            				  */
/*   createHTML(WebPage[] pages, int i)                          			  */
/*                    - Creates HTML files                       			  */
/******************************************************************************/

import java.io.BufferedWriter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.util.Iterator;

import org.apache.xerces.parsers.DOMParser;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

public class DOMProg {

	// the directory in which image files are stored  
	private String directory;
	// the page numbers in the XML file 
	private int pageNumber;
	// an WebPage array to store informations of WebPage 
	private WebPage pages[];

	public static void main(String[] args) {

		// xml file should be specified
		if (args.length != 1) {
			System.out.println("Usage: java DOMProg <xml_file_name>");
			System.exit(-1);
		}
		DOMParser dParser = new DOMParser();
		String xmlFile = args[0];
		InputStream in;
		try {
			in = new FileInputStream(xmlFile);
			InputSource xmlSource = new InputSource(in);
			DOMProg dom = new DOMProg();
			dom.parse(dParser, xmlSource);
			for (int i = 0; i < dom.pages.length; i++) {
				dom.createHTML(dom.pages, i);
			}

		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (SAXException e) {
			e.printStackTrace();
		}

	}

	/**
	 * Parses the XML file
	 * @param parser
	 * @param xmlSource
	 * @throws SAXException
	 * @throws IOException
	 */
	public void parse(DOMParser parser, InputSource xmlSource)
			throws SAXException, IOException {
		parser.parse(xmlSource);
		Document doc = parser.getDocument();
		Element element = doc.getDocumentElement();

		// grab the directory where images are stored and width and height
		// the images will be displayed in HTML
		directory = element.getAttribute("directory");

		// grab the number of the pages in XML
		NodeList pagesTag = element.getChildNodes();
		NodeList pageTag = null;

		for (int i = 0; i < pagesTag.getLength(); i++) {
			Node child = pagesTag.item(i);
			if (child.getNodeType() == Node.ELEMENT_NODE) {
				pageNumber = Integer.parseInt(child.getAttributes()
						.getNamedItem("number").getNodeValue());

				pageTag = child.getChildNodes();
			}
		}
		pages = new WebPage[pageNumber];

		// grab the information of each page
		int j = 0;
		for (int i = 0; i < pageTag.getLength(); i++) {
			Node child = pageTag.item(i);
			if (child.getNodeType() == Node.ELEMENT_NODE) {
				pages[j] = new WebPage();
				pages[j].setPageName(child.getAttributes().getNamedItem("name")
						.getNodeValue());
				pages[j].setRows(Integer.parseInt(child.getAttributes()
						.getNamedItem("rows").getNodeValue()));
				pages[j].setColumns(Integer.parseInt(child.getAttributes()
						.getNamedItem("cols").getNodeValue()));
				pages[j].setPageTitle(child.getAttributes()
						.getNamedItem("title").getNodeValue());
				pages[j].setBgColor(child.getAttributes()
						.getNamedItem("background_color").getNodeValue());
				pages[j].setImgWidth(Integer.parseInt(child.getAttributes()
						.getNamedItem("width").getNodeValue()));
				pages[j].setImgHeight(Integer.parseInt(child.getAttributes()
						.getNamedItem("height").getNodeValue()));
				// grab the image information for each page
				NodeList imgNodes = child.getChildNodes();
				for (int k = 0; k < imgNodes.getLength(); k++) {
					Node img = imgNodes.item(k);
					if (img.getNodeType() == Node.ELEMENT_NODE) {
						WebPage.Image image = pages[j].new Image();
						image.source = directory
								+ "/"
								+ img.getAttributes().getNamedItem("src")
										.getNodeValue();
						// grab the description of an image
						image.description = img.getFirstChild().getNodeValue();
						pages[j].images.add(image);
					}
				}
				j++;
			}
		}
	}

	/**
	 * Tests if DOMParser correctly gets the information from XML file
	 */
	public void testDOMParser() {
		System.out.println("There are " + pages.length + " pages");
		for (int i = 0; i < pages.length; i++) {
			System.out.println("page tile: " + pages[i].getPageTitle());
			System.out.println("page name: " + pages[i].getPageName());
			System.out.println("page rows: " + pages[i].getRows());
			System.out.println("page columns: " + pages[i].getColumns());
			Iterator<WebPage.Image> iter = pages[i].images.iterator();
			while (iter.hasNext()) {
				WebPage.Image image = iter.next();
				System.out.println("image source: " + image.source);
				System.out.println("description: " + image.description);
			}
		}
	}

	/**
	 * Creates HTML files
	 * @param pages
	 * @param i
	 */
	private void createHTML(WebPage[] pages, int i) {
		try {
			Object[] imgArray = pages[i].images.toArray();
			BufferedWriter bWriter = new BufferedWriter(new FileWriter(
					pages[i].getPageName()));
			bWriter.write("<html>");
			bWriter.write("<head>");
			bWriter.write("</head>");
			bWriter.write("<body style=\"background-color: "
					+ pages[i].getBgColor() + "\">");
			bWriter.write("<h2 style=\"text-align: center\">");
			bWriter.write("<b>" + pages[i].getPageTitle() + "</b>");
			bWriter.write("</h2>");
			bWriter.write("<p align=\"center\">");
			bWriter.write("<table width = \"300\">");
			for (int row = 0; row < pages[i].getRows(); row++) {
				bWriter.write("<tr>");
				for (int col = 0; col < pages[i].getColumns(); col++) {
					bWriter.write("<th>");
					bWriter.write("<img src=\""
							+ ((WebPage.Image) imgArray[row
									* pages[i].getColumns() + col]).source
							+ "\" " + "width=\"" + pages[i].getImgWidth() + "\" " + "height=\""
							+ pages[i].getImgHeight() + "\" />");
					bWriter.write("</th>");
					bWriter.write("</th>");
				}
				bWriter.write("</tr>");
				bWriter.write("<tr>");
				for (int col = 0; col < pages[i].getColumns(); col++) {
					bWriter.write("<th>");
					bWriter.write(((WebPage.Image) imgArray[row
							* pages[i].getColumns() + col]).description);
					bWriter.write("</th>");
					bWriter.write("</th>");
				}
			}
			bWriter.write("</table>");
			bWriter.write("</p>");
			bWriter.write("<h2 style=\"text-align: center\">");
			for (int j = 0; j < pages.length; j++) {
				String pageName = pages[j].getPageName();
				int index = pageName.indexOf(".");
				String linkName = pageName;
				if (index != -1) {
					linkName = pages[j].getPageName().substring(0, index);
				}
				if (j == i) {
					bWriter.write("<span style =\"color: grey\">"
							+ linkName + "</span>");
				} else {
					bWriter.write("<a style =\"text-decoration:none\" href = \"" + pageName + "\">  "
							+ linkName + "</a>");
				}
				if (j < pages.length - 1) {
					bWriter.write("  |  ");
				}
			}
			bWriter.write("</h2>");

			bWriter.write("</body>");
			bWriter.write("</html>");
			bWriter.flush();
			bWriter.close();
		} catch (IOException e) {
			System.out.println("Failed to create html file "
					+ pages[i].getPageName());
			System.exit(-1);
		}
	}

}
