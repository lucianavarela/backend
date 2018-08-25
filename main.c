#include <stdio.h>
#include <stdlib.h>

int main()
{
    int edad, i;
    int seguir = 1;

    
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
