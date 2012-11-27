/******************************************************************************/
/*                                                                            */
/*SorterDriver.java                                                           */
/*                                                                            */
/* Author: Jing Zhao                                              			  */
/* Date: Feb. 23, 2012                                             		   	  */
/* Course: CSC 551                                                            */
/* Homework: HW3                                                              */
/*                                                                            */
/* A class that is used as test driver of Sorter class         				  */
/*                                                                            */
/* Instance Variables: 														  */
/*   directory - the directory in which image files are stored                */
/*   pageNumber - the page numbers in the XML file  	  					  */
/*   pages - an WebPage array to store informations of WebPage 				  */
/*                                                                            */
/* Methods:                                                                   */
/*   genRandom(int size, int lowerBorder, int upperBorder)                    */
/*                    - returns an array which has the 'size' numbers of      */
/*                      random integers in the range of lowerBorder and  	  */
/*                      upperBorder                           				  */
/*   testSort(String methodName, int[] data)                                  */
/*                    - sorts array 'data' using different sorting methods in */
/*                      Sorter class using java reflection    				  */
/*   main(String[] args)                          							  */
/******************************************************************************/
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.Random;

public class SorterDriver {

	/**
	 * returns an array which has the 'size' numbers of random integers in 
	 * the range of lowerBorder and upperBorder
	 * 
	 * @param size
	 * @param lowerBorder
	 * @param upperBorder
	 */
	private static int[] genRandom(int size, int lowerBorder, int upperBorder) {
		int data[] = new int[size];
		Random gen = new Random();
		for (int i = 0; i < data.length; i++) {
			data[i] = gen.nextInt(upperBorder - lowerBorder + 1) + lowerBorder;
		}
		return data;
	}

	/**
	 * main method
	 * 
	 * @param args
	 */
	public static void main(String[] args) {
		// generates an array which is randomly filled with integers
		int[] origData1 = genRandom(10000, 0, 10000);
		int[] origData2 = genRandom(20000, 0, 10000);
		int[] origData3 = genRandom(40000, 0, 10000);

		try {
			// tests insertion sort
			System.out.println("Version 1 - Insertion Sort: " +
					"Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case     " +
					"Worst-Case     Average-Case");
			testSort("insertionSort", origData1);
			testSort("insertionSort", origData2);
			testSort("insertionSort", origData3);			
			System.out.println();
			
			// tests standard merge sort
			System.out.println("Version 2 - Standard Merge Sort: " +
					"Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case     " +
					"Worst-Case     Average-Case");
			testSort("standardMergeSort", origData1);
			testSort("standardMergeSort", origData2);
			testSort("standardMergeSort", origData3);			
			System.out.println();
			
			// tests modified merge sort which combines with 
			// insertion sort when subarray is less than 15
			System.out.println("Version 3 - Merge Sort for subarrray " +
					"greater than 15, Insertion Sort for subarray less " +
					"than 15: Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case     " +
					"Worst-Case     Average-Case");
			testSort("advancedMergeSort15", origData1);
			testSort("advancedMergeSort15", origData2);
			testSort("advancedMergeSort15", origData3);			
			System.out.println();
			
			// tests modified merge sort which combines with 
			// insertion sort when subarray is less than 30
			System.out.println("Version 4 - Merge Sort for subarrray " +
					"greater than 30, Insertion Sort for subarray less" +
					" than 30: Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case     " +
					"Worst-Case     Average-Case");
			testSort("advancedMergeSort30", origData1);			
			testSort("advancedMergeSort30", origData2);
			testSort("advancedMergeSort30", origData3);		
			System.out.println();
			
			// tests modified merge sort which combines with 
			// insertion sort when subarray is less than 45
			System.out.println("Version 5 - Merge Sort for subarrray" +
					" greater than 45, Insertion Sort for subarray less" +
					" than 45: Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case     " +
					"Worst-Case     Average-Case");
			testSort("advancedMergeSort45", origData1);
			testSort("advancedMergeSort45", origData2);
			testSort("advancedMergeSort45", origData3);
			System.out.println();
			
			// tests quick sort
			System.out.println("Version 6 - Quick Sort: " +
					"Run-Times over 50 test runs");
			System.out.println("Input Size     Best-Case    " +
					" Worst-Case     Average-Case");
			testSort("quickSort", origData1);
			testSort("quickSort", origData2);
			testSort("quickSort", origData3);
		} catch (SecurityException e) {
			e.printStackTrace();
		} catch (IllegalArgumentException e) {
			e.printStackTrace();
		} catch (NoSuchMethodException e) {
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			e.printStackTrace();
		} catch (InvocationTargetException e) {
			e.printStackTrace();
		}
	}

	/**
	 * sorts array 'data' using different sorting methods in Sorter class 
	 * using java reflection 
	 * @param methodName
	 * @param data
	 * @throws SecurityException
	 * @throws NoSuchMethodException
	 * @throws IllegalArgumentException
	 * @throws IllegalAccessException
	 * @throws InvocationTargetException
	 */
	public static void testSort(String methodName, int[] data)
			throws SecurityException, NoSuchMethodException,
			IllegalArgumentException, IllegalAccessException,
			InvocationTargetException {
		
		int[] workData = new int[data.length];

		Method method = Sorter.class.getDeclaredMethod(methodName, int[].class);
		long start, end, runtime;
		double bestRuntime = Double.MAX_VALUE;
		double worstRuntime = Double.MIN_VALUE;
		double total = 0;
		double average;

		for (int i = 1; i <= 50; i++) {

			// copy all of the elements in origData into workData
			System.arraycopy(data, 0, workData, 0, data.length);
			start = System.currentTimeMillis();
			method.invoke(method, workData);
			end = System.currentTimeMillis();
			runtime = end - start;
			total += runtime;
			if (bestRuntime > runtime) {
				bestRuntime = runtime;
			}
			if (worstRuntime < runtime) {
				worstRuntime = runtime;
			}
		}
		average = total / 50;
		System.out.println("N = " + data.length + "\t" + bestRuntime + "\t\t"
				+ worstRuntime + "\t\t" + average);
	}

}
