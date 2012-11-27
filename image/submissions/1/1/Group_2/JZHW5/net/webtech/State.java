package net.webtech;


import java.util.ArrayList;


public class State {
	
	private ArrayList<Plants> p;
	private String code;
	private String name;
	private String nickname;
	private String zone;
	
	public State(String code,String name,String nickname,String zone,ArrayList<Plants> p){
		this.code = code;
		this.name = name;
		this.nickname = nickname;
		this.zone = zone;
		this.p = p;
	}
	public ArrayList<Plants> getPlants(){
		return p;
	}
	public String getCode(){
		return code;
	}
	public String getName(){
		return name;
	}
	public String getNickName(){
		return nickname;
	}
	public String getZone(){
		return zone;
	}
	public void setCode(String code){
		this.code = code;
	}
	public void setName(String name){
		this.name= name;
	}
	public void setNickName(String nickname){
		this.nickname = nickname;
	}
	public void setZone(String zone){
		this.zone = zone;
	}
	public void setPlants(Plants plant){
		p.add(plant);
	}
	public String toString(){
		StringBuffer sb = new StringBuffer();
		sb.append(code+","+name+","+nickname+","+zone+",");
		for(int i = 0; i <p.size();i++){
			sb.append(p.get(i).toString());
		}
		return sb.toString();
	}
}
