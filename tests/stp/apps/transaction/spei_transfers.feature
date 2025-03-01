# language: es
Característica: Realizar Transferencia SPEI por STP
  Yo como administrador de STP o Administrador de empresar
  Quiero realiar transferenciar
  Para transferir saldo a otras cuentas ya sea internas o exeternas

#  Antecedentes:
#    Dado que se ingresa con el usuario "ajimmenezz+001@gmail.com"
#
#  Escenario: Empresa a otra empresa interna (operacion externa)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia de empresa a otra empresa interna (operacion externa)",
#      "internalTransaction": false
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Empresa a una cuenta externa (operacion externa)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "014180568246636592",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia empresa a una cuenta externa (operacion externa)",
#      "internalTransaction": false
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Concentradora a una cuenta externa (operacion externa)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700000002",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "014180568246636592",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia concentradora a una cuenta externa (operacion externa)",
#      "internalTransaction": false
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Concentradora a una empresa (operacion externa)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700000002",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia concentradora a una empresa (operacion externa)",
#      "internalTransaction": false
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Empresa a varias cuentas (operacion externa)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#            "bankAccount": "014180568246636592",
#            "amount": 1
#          },
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia de empresa a varias cuentas (operacion externa)",
#      "internalTransaction": false
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Empresa a otra empresa interna (operacion interna)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia de empresa a otra empresa interna (operacion interna)",
#      "internalTransaction": true
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Concentradora a una empresa (operacion interna)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700000002",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia concentradora a empresa (operacion interna)",
#      "internalTransaction": true
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Empresa a un concentradora (operacion interna)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#              "bankAccount": "646180527700000002",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia empresa a concentradora (operacion interna)",
#      "internalTransaction": true
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
#
#  Escenario: Empresa a varias empresas (operacion interna)
#    Dado envio una solicitud "POST" a "/api/spei/transaction/process-payments" con datos:
#    """
#    {
#      "originBankAccount": "646180527700001043",
#      "destinationsAccounts": [
#          {
#            "bankAccount": "646180527700001056",
#            "amount": 1
#          },
#          {
#              "bankAccount": "646180527700001030",
#              "amount": 1
#          }
#      ],
#      "concept": "Transferencia de empresa a varias empresas (operacion interna)",
#      "internalTransaction": true
#    }
#    """
#    Entonces el codigo de estado de respuesta debe ser "200"
