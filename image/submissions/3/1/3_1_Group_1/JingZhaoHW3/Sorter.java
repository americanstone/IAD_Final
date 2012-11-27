/******************************************************************************/
/*                                                                            */
/*Sorter.java                                         		                  */
/*                                                                            */
/* Author: Jing Zhao                                              			  */
/* Date: Feb. 23, 2012                                             		   	  */
/* Course: CSC 551                                                            */
/* Homework: HW3                                                              */
/*                                                                            */
/* A class that has sorting methods including insertion sorting, quick sorting*/
/* merge sorting, modified merge sorting which is a combination of merge      */
/* sorting and insertion sorting											  */
/*                                                                            */
/* public Methods: 															  */
/*   insertionSort(int[] data) 												  */
/*            - sorts the array using insertion sorting     				  */
/*   standardMergeSort(int[] data) 											  */
/*                    - sorts the array 'data' using merge sorting  	  	  */
/*   advancedMergeSort15(int[] data)				 					      */
/*            - sorts the array 'data' using merge sorting when the subarray  */
/* 			    has more than 15 elements while using insertion sorting when  */
/*              thesubarray has less than or equal to 15 elements             */
/*   advancedMergeSort30(int[] data)				 					      */
/*            - sorts the array 'data' using merge sorting when the subarray  */
/* 			    has more than 30 elements while using insertion sorting when  */
/*              thesubarray has less than or equal to 30 elements             */
/*   advancedMergeSort45(int[] data)				 					      */
/*            - sorts the array 'data' using merge sorting when the subarray  */
/* 			    has more than 45 elements while using insertion sorting when  */
/*              thesubarray has less than or equal to 45 elements             */
/*   quickSort(int[] data)                                                    */
/*            - sorts the array using quick sorting                           */
/*                                                                            */
/* Methods:                                                                   */
/*   insertionSort(int[] data, int first, int last)                 		  */
/*             -sorts the array from index of first to last using insertion   */
/*              sorting          											  */
/*   mergeSort(int[] data, int first, int last, int stopAt) 	 			  */
/*             -sorts the array using merge sorting when the subarray has more*/ 
/*              than 'stopAt' numbers of elements while using insertion       */
/* 				sorting when the subarray has less than or equal to 'stopAt'  */
/*              numbers of elements                         				  */
/*   merge(int[] data, int first, int mid, int last)                          */
/*             -merges two sorted array data[first...mid] and data[mid+1.last]*/
/* 				into one sorted array										  */
/*   quickSort(int[] data, int first, int last)          	  				  */
/*             -sorts the array from index first to index last using quick    */
/*              sorting														  */
/*   partition(int[] data, int first, int last)                        		  */
/*             - partitioning the array to make the elements that are less    */
/*               than or equal to the pivot are stored before the pivot and   */
/*          	 the elements that are greater than the pivot are stored after*/
/*               the pivot                                                    */
/*   findMedian(int data[], int first, int last)							  */
/*             -examines the values of data[first], data[mid] and data[last], */
/*              selects the median and returns index of the median			  */
/******************************************************************************/

public class Sorter {

	/**
	 * sorts the array using insertion sorting
	 * 
	 * @param data
	 */
	public static void insertionSort(int[] data) {
		insertionSort(data, 0, data.length - 1);
		
	}
	
	/**
	 * sorts the array from index of first to last using insertion sorting
	 * @param data
	 * @param first
	 * @param last
	 */
	private static void insertionSort(int[] data, int first, int last){
		
		for (int i = first + 1; i <= last; i++) {
			int nextValue = data[i];
			int j = i - 1;
			while (j >= first && (data[j] > nextValue)) {
				data[j + 1] = data[j];
				j--;
			}
			data[j + 1] = nextValue;
		}
	}

	/**
	 * sorts the array 'data' using merge sorting
	 * @param data
	 */
	public static void standardMergeSort(int[] data) {
		mergeSort(data, 0, data.length - 1, 0);

	}

	/**
	 * sorts the array 'data' using merge sorting when the subarray has
	 *  more than 15 elements while using insertion sorting when the
	 * subarray has less than or equal to 15 elements
	 * @param data
	 */
	public static void advancedMergeSort15(int[] data) {
		mergeSort(data, 0, data.length - 1, 15);
	}
	
	/**
	 * sorts the array 'data' using merge sorting when the subarray has
	 *  more than 30 elements while using insertion sorting when the
	 * subarray has less than or equal to 30 elements
	 * @param data
	 */
	public static void advancedMergeSort30(int[] data){
		mergeSort(data, 0, data.length - 1, 30);
	}

	/**
	 * sorts the array 'data' using merge sorting when the subarray has
	 *  more than 45 elements while using insertion sorting when the
	 * subarray has less than or equal to 45 elements
	 * @param data
	 */
	public static void advancedMergeSort45(int[] data){
		mergeSort(data, 0, data.length - 1, 45);
	}
	
	/**
	 * sorts the array using merge sorting when the subarray has more than 
	 * 'stopAt' numbers of elements while using insertion sorting when the
	 * subarray has less than or equal to 'stopAt' numbers of elements
	 * @param data
	 * @param first
	 * @param last
	 * @param stopAt
	 */
	private static void mergeSort(int[] data, int first, int last, int stopAt) {
		if ((last - first) > stopAt) {
			int mid = (first + last) / 2;
			mergeSort(data, first, mid, stopAt);
			mergeSort(data, mid + 1, last, stopAt);
			merge(data, first, mid, last);
		}
		else if((last - first) >= 2 && (last - first) <= stopAt){
			insertionSort(data, first, last);
		}
		
	}

	/**
	 * merges two sorted array data[first...mid] and data[mid+1...last]
	 * into one sorted array
	 * @param data
	 * @param first
	 * @param mid
	 * @param last
	 */
	private static void merge(int[] data, int first, int mid, int last) {
		int[] tmp = new int[last - first + 1];
		int i = first;
		int j = mid + 1;
		int k = 0;
		while (i <= mid && j <= last) {
			if (data[i] <= data[j]) {
				tmp[k++] = data[i++];
			} else {
				tmp[k++] = data[j++];
			}
		}
		while (i <= mid) {
			tmp[k++] = data[i++];
		}
		while (j <= last) {
			tmp[k++] = data[j++];
		}

		// copy the data back to the array 'data'
		i = first;
		k = 0;
		while (i <= last) {
			data[i++] = tmp[k++];
		}
	}
	
	/**
	 * sorts the array using quick sorting
	 * @param data
	 */
	public static void quickSort(int[] data){
		quickSort(data, 0, data.length - 1);
	}
	
	/**
	 * sorts the array from index first to index last 
	 * using quick sorting
	 * @param data
	 * @param first
	 * @param last
	 */
	private static void quickSort(int[] data, int first, int last){
		if(first < last){
			int pIndex = partition(data, first, last);
			quickSort(data, first, pIndex - 1);
			quickSort(data, pIndex + 1, last);
		}
	}
	
	/**
	 * partitioning the array to make the elements that are less than or
	 * equal to the pivot are stored before the pivot and the elements that are 
	 * greater than the pivot are stored after the pivot
	 * @param data
	 * @param first
	 * @param last
	 * @return
	 */	
	private static int partition(int[] data, int first, int last){
		// finds out the median from data[first], data[mid] and data[last] 
		int median = findMedian(data, first, last);
		int tmp;
		// exchange the median value to the first position using as the pivot
		tmp = data[median];
		data[median] = data[first];
		data[first] = tmp;
		// i points to the last element that is less than or equal to the pivot
		int i = first;
		// j points to the first element that is not sorted
		int j = first + 1;
		for(int k = j; k <= last; k++){
			// if the element is less than or equal to the pivot 
			// exchange it with data[i+1] then increase i
			if(data[k] <= data[first]){
				tmp = data[j];
				data[j] = data[i+1];
				data[i+1] = tmp;
				i++;
				j++;
			}else{
				j++;
			}
		}
		tmp = data[i];
		data[i] = data[first];
		data[first] = tmp;
		
		return i;
	}
	
	/**
	 * examines the values of data[first], data[mid] and data[last],
	 * selects the median and returns index of the median
	 * @param data
	 * @param first
	 * @param last
	 * @return
	 */
	private static int findMedian(int data[], int first, int last){
		int mid = (first + last) / 2;
		if(data[first] >= data[mid]){
			if(data[first] < data[last]){
				// last > first > mid
				return first;
			}else{
				if(data[mid] >= data[last]){
					// first > mid > last
					return mid;
				}else{
					// first > last >  mid 
					return last;
				}
			}
		}else{
			if(data[mid] < data[last]){
				// first < mid < last
				return mid;
			}else{
				if(data[first] < data[last]){
					// first < last < mid
					return last;
				}
				else{
					// last < first < mid
					return first;
				}
			}
		}
	}

}
