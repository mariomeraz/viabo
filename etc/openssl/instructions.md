# Openssl
Para generar los archivos private.pem y public.pem

Ejecutar en una consola los siguientes comandos:

 - Crear primero la el archivo private.pem con el siguiente comando:
   openssl genrsa -aes256 -out private.pem 2048
   
    La cable que se solicita debe ser igual la que esta
    en el archivo .env en la variable JWT_PASSPHRASE
- Hora crear el archivo public.pem con el siguiente comando:
  openssl rsa -pubout -in private.pem -out public.pem
 
  Donde debera ingresar la misma clave de JWT_PASSPHRASE