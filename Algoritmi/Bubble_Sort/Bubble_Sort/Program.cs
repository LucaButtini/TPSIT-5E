using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Bubble_Sort
{
    internal class Program
    {
        static void Main(string[] args)
        {
            int[] array = Populate(25, -14, 500);

            Console.WriteLine("Original array");
            PrintArray(array);

            BubbleSort(array);

            Console.WriteLine("\nOrdered array");
            PrintArray(array);

            Console.ReadLine();
        }

        static void BubbleSort(int[] arr)
        {
            int dim = arr.Length, temp;
            for (int i = 0; i < dim - 1; i++)
            {
                for (int j = 0; j < dim - 1 - i; j++)
                {
                    if(arr[j] > arr[j+1])
                    {
                        temp = arr[j];
                        arr[j] = arr[j + 1];
                        arr[j + 1] = temp;
                    }

                }
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
