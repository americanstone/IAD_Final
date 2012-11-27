/******************************************************************************/
/*                                                                            */
/* MultiwayTree.java                                                          */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class extending from MutliwayTree  						 			  */
/*                                                                            */
/* Instance Variables: 														  */
/*                                                                            */
/* Constructors:															  */
/*                                                                            */
/* Methods:                                                                   */
/*   generateMST(Graph graph) - Generates an MST for the specified graph	  */																
/******************************************************************************/
import java.util.LinkedList;

public class MST extends MultiwayTree<Vertex> {

	public static MST generateMST(Graph graph) {
		MST mst = new MST();
		Vertex[] vertices = graph.getVertices();
		// initialize all nodes with vertices as their data
		// and infinity as their key
		// then push all nodes into priority queue
		KWPriorityQueue<Node> queue = new KWPriorityQueue<Node>();
		
		for (int i = 0; i < vertices.length; i++) {
			Node node = mst.new Node(vertices[i], Double.MAX_VALUE, null);
			mst.dataNodeMap.put(vertices[i], node);
			queue.offer(node);
		}

		while (!queue.isEmpty()) {
			Node polledNode = queue.poll();
			// append the polled node to the tree
			if (!mst.addNode(polledNode))
				System.out.println("Fatal error");
			// for the vertices that are adjacent to the polled vertex
			// update their key
			LinkedList<Edge> edges = polledNode.data.getEdges();
			for (int i = 0; i < edges.size(); i++) {
				Edge edge = edges.get(i);
				Vertex adjVertex = edge.getNeighbor();
				Node adjNode = mst.dataNodeMap.get(adjVertex);
				if (adjNode != null && adjNode.key > edge.getWeight()
						&& queue.contains(adjNode)) {

					adjNode.key = edge.getWeight();
					adjNode.parent = polledNode;

				}
				// reorganize the priority queue
				queue.reorganize();
			}
		}
		return mst;
	}
}
