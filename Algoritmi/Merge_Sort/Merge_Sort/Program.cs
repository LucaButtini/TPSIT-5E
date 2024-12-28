using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Merge_Sort
{
    internal class Program
    {
        static void Main(string[] args)
        {
            int[] array = Populate(25, -14, 500);

            Console.WriteLine("Original array:");
            PrintArray(array);

            MergeSort(array, 0, array.Length - 1);

            Console.WriteLine("\nOrdered array:");
            PrintArray(array);

            Console.ReadLine();
        }

        static void MergeSort(int[] array, int left, int right)
        {
            if (left < right)
            {
                int mid = (left + right) / 2;

                MergeSort(array, left, mid);
                MergeSort(array, mid + 1, right);

                Merge(array, left, mid, right);
            }
        }

        static void Merge(int[] array, int left, int mid, int right)
        {
            int n1 = mid - left + 1, n2 = right - mid;

            int[] leftArray = new int[n1], rightArray = new int[n2];

            for (int i = 0; i < n1; i++)
            {
                leftArray[i] = array[left + i];
            }
            for (int i = 0; i < n2; i++)
            {
                rightArray[i] = array[mid + 1 + i];
            }

            int iLeft = 0, iRight = 0, k = left;

            while (iLeft < n1 && iRight < n2)
            {
                if (leftArray[iLeft] <= rightArray[iRight])
                {
                    array[k] = leftArray[iLeft];
                    iLeft++;
                }
                else
                {
                    array[k] = rightArray[iRight];
                    iRight++;
                }
                k++;
            }

            while (iLeft < n1)
            {
                array[k] = leftArray[iLeft];
                iLeft++;
                k++;
            }

            while (iRight < n2)
            {
                array[k] = rightArray[iRight];
                iRight++;
                k++;
            }
        }

        static int[] Populate(int len, int min, int max)
        {
            Random random = new Random();

            int[] array = new int[len];

            for (int i = 0; i < len; i++)
            {
                array[i] = random.Next(min, max + 1);
            }
            return array;
        }

        static void PrintArray(int[] arr)
        {
            for (int i = 0; i < arr.Length; i++)
            {
                Console.WriteLine($"[{i}] -> {arr[i]}");
            }
        }


    }
}
