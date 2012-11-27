package net.webtech;

import java.util.ArrayList;
import org.w3c.dom.*;
import org.apache.xerces.parsers.*;

public class DOMProg {

	// return the DOM root of file
	public static Element getXMLroot(String xmlFile) {
		try {
			DOMParser p = new DOMParser();
			p.parse(xmlFile);
			Document doc = p.getDocument();
			return doc.getDocumentElement();
		} catch (Exception e) {
			e.getStackTrace();
			return null;
		}
	}

	public static ArrayList<Plants> getPlant(Node root) {
		ArrayList<Plants> p = new ArrayList<Plants>();
		String code = null;
		String common = null;
		String botanical = null;
		String light = null;
		String zone = null;
		String price = null;
		String available = null;
		root.getChildNodes();
		for (int i = 0; i < root.getChildNodes().getLength(); i++) {
			Node state = root.getChildNodes().item(i);
			if (state.getNodeType() == Node.ELEMENT_NODE) {
				code = state.getAttributes().getNamedItem("code").getNodeValue();
				NodeList plantNodes = state.getChildNodes();
				for (int j = 0; j < plantNodes.getLength(); j++) {
					Node plant = plantNodes.item(j);
					if (plant.getNodeType() == Node.ELEMENT_NODE) {
						// get the pointer point to the node list of plant
						NodeList plantChildren = plant.getChildNodes();
						int m = 0;
						for (int k = 0; k < plantChildren.getLength(); k++) {
							if (plantChildren.item(k).getNodeType() == Node.ELEMENT_NODE) {
								m++;
								NodeList textNodes = plantChildren.item(k)
										.getChildNodes();
								for (int n = 0; n < textNodes.getLength(); n++) {
									if (textNodes.item(n).getNodeType() == Node.TEXT_NODE) {
										switch (m) {
										case 1:
											common = textNodes.item(n)
													.getNodeValue();
											break;
										case 2:
											botanical = textNodes.item(n)
													.getNodeValue();
											break;
										case 3:
											zone = textNodes.item(n)
													.getNodeValue();
											break;
										case 4:
											light = textNodes.item(n)
													.getNodeValue();
											break;
										case 5:
											price = textNodes.item(n)
													.getNodeValue().substring(1);
											break;
										case 6:
											available = textNodes.item(n)
													.getNodeValue();
											break;
										}
									}
								}
							}
						}
						p.add(new Plants(code,common, botanical, zone, light, price,
								available));
					}
				}
			}
		}
		return p;
	}
	public static ArrayList<State> getState(Node root, ArrayList<Plants> plantList){
		
		ArrayList<State> s = new ArrayList<State>();
		String code = null;
		String name = null;
		String nickname = null;
		String zone = null;
		State st = null;
		NodeList states = root.getChildNodes();
		for (int i = 0; i < root.getChildNodes().getLength(); i++) {
			if(states.item(i).getNodeType() == Node.ELEMENT_NODE){
				code = states.item(i).getAttributes().getNamedItem("code").getNodeValue();
				Node state = states.item(i);
				NodeList stateChildren = state.getChildNodes();
				int m = 0;
				for(int j = 0; j <stateChildren.getLength();j++){
					if(stateChildren.item(j).getNodeType() == Node.ELEMENT_NODE){
						m++;
						NodeList text = stateChildren.item(j).getChildNodes();
						for(int k = 0; k < text.getLength(); k++){
							if(text.item(k).getNodeType() == Node.TEXT_NODE ){
								switch(m){
								case 1:
									name = text.item(k).getNodeValue();
									break;
								case 2:
									nickname = text.item(k).getNodeValue();
									break;
								case 3:
									zone = text.item(k).getNodeValue();
								}
							}
						}
					}
				}
				//System.out.println(code+ " " +name+" " + nickname+" "+ zone);
				st = new State(code, name, nickname, zone, new ArrayList<Plants>());
				s.add(st);
			}
		}
		for(int m = 0; m <s.size(); m++){
			for(int n = 0; n < plantList.size(); n++){
				if(plantList.get(n).getCode().equals(s.get(m).getCode())){	
					s.get(m).setPlants(plantList.get(n));
				}
			}
		}
		
		return s;
	}
}
