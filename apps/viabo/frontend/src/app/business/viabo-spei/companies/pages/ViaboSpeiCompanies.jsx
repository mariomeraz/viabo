import { lazy } from 'react'

import { useViaboSpeiBreadCrumbs } from '../../shared/hooks'
import { ViaboSpeiCompaniesList } from '../components/ViaboSpeiCompaniesList'

import { Page } from '@/shared/components/containers'
import { ContainerPage } from '@/shared/components/containers/ContainerPage'
import { HeaderPage } from '@/shared/components/layout'
import { Lodable } from '@/shared/components/lodables'

const SpeiNewCompanyDrawer = Lodable(lazy(() => import('../components/new-company/SpeiNewCompanyDrawer')))

export const ViaboSpeiCompanies = () => {
  const { companies } = useViaboSpeiBreadCrumbs()

  return (
    <Page title="Empresas - Viabo Spei">
      <ContainerPage sx={{ pb: 3 }}>
        <HeaderPage name={'Empresas'} links={companies} />
        <ViaboSpeiCompaniesList />
        <SpeiNewCompanyDrawer />
      </ContainerPage>
    </Page>
  )
}
