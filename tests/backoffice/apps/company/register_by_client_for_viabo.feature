# language: es
Característica: Registro de empresa por el cliente
  Yo como cliente
  Quiero registrame en el sistema viabo
  Para poder utilizar los servicios que ofrece la plataforma

#  Antecedentes:
#    Dado verifico al usuario "fpalma@siccob.com.mx"

  Escenario: Registrando el administrador de comercio
    Dado que el usuario "fpalma@siccob.com.mx" no existe
    Dado envio una solicitud "POST" a "/api/security/legalRepresentative/new" con datos:
    """
    {
        "name": "Alex",
        "lastname": "P",
        "phone": "+52 55 5555 55",
        "email": "fpalma@siccob.com.mx",
        "password": "Test-123",
        "confirmPassword": "Test-123"
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Validar usuario para continuar con Proceso de registro
    Dado verifico al usuario "fpalma@siccob.com.mx"
    Dado envio una solicitud "GET" a "/api/commerce/legal-representative"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Seleccionando servicios para la empresa (Paso 2)
    Dado verifico al usuario "fpalma@siccob.com.mx"
    Dado envio una solicitud "PUT" a "/api/commerce/update" con datos:
    """
    {
      "commerceId": "da6524f0-c681-45c8-af4f-eaa78091225d",
      "fiscalPersonType": "1",
      "fiscalName": "Mulsum",
      "tradeName": "Mulsum",
      "rfc": "",
      "employees": 0,
      "branchOffices": 0,
      "pointSaleTerminal": 0,
      "paymentApi": 0,
      "registerStep": 2,
      "services": [
          {
              "type": "2",
              "cardNumbers": "0",
              "cardUse": "",
              "personalized": "0"
          }
      ]
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Estableciendo datos de la empresa (Paso 3)
    Dado verifico al usuario "fpalma@siccob.com.mx"
    Dado envio una solicitud "PUT" a "/api/commerce/update" con datos:
    """
    {
        "commerceId": "da6524f0-c681-45c8-af4f-eaa78091225d",
        "fiscalPersonType": "1",
        "fiscalName": "Mulsum",
        "tradeName": "Mulsum",
        "rfc": "TT",
        "employees": 4,
        "branchOffices": 1,
        "pointSaleTerminal": 1,
        "paymentApi": "0",
        "registerStep": 3,
        "services": [
            {
                "id": "5741f23c-bf16-4216-8b12-a745ec0cbedf",
                "type": "2",
                "companyId": "da6524f0-c681-45c8-af4f-eaa78091225d",
                "employees": "",
                "branchOffices": "",
                "numbers": "",
                "purpose": "",
                "personalized": "0",
                "allowTransactions": "1",
                "active": "1",
                "cardNumbers": "4",
                "cardUse": "Otro",
                "stpAccountId": ""
            }
        ]
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"