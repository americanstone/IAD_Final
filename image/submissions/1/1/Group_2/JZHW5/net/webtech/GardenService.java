package net.webtech;
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;

public class GardenService {
	private ArrayList<State> s;
	
	public void init(){
		String pFile = "net/config/plants.xml";
		String sFile = "net/config/states.xml";
		
		ArrayList<Plants> p = DOMProg.getPlant(DOMProg.getXMLroot(pFile));
		s = DOMProg.getState(DOMProg.getXMLroot(sFile),p);
	}
	
	/*
	 *  Which state grows the largest variety of plants?
	 */
	public String queryA(){
		init();
		StringBuffer sb = new StringBuffer();
		int max = 0;
		for(int i = 0; i < s.size(); i++){
			int num = s.get(i).getPlants().size();
			if( num > max){
				max = num;
			}
		} 
		for(int i = 0; i <s.size(); i++){
			if(s.get(i).getPlants().size() == max){
				sb.append(s.get(i).getName()+" ");
			}
		}
		
		return sb.toString() + "has(have) grows the largest variety of plants.";
	}
	/*
	 * Which plants are sold in Texas but not in Pennsylvania?
	 */
	
	public String queryB(){
		init();
		ArrayList<Plants> PAPlants = null;
		ArrayList<Plants> TXPlants = null;
		StringBuffer sb = new StringBuffer();
		for(int i = 0; i <s.size(); i++){
			if(s.get(i).getCode().equals("PA")){
				PAPlants = s.get(i).getPlants();
			}
			if(s.get(i).getCode().equals("TX")){
				TXPlants = s.get(i).getPlants();
			}
		}	
		
		for(int i = 0; i < TXPlants.size(); i++){
			boolean diff = true;
			for(int j = 0; j <PAPlants.size(); j++){
				if(TXPlants.get(i).getCommon().equals(PAPlants.get(j).getCommon())){
					diff =false;
					continue;
				}
			}
			if(diff){
				sb.append((TXPlants.get(i).getCommon())+"| ");
			}
		}
		return sb.toString()+ "are sold in Texas but no in Pennsylvania.";
	}
	
	/*
	 * What is the nickname of the state that sells the most expensive plant?
	 */
	
	public String queryC(){
		init();
		Iterator<State> it = s.iterator();
		double maxPrice = 0;
		State maxState = null;
		
		while(it.hasNext()){
			State state = it.next();
			ArrayList<Plants> plantsList = state.getPlants();
			double part = 0;
			for(int i = 0; i < plantsList.size();i++){
				if(part < Double.parseDouble(plantsList.get(i).getPrice())){
					part = Double.parseDouble(plantsList.get(i).getPrice());
				}
			}
			if(part > maxPrice){
				maxPrice = part;
				maxState = state;
			}
		}
		return maxState.getName()+" sells the most expensive plant.";
	}
	
	/*
	 * Which shade plants have been available for sale after March 15, 2012?
	 */
	public String queryD(){
		init();
		Date flagtime = new Date(2012,03,15);
		Date available;
		ArrayList<Plants> plantsList = new ArrayList<Plants>();
		//ArrayList<String> plantsnameList = new ArrayList<String>();
		StringBuffer sb = new StringBuffer();
		Iterator<State> its = s.iterator(); 
		
		while(its.hasNext()){
			plantsList.addAll(its.next().getPlants());
		}
		Iterator<Plants> itp= plantsList.iterator();	
		while(itp.hasNext()){
			Plants p = itp.next();
			int year = Integer.parseInt("20" + p.getAvailable().substring(4, 6));
			int month = Integer.parseInt(p.getAvailable().substring(0, 2));
			int date = Integer.parseInt(p.getAvailable().substring(2, 4));
			available = new Date(year,month,date);
			if(p.getLight().equalsIgnoreCase("shade") &&  available.after(flagtime)){
				sb.append((p.getCommon())+"| ");
			}
		}
		return sb.toString()+ " are available for sale after March 15, 2012.";
	}
	
	/*
	 * Which states grow the largest number of plants that are most suitable for their environment? 
	 * (A plant with the zone requirement of x can grow most successfully in a state with the USDA hardiness zone of x)
	 */
	public String queryE(){
		init();
		Iterator<State> its = s.iterator();
		
		int maxNumPlantSuit = 0;
		State maxState = null;
		while(its.hasNext()){
			State state = its.next();
			String zoneRange = state.getZone();
			int upbound;
			int lowerbound;
			int cross = zoneRange.indexOf("-");
			if(cross == -1){
				upbound = lowerbound = Integer.parseInt(zoneRange);
			}else{
				lowerbound =Integer.parseInt(zoneRange.substring(0, cross).trim());
				upbound = Integer.parseInt(zoneRange.substring(cross+1).trim());
			}
			
			ArrayList<Plants> plantList = state.getPlants();
			Iterator<Plants> itp= plantList.iterator();
			int count = 0;
			
			while(itp.hasNext()){
				Plants plant = itp.next();
				//add some code handel the plant zone range 3 -5 !!!!!!!!!!!!!!!!!!!!!!!!!1
				int zone = Integer.parseInt(plant.getZone());
				if(zone>= lowerbound && zone <= upbound){
					count++;
				}
			}	
			if(count > maxNumPlantSuit){
				maxNumPlantSuit = count;
				maxState = state;
			}
		}
		return "Following states grow the largest number of plants that are most suitable for their environment\n"+ maxState.getName();
	}
	
	/*
	 * Which plants are suitable for sunny environments?
	 */
	public String queryF(){
		init();
		//ArrayList<String> plantsNameList = new ArrayList<String>();
		StringBuffer sb = new StringBuffer();
		Iterator<State> its = s.iterator();		
		while(its.hasNext()){
			ArrayList<Plants> plants = its.next().getPlants();
			Iterator<Plants> itp = plants.iterator();
			while(itp.hasNext()){
				Plants plant = itp.next();
				if(plant.getLight().equals("sunny")){
					sb.append((plant.getCommon())+ "| ");
				}
			}
		}
		return sb.toString()+" are suitable for sunny environments.";
	}
	
	/*
	 * Among plants grown in every state which is the least expensive and in what month will it become available?
	 */
	public String queryG(){
		init();
		StringBuffer sb = new StringBuffer();
		Iterator<State> its = s.iterator();	
		Plants cheapestPlant = null;
		double cheapestPrice = Double.MAX_VALUE;		
		while(its.hasNext()){
			ArrayList<Plants> plants = its.next().getPlants();
			Iterator<Plants> itp = plants.iterator();
			while(itp.hasNext()){
				Plants plant = itp.next();
				if(Double.parseDouble(plant.getPrice()) < cheapestPrice){
					cheapestPrice = Double.parseDouble(plant.getPrice());
					cheapestPlant = plant;
				}
			}
		}
		sb.append(cheapestPlant.getCommon()+" is the least expensive and it is available on ");

		int month = Integer.parseInt(cheapestPlant.getAvailable().substring(0, 2));
		switch(month){
		case 1:
			sb.append("Jan.");
			break;
		case 2:
			sb.append("Feb.");
			break;
		case 3:
			sb.append("March.");
			break;
		case 4:
			sb.append("Apr.");
			break;
		case 5:
			sb.append("May.");
			break;
		case 6:
			sb.append("Jun.");
			break;
		case 7:
			sb.append("July.");
			break;
		case 8:
			sb.append("Aug.");
			break;
		case 9:
			sb.append("Sep.");
			break;
		case 10:
			sb.append("Oct.");
			break;
		case 11:
			sb.append("Nov.");
			break;
		case 12:
			sb.append("Dec");
			break;
}
		return sb.toString();
	}
}
