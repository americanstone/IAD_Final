/******************************************************************************/
/*                                                                            */
/* Edge.java                                                              	  */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class that is used to describe an edge									  */
/*                                                                            */
/* Instance Variables: 														  */
/*   weight - the weight of the edge						                  */
/*   neighbor - the neighboring vertex                                        */
/*                                                                            */
/* Constructors:															  */
/*   Edge()                                                        	  	      */
/*   Edge(vertex, weight)                                                     */
/*                                                                            */
/* Methods:                                                                   */
/*   getWeight()    - Returns the weight of the edge         				  */
/*   getNeighbor()  - Returns the neighboring vertex						  */
/*   setWeight()    - Sets the weight of the edge          					  */
/*   setNeighbor()  - Sets the neighboring vertex 							  */
/*   toString()	    - Return a string that represents the edge                */																	
/******************************************************************************/
public class Edge {
 
    //the weight of the edge
    private double weight;
    
    //the neighboring vertex
    private Vertex neighbor;

    
    public Edge() {
        this(null, Double.MAX_VALUE);
    }

    public Edge(Vertex vertex, double weight){
    	this.neighbor = vertex;
    	this.weight = weight;
    }

    /**
     * Sets neighboring vertex
     * @param neighbor
     */
    public void setNeighbor(Vertex neighbor){
    	this.neighbor = neighbor;
    }
    
    /** 
     * Returns the neighboring vertex
     *  @return the neighboring vertex
     */
    public Vertex getNeighbor() {
        return neighbor;
    }

    /**
     * Sets the weight of the edge
     * @param weight
     */
    public void setWeight(double weight){
    	this.weight = weight;
    }
    /** 
     * Returns the weight
     *  @return the value of weight
     */
    public double getWeight() {
        return weight;
    }

    /** Return a string that represents the edge
     *  @return
     */
    public String toString() {
        StringBuilder sb = new StringBuilder("[(");
        sb.append(neighbor.getID());
        sb.append("): ");
        sb.append(Double.toString(weight));
        sb.append("]");
        return sb.toString();
    }

}

