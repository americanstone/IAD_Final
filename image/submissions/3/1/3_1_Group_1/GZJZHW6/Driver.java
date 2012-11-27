/******************************************************************************/
/*                                                                            */
/* Driver.java                                                                */
/*                                                                            */
/* Group: Guojun Zhang, Jing Zhao                                             */
/* Date: Apr. 27, 2012                                              		  */
/* Course: CSC551                                                             */
/* Homework: HW6                                                              */
/*                                                                            */
/* A class that is used to test Minimum Spanning Tree						  */
/*                                                                            */
/* Methods:                                                                   */
/*   executeCMD(String[] cmd, MST mst) - Executes command against mst         */
/*   main(String[] arg)	 			   -                                       */
/******************************************************************************/
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

public class Driver {

	public static void main(String[] arg) throws FileNotFoundException {
		if (arg.length < 1) {
			System.out
					.println("Usage: java Driver test1.in, where test1.in is your test input file");
			System.exit(-1);
		}

		File input = new File(arg[0]);
		Scanner sc = new Scanner(input);
		// generates graph
		Graph g = Graph.createGraph(sc);
		// generate mst
		MST mst = MST.generateMST(g);

		// execute commands
		String line = null;
		while ((line = sc.nextLine()) != null) {

			if (line.startsWith("print-mst") || line.startsWith("path")
					|| line.startsWith("quit")) {
				String delims = "[ ]+";
				String[] cmd = line.split(delims);
				System.out.println(line);
				executeCMD(cmd, mst);
			}
		}

	}

	/**
	 * Executes command against mst
	 * 
	 * @param cmd
	 * @param mst
	 */
	public static void executeCMD(String[] cmd, MST mst) {
		if (cmd[0].equals("print-mst")) {
			mst.evert(new Vertex(cmd[1]));
			String traversal = mst.preorderTraversal();
			System.out.println(traversal);
		} else if (cmd[0].equals("path")) {
			Vertex v1 = new Vertex(cmd[1]);
			Vertex v2 = new Vertex(cmd[2]);
			ArrayList<Vertex> path = mst.path(v1, v2);
			if (path != null) {
				for (Vertex v : path) {
					System.out.print(v + " ");
				}
				System.out.println();
			}
		} else if (cmd[0].equals("quit")) {
			System.exit(0);
		}

	}

}
