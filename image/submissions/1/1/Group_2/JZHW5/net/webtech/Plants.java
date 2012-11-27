package net.webtech;


public class Plants {
	
	private String common;
	private String botanical;
	private String light;
	private String zone;
	private String price;
	private String available;
	private String code;
	
	public Plants(String code,String common, String botanical, String zone, String light, String price, String available){
		this.code = code;
		this.common = common;
		this.botanical = botanical;
		this.light = light;
		this.zone = zone;
		this.price = price;
		this.available = available;
	}

	public String getCode(){
		return code;
	}
	public String getCommon(){
		return common;
	}
	public String getBotanical(){
		return botanical;
	}
	public String getLight(){
		return light;
	}
	public String getZone(){
		return zone;
	}
	public String getPrice(){
		return price;
	}
	public String getAvailable(){
		return available;
	}
	public void setCode(String code){
		this.code = code;
	}
	public void setCommon(String common){
		this.common = common;
	}
	
	public void setBotanical(String botanical){
		this.botanical = botanical;
	}
	public void setLight(String light){
		this.light = light;
	}
	public void setZone(String zone){
		this.zone = zone;
	}
	public void setPrice(String price){
		this.price = price;
	}
	public void setAvailable(String available){
		this.available = available;
	}
	public String toString(){
		return code+ " " +common +" " + botanical +" "+ zone +" "+ light + " "+ price + " " + available;
	}

}
