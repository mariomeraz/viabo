import { Navigate } from 'react-router-dom'

const ViaboSpeiRouter = {
  path: 'viabo-spei',
  children: [
    { index: true, path: 'viabo-spei', element: <Navigate to="/404" /> },
    {
      path: 'dashboard',
      async lazy() {
        const { AdminDashboardViaboSpei } = await import('../../dashboard/pages/AdminDashboardViaboSpei')
        return { Component: AdminDashboardViaboSpei }
      }
    },
    {
      path: 'third-accounts',
      async lazy() {
        const { SpeiThirdAccounts } = await import('../../third-accounts/pages/SpeiThirdAccounts')
        return { Component: SpeiThirdAccounts }
      }
    },
    {
      path: 'companies',
      async lazy() {
        const { ViaboSpeiCompanies } = await import('../../companies/pages/ViaboSpeiCompanies')
        return { Component: ViaboSpeiCompanies }
      }
    },
    {
      path: 'cost-centers',
      async lazy() {
        const { ViaboSpeiCostCenters } = await import('../../cost-centers/pages/ViaboSpeiCostCenters')
        return { Component: ViaboSpeiCostCenters }
      }
    }
  ]
}

export default ViaboSpeiRouter
