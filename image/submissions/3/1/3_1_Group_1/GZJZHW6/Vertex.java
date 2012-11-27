/******************************************************************************/
/*                                                                            */
/* Vertex.java                                                                */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class that is used to describe a vertex							      */
/*                                                                            */
/* Instance Variables: 														  */
/*   id - identification of vertex							                  */
/*   edges - edges that start from this vertex                                */
/*                                                                            */
/* Constructors:															  */
/*   Vertex()                                                        	  	  */
/*   Vertex(id)                                                               */
/*   Vertex(id, edges)                                                        */
/*                                                                            */
/* Methods:                                                                   */
/*   getID()                  - Returns identification of the vertex          */
/*   getEdges()               - Returns the edges that start from this vertex */
/*   setID()                  - Sets identification of the vertex             */
/*   setEdges()               - Sets the edges that start from this vertex    */
/*   toString()	 			  - Returns a string representing the vertex      */
/*   equals()			      - Compares if two vertices are equal            */
/*   compareTo(Vertex vertex) - Compares two vertices based on vertex's id    */																		
/******************************************************************************/
import java.util.LinkedList;

public class Vertex implements Comparable<Vertex>{
	
	//identification of vertex
	private String id;
	//edges that start from this vertex
	private LinkedList<Edge> edges;
	
	
	public Vertex(){
		this(null,null);
	}
	
	public Vertex(String id){
		this.id = id;	
	}
	
	public Vertex(String id, LinkedList<Edge> edgesList){
		this.id = id;
		this.edges = edgesList;
	}
	
	
	/**
	 * Returns identification of the vertex
	 * @return
	 */
	public String getID(){
		return id;
	}
	
	/**
	 * Returns the edges that start from this vertex
	 * @return
	 */
	public LinkedList<Edge> getEdges(){
		return edges;
	}
	
	/**
	 * Sets the identification of the vertex
	 * @param id
	 */
	public void setID(String id){
		this.id = id;
	}
	
	/**
	 * Sets the edges that start from this vertex
	 * @param edge
	 */
	public void setEdges(Edge edge){
		edges.add(edge);
	}
	
	/**
	 * Returns a string representing the vertex
	 * @return
	 */
	public String toString(){
		return id;
	}
	
	/**
	 * Compares if two vertices are equal
	 */
	 public boolean equals(Object vertex) {
		 return id.equals(((Vertex)vertex).id);
	 }

	/**
	 * Compares two vertices based on vertex's id
	 * @return negative if this vertex is less that the passed-in vertex
	 * 0 if they are equal
	 * positive if this vertex is greater that the passed-in vertex
	 */
	public int compareTo(Vertex vertex) {
		return id.compareTo(vertex.id);
	}
	
}
