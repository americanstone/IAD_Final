/******************************************************************************/
/*                                                                            */
/* Graph.java                                                              	  */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class that is used to describe a graph									  */
/*                                                                            */
/* Instance Variables: 														  */
/*   vertexMap - stores the vertices that make up the graph                   */
/*                                                                            */
/* Constructors:															  */
/*   Graph()                                                        	  	  */
/*                                                                            */
/* Methods:                                                                   */
/*   createGraph(Scanner scan) - Generates an undirected graph stores it in   */
/*                               HashMap vertexMap                            */
/*   getNumV()	 			   - Returns the vertices number in the graph     */
/*   getVertices()			   - Returns all vertices in an array of Vertex	  */
/******************************************************************************/

import java.util.Collection;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.Scanner;


public class Graph {
	
	//stores the vertices that make up the graph
	private HashMap<String, Vertex> vertexMap;
	
	public Graph(){
		vertexMap = new HashMap<String,Vertex>();
	}
	
	
	/**
	 * Returns the vertices number in the graph
	 * @return
	 */
	public int getNumV(){
		return vertexMap.size();
	}
	
	/** 
	 * Returns all vertices in an array of Vertex
	 * @return
	 */
	public Vertex[] getVertices(){
		Vertex[] vertices = new Vertex[vertexMap.size()];
		Collection<Vertex> vers = vertexMap.values();
		int i = 0;
		for(Vertex v : vers){
			vertices[i] = v;
			i++;
		}
		return vertices;
	}

	/**
	 * Generates an undirected graph stores it in HashMap vertexMap
	 * @param scan The input file
	 * @return The array of Vertex object
	 */
	public static Graph createGraph(Scanner scan){
		Graph graph = new Graph();
		//First line of input file is the number of vertices
		int numVertex = Integer.parseInt(scan.next());
		for(int i = 0; i <numVertex; i++){
			String id = scan.next();
			Vertex vertex = new Vertex(id,new LinkedList<Edge>());
			graph.vertexMap.put(id, vertex);
		}
		//The number of edges following all vertices in input file
		int numEdge = Integer.parseInt(scan.next());
		scan.nextLine();
		for(int i = 0; i < numEdge; i++){
			String readLine = scan.nextLine();
			//Edge is denoted as A B 10 in input file
			String delims = "[ ]+";
			String[] temp = readLine.split(delims);
			String endpoint1 = temp[0];
			String endpoint2 = temp[1];
			double wgt = Double.parseDouble(temp[2]);
			//undirected graph, add two edges
			graph.vertexMap.get(endpoint1).setEdges(new Edge(graph.vertexMap.get(endpoint2),wgt));
			graph.vertexMap.get(endpoint2).setEdges(new Edge(graph.vertexMap.get(endpoint1),wgt));
		}
		return graph;
	}
	

}