/******************************************************************************/
/*                                                                            */
/* MultiwayTree.java                                                          */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class that is used to describe a tree with multiple children 			  */
/*                                                                            */
/* Inner Class Node represents the node in the multiway tree                  */
/*   data     - actual data stored in the node                                */
/*   key      - used for compare the node                                     */
/*   parent   - reference to the parent of the node							  */
/*   fChild   - reference to the first child of the node                      */
/*   nSibling - reference to the next sibling of the node                     */
/*   pSibling - reference to the previous sibling of the node                 */
/*                                                                            */
/* Instance Variables: 														  */
/*   root - the root of the tree						                  	  */
/*   dataNodeMap - an HashMap for the node and data stored in the node        */
/*                                                                            */
/* Constructors:															  */
/*   MultiwayTree()                                                        	  */
/*   MultiwayTree(Node newRoot)                                               */
/*   MultiwayTree(MultiwayTree<T> otherTree)                                  */
/*                                                                            */
/* Methods:                                                                   */
/*   addNode(Node node)     - Adds the specified node to the tree             */
/*   preorderTraversal()    - Traversal the tree in preorder                  */
/*   preorderTraversal(Node node, int depth, StringBuffer buff)               */
/*                          - recursive helper method for public              */
/*                            preorderTraversal                               */
/*   path(T t1, T t2)       - Find the path from node which contains data t1  */
/*                            to the node which contains data t2              */
/*   pathToRoot(T t)    	- Finds the path from node which has the same     */
/*                            value of data t to the root         			  */
/*   findNode(T t)          - Return the node that has the same value of      */
/*                            data t						  				  */
/*   evert(T t)             - Reorganizes the tree to make t as the new root  */
/*                            of the tree        					 		  */
/*   cut(Node node)         - Cuts the node and its associated subtree out of */
/*                            a tree by deleting the link to its parent in    */
/*                            the multiway tree					  			  */
/*   link(Node n1, Node n2)	- Links n2 as n1's child                          */
/******************************************************************************/
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Set;

public class MultiwayTree<T extends Comparable<T>> {

	protected Node root;
	protected HashMap<T, Node> dataNodeMap = new HashMap<T, Node>();

	public void printRoot() {
		System.out.println(root);
		System.out.println(root.fChild);
		System.out.println(root.fChild.nSibling);
	}

	class Node implements Comparable {
		T data;
		double key;
		Node parent;
		Node fChild;
		Node nSibling;
		Node pSibling;

		Node(T data, double key, Node parent) {
			this.data = data;
			this.key = key;
		}

		public int compareTo(Object anotherNode) {
			if (key > ((Node) anotherNode).key)
				return 1;
			else if (key < ((Node) anotherNode).key)
				return -1;
			else
				return 0;
		}

		/**
		 * Returns a string representing the node
		 */
		public String toString() {
			return data.toString();
		}

	}

	public MultiwayTree() {
		root = null;
	}

	public MultiwayTree(Node newRoot) {

		this.root = newRoot;
	}

	public MultiwayTree(MultiwayTree<T> otherTree) {
		this.root = otherTree.root;
	}

	/**
	 * Adds the specified node to the tree Either the parent of the node is
	 * specified or the tree is empty
	 * 
	 * @param node
	 * @return
	 */
	protected boolean addNode(Node node) {
		// add node as root of the tree
		if (root == null) {
			root = node;
			return true;
		}
		// add node to its parent
		else if (node.parent != null) {
			// add node as the first child of its parent
			if (node.parent.fChild == null) {
				node.parent.fChild = node;
			}
			// add node as the one of child to the right place
			// so that all children are listed in increasing order
			else {
				Node child = node.parent.fChild;
				while (child.data.compareTo(node.data) < 0
						&& child.nSibling != null) {

					child = child.nSibling;
				}
				// insert after child
				if (child.data.compareTo(node.data) < 0) {
					if (child.nSibling != null) {
						child.nSibling.pSibling = node;
					}
					node.nSibling = child.nSibling;
					node.pSibling = child;
					child.nSibling = node;
				}
				// insert before child
				else {
					if (child.pSibling != null) {
						node.pSibling = child.pSibling;
						child.pSibling.nSibling = node;
					} else {
						child.parent.fChild = node;
					}
					child.pSibling = node;
					node.nSibling = child;
				}
			}
			return true;
		}
		// don't know where to add the node
		else {
			return false;
		}
	}

	/**
	 * Traversal the tree in preorder
	 * 
	 * @return
	 */
	public String preorderTraversal() {
		StringBuffer buffer = new StringBuffer();
		return preorderTraversal(root, 0, buffer);
	}

	/**
	 * recursive helper method for public preorderTraversal
	 * 
	 * @param node
	 * @param depth
	 * @param buff
	 * @return
	 */
	private String preorderTraversal(Node node, int depth, StringBuffer buff) {
		for (int i = 0; i < depth; i++) {
			buff.append(". ");
		}
		buff.append(node);
		buff.append("\n");
		if (node.fChild != null) {
			preorderTraversal(node.fChild, depth + 1, buff);
		}
		if (node.nSibling != null) {
			preorderTraversal(node.nSibling, depth, buff);
		}
		return buff.toString();
	}

	/**
	 * Find the path from node which contains data t1 to the node which contains
	 * data t2
	 * 
	 * @param t1
	 * @param t2
	 * @return
	 */
	public ArrayList<T> path(T t1, T t2) {
		ArrayList<T> source = pathToRoot(t1);
		ArrayList<T> target = pathToRoot(t2);
		if(source == null){
			System.out.println("Can not find node " + t1);
			return null;
		}
		if(target == null){
			System.out.println("Can not find node " + t2);
			return null;
		}
		int i = source.size() - 1;
		int j = target.size() - 1;
		while (i > 0 && j > 0 && source.get(i - 1) == target.get(j - 1)) {
			i--;
			j--;
		}

		ArrayList<T> path = new ArrayList<T>();
		for (int k = 0; k < i; k++) {
			path.add(source.get(k));
		}
		for (int k = j; k >= 0; k--) {
			path.add(target.get(k));
		}
		return path;
	}

	/**
	 * Finds the path from node which has the same value of data t to the root
	 * 
	 * @param data
	 * @return
	 */
	public ArrayList<T> pathToRoot(T t) {
		Node node = findNode(t);
		ArrayList<T> path = new ArrayList<T>();
		if (node != null) {
			path.add(node.data);
			while (node.parent != null) {
				node = node.parent;
				path.add(node.data);
			}
			return path;
		} else
			return null;

	}

	/**
	 * return the node that has the same value of data t
	 * 
	 * @param t
	 * @return
	 */
	private Node findNode(T t) {

		Set<T> keys = dataNodeMap.keySet();
		for (T key : keys) {
			if (key.equals(t))
				return dataNodeMap.get(key);
		}
		return null;
	}

	/**
	 * Reorganizes the tree to make t as the new root of the tree
	 * 
	 * @param t
	 */
	public void evert(T t) {

		Node newRoot = findNode(t);
		if (newRoot != null) {
			while (root != newRoot) {
				cut(newRoot);
			}
		}

	}

	/**
	 * Cuts the node and its associated subtree out of a tree by deleting the
	 * link to its parent in the multiway tree
	 * 
	 * @param node
	 */
	protected void cut(Node node) {
		if (node.parent.parent == null) {
			// cut branch is in the middle
			if (node.pSibling != null && node.nSibling != null) {
				node.pSibling.nSibling = node.nSibling;
				node.nSibling.pSibling = node.pSibling;
			}
			// cut branch is the right most branch
			else if (node.pSibling != null) {
				node.pSibling.nSibling = node.nSibling;
			}
			// cut branch is the left most branch
			else if (node.nSibling != null) {
				node.parent.fChild = node.nSibling;
				node.nSibling.pSibling = node.pSibling;
			}
			// cut branch is the only child
			else {
				node.parent.fChild = null;
			}
			link(node, node.parent);
			node.parent = null;
			node.pSibling = null;
			node.nSibling = null;

			root = node;
		} else {
			cut(node.parent);
		}
	}

	/**
	 * Links n2 as n1's child
	 * 
	 * @param n1
	 * @param n2
	 */
	protected void link(Node n1, Node n2) {
		n2.parent = n1;
		addNode(n2);

	}

}
