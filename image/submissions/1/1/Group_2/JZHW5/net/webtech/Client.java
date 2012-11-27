package net.webtech;

import java.util.*;
import net.webtech.*;

public class Client {

	public static void main(String[] args) throws Exception{
		GardonServiceStub stub = new GardonServiceStub();

		if (args[0].equalsIgnoreCase("queryA")) {
			net.webtech.GardonServiceStub.QueryA  requestA = new net.webtech.GardonServiceStub.QueryA();
			net.webtech.GardonServiceStub.QueryAResponse response = stub.queryA(requestA);	
			System.out.println("Response : " + response.get_return());
		} else if (args[0].equalsIgnoreCase("queryB")) {
			net.webtech.GardonServiceStub.QueryB  requestB = new net.webtech.GardonServiceStub.QueryB();
			net.webtech.GardonServiceStub.QueryBResponse response = stub.queryB(requestB);
			System.out.println("Response : " + response.get_return());
		} else if (args[0].equalsIgnoreCase("queryC")) {
			net.webtech.GardonServiceStub.QueryC  requestC = new net.webtech.GardonServiceStub.QueryC();
			net.webtech.GardonServiceStub.QueryCResponse response = stub.queryC(requestC);
			System.out.println("Response : " + response.get_return());
		} else if (args[0].equalsIgnoreCase("queryD")) {
			net.webtech.GardonServiceStub.QueryD  requestD = new net.webtech.GardonServiceStub.QueryD();
			net.webtech.GardonServiceStub.QueryDResponse response = stub.queryD(requestD);
			System.out.println("Response : " + response.get_return());
		} else if (args[0].equalsIgnoreCase("queryE")) {
			net.webtech.GardonServiceStub.QueryE  requestE = new net.webtech.GardonServiceStub.QueryE();
			net.webtech.GardonServiceStub.QueryEResponse response = stub.queryE(requestE);
			System.out.println("Response : " + response.get_return());
		} else if (args[0].equalsIgnoreCase("queryF")) {
			net.webtech.GardonServiceStub.QueryF  requestF = new net.webtech.GardonServiceStub.QueryF();
			net.webtech.GardonServiceStub.QueryFResponse response = stub.queryF(requestF);
			System.out.println("Response : " + response.get_return());
		} else if(args[0].equalsIgnoreCase("queryG")){
			net.webtech.GardonServiceStub.QueryG  requestG = new net.webtech.GardonServiceStub.QueryG();
			net.webtech.GardonServiceStub.QueryGResponse response = stub.queryG(requestG);
			System.out.println("Response : " + response.get_return());
		}else{
			System.out.println("error input");
		}
		
	}
}
