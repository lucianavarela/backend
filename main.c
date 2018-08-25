#include <stdio.h>
#include <stdlib.h>

int main()
{
    int edad, i;
    int seguir = 1;

    /*for(i=0; i<3; i++)
    {
        printf("Ingrese su edad:");
        scanf("%d",&edad);
        printf("Su edad es: %d",edad);
    }*/
    i=0;

    while(i<10 || seguir)
    {
        printf("Ingrese su edad:");
        scanf("%d",&edad);
        printf("Su edad es: %d",edad);
        i++
    }

    return 0;
}