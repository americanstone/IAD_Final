/******************************************************************************/
/*                                                                            */
/*SAXProg.java                                                                */
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
/*   pages - an WebPage array to store information of WebPage 				  */
/*   page - an WebPage object to store the information about WebPage          */
/*   pageCounter - counter for pages                                          */
/*   stack -  A stack to store the information about image                    */
/*   readyForText - indicates if it is ready to grab the content of text node */
/*                                                                            */
/* Methods:                                                                   */
/*   testDOMParser()  - Tests if SAXParser correctly gets the information     */
/*                      from XML file        	            				  */
/*   createHTML(WebPage[] pages, int i)                          			  */
/*                    - Creates HTML files                       			  */
/* Override Methods:                                                         */
/*   characters(char[] ch, int start, int length)                             */
/*   endDocument()                                                            */
/*   endElement(String uri, String localName, String qName)                   */
/*   startElement(String uri, String localName, String qName, Attributes atts)*/
/******************************************************************************/

import java.io.BufferedWriter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.util.Iterator;
import java.util.Stack;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.xml.sax.Attributes;
import org.xml.sax.ContentHandler;
import org.xml.sax.InputSource;
import org.xml.sax.Locator;
import org.xml.sax.SAXException;
import org.xml.sax.XMLReader;

public class SAXProg implements ContentHandler {

	// the directory in which image files are stored
	private String directory;
	// the page numbers in the XML file
	private int pageNumber;
	// an WebPage array to store informations of WebPage
	private WebPage pages[];
	// an WebPage object to store information about WebPage
	private WebPage page;
	// counter for pages
	private int pageCount = 0;
	// A stack to store the information about image
	private Stack<WebPage.Image> stack = new Stack<WebPage.Image>();
	// indicates if it is ready to grab the content of text node
	private boolean readyForText = false;

	public static void main(String[] args) {

		// xml file should be specified
		if (args.length != 1) {
			System.out.println("Usage: java SAXProg <xml_file_name>");
			System.exit(-1);
		}
		SAXParserFactory saxFactory = SAXParserFactory.newInstance();
		try {

			SAXParser saxParser = saxFactory.newSAXParser();
			XMLReader xmlReader = saxParser.getXMLReader();
			xmlReader.setContentHandler(new SAXProg());
			InputStream inputStream = new FileInputStream(args[0]);
			InputSource source = new InputSource(inputStream);
			xmlReader.parse(source);

		} catch (ParserConfigurationException e) {
			e.printStackTrace();
		} catch (SAXException e) {
			e.printStackTrace();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}

	}

	@Override
	public void characters(char[] ch, int start, int length)
			throws SAXException {
		if (readyForText) {
			stack.peek().description = new String(ch, start, length);
			readyForText = false;
		}

	}

	@Override
	public void endDocument() throws SAXException {
		for (int i = 0; i < pages.length; i++) {
			createHTML(pages, i);
		}

	}

	/**
	 * Tests if SAXParser correctly gets information from XML file
	 */
	public void testSAXParser() {
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
							+ "\" " + "width=\"" + pages[i].getImgWidth()
							+ "\" " + "height=\"" + pages[i].getImgHeight()
							+ "\" />");
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
					bWriter.write("<span style =\"color: grey\">" + linkName
							+ "</span>");
				} else {
					bWriter.write("<a style =\"text-decoration:none\" href = \""
							+ pageName + "\">  " + linkName + "</a>");
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

	@Override
	public void endElement(String uri, String localName, String qName)
			throws SAXException {
		if (qName.equals("img")) {
			if (!stack.isEmpty()) {
				page.images.add(stack.pop());
			}
		}
		if (qName.equals("page")) {
			pages[pageCount++] = page;
			page = null;
		}

	}

	@Override
	public void endPrefixMapping(String arg0) throws SAXException {

	}

	@Override
	public void ignorableWhitespace(char[] arg0, int arg1, int arg2)
			throws SAXException {

	}

	@Override
	public void processingInstruction(String arg0, String arg1)
			throws SAXException {

	}

	@Override
	public void setDocumentLocator(Locator arg0) {

	}

	@Override
	public void skippedEntity(String arg0) throws SAXException {

	}

	@Override
	public void startDocument() throws SAXException {

	}

	@Override
	public void startElement(String uri, String localName, String qName,
			Attributes atts) throws SAXException {
		if (qName.equals("album")) {
			directory = atts.getValue("directory");

		}
		if (qName.equals("pages")) {
			pageNumber = Integer.parseInt(atts.getValue("number"));
			pages = new WebPage[pageNumber];
		}
		if (qName.equals("page")) {
			page = new WebPage();
			page.setPageName(atts.getValue("name"));
			page.setPageTitle(atts.getValue("title"));
			page.setRows(Integer.parseInt(atts.getValue("rows")));
			page.setColumns(Integer.parseInt(atts.getValue("cols")));
			page.setBgColor(atts.getValue("background_color"));
			page.setImgWidth(Integer.parseInt(atts.getValue("width")));
			page.setImgHeight(Integer.parseInt(atts.getValue("height")));

		}
		if (qName.equals("img")) {
			if (page != null) {
				stack.push(page.new Image());
				stack.peek().source = directory + "/" + atts.getValue("src");
				readyForText = true;
			}
		}

	}

	@Override
	public void startPrefixMapping(String arg0, String arg1)
			throws SAXException {

	}

}
