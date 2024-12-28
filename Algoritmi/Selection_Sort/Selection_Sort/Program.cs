using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Selection_Sort
{
    internal class Program
    {
        static void Main(string[] args)
        {
            int[] array = Populate(25, -14, 500);

            Console.WriteLine("Original array:");
            PrintArray(array);

            SelectionSort(array);

            Console.WriteLine("\nOrdered array:");
            PrintArray(array);

            Console.ReadLine();
        }

        static void SelectionSort(int[] arr)
        {
            int len = arr.Length, minIndex, temp;

            for (int i = 0; i < len - 1; i++)
            {
                minIndex = i;

                for (int j = i + 1; j < len; j++)
                {
                    if (arr[j] < arr[minIndex])
                    {
                        minIndex = j;
                    }
                }

                if (minIndex != i)
                {
                    temp = arr[minIndex];
                    arr[minIndex] = arr[i];
                    arr[i] = temp;
                }
            }
        }
        static int[] Populate(int len, int min, int max)
        {
            Random rnd = new Random();
            int[] arr = new int[len];
            for (int i = 0; i < len; i++)
            {
                arr[i] = rnd.Next(min, max + 1);
            }
            return arr;
        }

        static void PrintArray(int[] arr)
        {
            for (int i = 0; i < arr.Length; i++)
            {
                Console.WriteLine($"[{i} -> {arr[i]}]");
            }
        }
    }
}
