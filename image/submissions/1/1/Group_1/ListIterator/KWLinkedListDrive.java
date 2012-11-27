import java.util.*;

public class KWLinkedListDrive {

	public static void main (String x[]){
	
		KWLinkedList <Integer> kwl = new KWLinkedList();
				
		
		
		kwl.addFirst(1);
		kwl.addFirst(2);
		kwl.addLast(6);
		kwl.addFirst(4);
		kwl.add(5);
		kwl.add(8);
	
		ListIterator <Integer> ll = kwl.listIterator();

		//removing the node '4'
		ll.next();
		ll.remove();
		System.out.println("After remove '4': " + kwl);
		
		ll.next();
		ll.next();
		ll.set(99);
		
		System.out.println("After set: " + kwl);
		
		System.out.println("This will give me index of '6': " + kwl.indexOf(6));
		System.out.println("This will give me index of 'sdf' (does not exist): " + kwl.indexOf(100));
		

		System.out.println("maxIndexOf: " + maxIndexOf(kwl));
		
		
		java.util.LinkedList <Integer> l = new java.util.LinkedList();
		
		l.add(23);
		l.add(24);
		l.add(2);
		l.add(56);
		
		
		java.util.LinkedList <Integer> p = new java.util.LinkedList();
		
		p.add(0);
		p.add(3);
		
		System.out.println("Will give me the results of printPositions: ");
		kwl.printPositions(l,p);
		
	
	
	}
	
	
	//returns the index of the highest int value on myList
	public static int maxIndexOf(KWLinkedList myList){
	
	
		int max = 0; //int var to store the max value
		
		for (int i = 0; i < myList.size(); i++){
			
			int temp = (int)myList.get(i);
		
			max = (temp > max) ? temp : max;
		
		}
		
		return myList.indexOf(max);
	
	}
	


}