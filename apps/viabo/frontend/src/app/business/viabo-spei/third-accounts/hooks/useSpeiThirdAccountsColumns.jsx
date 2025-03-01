import { useMemo } from 'react'

import { Typography } from '@mui/material'

export const useSpeiThirdAccountsColumns = () =>
  useMemo(
    () => [
      {
        id: 'name',
        accessorKey: 'name',
        header: 'Beneficiario',
        enableHiding: false,
        size: 150,
        Cell: ({ cell, column, row, renderedCellValue }) => (
          <Typography fontWeight={'bold'} variant="subtitle2">
            {renderedCellValue}
          </Typography>
        )
      },
      {
        id: 'clabe',
        accessorKey: 'clabe',
        header: 'CLABE',
        Cell: ({ cell, column, row, renderedCellValue }) => {
          const { original: rowData } = row
          return <Typography variant="subtitle2">{renderedCellValue}</Typography>
        }
      },
      {
        id: 'bank',
        header: 'Banco',
        accessorFn: originalRow => originalRow?.bank?.name || null,
        Cell: ({ cell, column, row, renderedCellValue }) => {
          const { original: rowData } = row

          return <Typography variant="subtitle2">{rowData?.bank.name}</Typography>
        }
      },
      {
        id: 'email',
        accessorKey: 'email',
        header: 'Correo',
        minSize: 100,
        Cell: ({ cell, column, row, renderedCellValue }) => {
          const { original: rowData } = row
          return <Typography variant="subtitle2">{renderedCellValue}</Typography>
        }
      },
      {
        id: 'phone',
        accessorKey: 'phone',
        header: 'Teléfono',
        Cell: ({ cell, column, row, renderedCellValue }) => {
          const { original: rowData } = row
          return <Typography variant="subtitle2">{renderedCellValue}</Typography>
        }
      }
    ],
    []
  )
