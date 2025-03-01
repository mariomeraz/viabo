# language: es
#Característica: Baja de Cuenta de Tercero
#  Yo como Administrador STP o Administrador de Empresa
#  Quiero dar de baja una cuenta de terceros
#  Para evitar transferir fondos a una cuenta con datos incorrectos.
#
#  Antecedentes:
#    Dado que se ingresa con el usuario "ramses@itravel.mx"
#
#  Escenario: baja de cuenta
#    Dado Envio una solicitud "PUT" a "/api/spei/external-account/disable" con datos:
#    """
#    {
#      "externalAccountId":"2",
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
