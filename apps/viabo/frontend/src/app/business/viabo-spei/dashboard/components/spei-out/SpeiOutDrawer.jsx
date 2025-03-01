import { lazy, useEffect, useMemo, useState } from 'react'

import { Stack, ToggleButton, ToggleButtonGroup, Typography } from '@mui/material'
import { m } from 'framer-motion'

import { STP_ACCOUNT_TYPES } from '../../constants'
import { useAdminDashboardSpeiStore } from '../../store'

import { SPEI_OUT_DESTINATION, getSpeiOutOptionByPermissions } from '@/app/business/viabo-spei/shared/permissions'
import { useFindSpeiThirdAccountsList } from '@/app/business/viabo-spei/third-accounts/hooks'
import { RightPanel } from '@/app/shared/components'
import { varFade } from '@/shared/components/animate'
import { RequestLoadingComponent } from '@/shared/components/loadings'
import { Lodable } from '@/shared/components/lodables'
import { ErrorRequestPage, TwoAuthDisabled } from '@/shared/components/notifications'
import { useUser } from '@/shared/hooks'

const SpeiOutForm = Lodable(lazy(() => import('./SpeiOutForm')))
const SpeiOutConcentratorForm = Lodable(lazy(() => import('./SpeiOutConcentratorForm')))
const SpeiOutResume = Lodable(lazy(() => import('./SpeiOutResume')))
const SpeiOutSuccess = Lodable(lazy(() => import('./SpeiOutSuccess')))

const SpeiOutDrawer = () => {
  const { twoAuth, permissions } = useUser()
  const [view, setView] = useState(null)

  const speiOutOptions = useMemo(() => getSpeiOutOptionByPermissions(permissions), [permissions])
  const defaultOption = useMemo(() => speiOutOptions?.find(option => option?.default), [speiOutOptions])

  const isCompaniesView = view === SPEI_OUT_DESTINATION.COMPANIES.id
  const isThirdAccountsView = view === SPEI_OUT_DESTINATION.THIRD_ACCOUNTS.id
  const isConcentratorView = view === SPEI_OUT_DESTINATION.CONCENTRATOR.id

  const { setOpenSpeiOut, openSpeiOut, selectedAccount } = useAdminDashboardSpeiStore()

  const [currentBalance, setCurrentBalance] = useState(0)
  const [transactionForm, setTransactionForm] = useState(null)
  const balance = useMemo(() => selectedAccount?.balance?.number, [selectedAccount?.balance])
  const [showResume, setShowResume] = useState(false)
  const [transactionData, setTransactionData] = useState(null)
  const [successTransaction, setSuccessTransaction] = useState(null)
  const [transactionLoading, setTransactionLoading] = useState(false)

  const {
    data: thirdAccountList,
    isLoading: isLoadingThirdAccountList,
    isError: isErrorThirdAccounts,
    error: errorThirdAccounts,
    refetch: refetchThirdAccounts
  } = useFindSpeiThirdAccountsList({ enabled: !!(openSpeiOut && twoAuth) })

  const companies = useAdminDashboardSpeiStore(state => state.companies)

  const titleTransaction = <Typography variant="h6">SPEI Out</Typography>

  const isLoading = isLoadingThirdAccountList

  const isError = isErrorThirdAccounts
  const error = errorThirdAccounts

  const accounts = useMemo(() => {
    if (isCompaniesView) {
      return companies
    }
    if (isThirdAccountsView) {
      return thirdAccountList
    }
    return []
  }, [view, thirdAccountList, companies])

  const handleClose = () => {
    setOpenSpeiOut(false)
    setCurrentBalance(0)
    setShowResume(false)
    setTransactionData(null)
    setTransactionLoading(false)
    setTransactionForm(null)
    setSuccessTransaction(null)
  }

  const handleSuccessForm = values => {
    let commissions = {
      speiOut: 0,
      internalTransferCompany: 0,
      fee: 0
    }
    let totalAmountCommissions = 0

    setTransactionForm(values)

    const notAdminSTPConcentrators = selectedAccount?.type !== STP_ACCOUNT_TYPES.CONCENTRATOR

    if (isThirdAccountsView && notAdminSTPConcentrators) {
      const percentageSpeiOut = selectedAccount?.commissions?.speiOut || 0
      const amountFee = selectedAccount?.commissions?.fee || 0
      const commissionFee = values?.transactions?.length * amountFee
      const commissionSpeiOut =
        values?.transactions?.reduce((totalCommission, transaction) => {
          const amount = parseFloat(transaction.amount.replace(/,/g, ''))
          totalCommission += amount * (percentageSpeiOut / 100)

          return totalCommission
        }, 0) || 0

      totalAmountCommissions = (commissionFee + commissionSpeiOut).toFixed(2)

      commissions = {
        speiOut: commissionSpeiOut.toFixed(2),
        internalTransferCompany: 0,
        fee: commissionFee.toFixed(2)
      }
    }

    if (isCompaniesView && notAdminSTPConcentrators) {
      const percentageInternalCompany = selectedAccount?.commissions?.internalTransferCompany || 0
      const internalCommissionCompany =
        values?.transactions?.reduce((totalCommission, transaction) => {
          const amount = parseFloat(transaction.amount.replace(/,/g, ''))
          totalCommission += amount * (percentageInternalCompany / 100)
          return totalCommission
        }, 0) || 0

      totalAmountCommissions = internalCommissionCompany.toFixed(2)

      commissions = {
        speiOut: 0,
        internalTransferCompany: internalCommissionCompany.toFixed(2),
        fee: 0
      }
    }

    const currentBalanceWithCommissions = (parseFloat(balance) - currentBalance - totalAmountCommissions).toFixed(2)

    const insufficient = Boolean(currentBalanceWithCommissions < 0)

    setTransactionData({
      transactions: values?.transactions || [],
      concept: values?.concept,
      balance,
      origin: values?.origin,
      internal: !isThirdAccountsView,
      currentBalance,
      commissions,
      insufficient,
      total: currentBalanceWithCommissions
    })

    setShowResume(true)
  }

  const handleBackResume = () => {
    setShowResume(false)
  }

  const handleSuccess = transaction => {
    setShowResume(false)
    setSuccessTransaction(transaction)
  }

  const handleChangeView = (event, newValue) => {
    if (newValue) {
      setView(newValue)
      setTransactionForm(null)
    }
  }

  const refetch = () => {
    refetchThirdAccounts()
  }

  useEffect(() => {
    setView(defaultOption?.id)
  }, [defaultOption])

  const renderContentTransaction = (
    <>
      <Stack alignItems={'flex-end'} sx={{ py: 1, px: 3 }}>
        <ToggleButtonGroup
          size={'small'}
          color="primary"
          value={view}
          exclusive
          onChange={handleChangeView}
          aria-label="Platform"
          disabled={transactionLoading}
        >
          {speiOutOptions?.map(option => (
            <ToggleButton key={option?.id} value={option?.id}>
              {option?.name}
            </ToggleButton>
          ))}
        </ToggleButtonGroup>
      </Stack>
      {isConcentratorView ? (
        <SpeiOutConcentratorForm
          onSuccess={handleSuccessForm}
          setCurrentBalance={setCurrentBalance}
          initialValues={transactionForm}
          selectedAccount={selectedAccount}
        />
      ) : (
        <SpeiOutForm
          key={view}
          accounts={accounts || []}
          onSuccess={handleSuccessForm}
          setCurrentBalance={setCurrentBalance}
          initialValues={transactionForm}
          selectedAccount={selectedAccount}
        />
      )}
    </>
  )

  if (!twoAuth) {
    return (
      <RightPanel open={openSpeiOut} handleClose={handleClose} titleElement={titleTransaction}>
        <Stack p={3}>
          <TwoAuthDisabled
            titleMessage={'Google Authenticator'}
            errorMessage={
              'Para realizar esta operación debe activar y configurar el Doble Factor de Autentificación (2FA) desde su perfil.'
            }
          />
        </Stack>
      </RightPanel>
    )
  }

  return (
    <RightPanel open={openSpeiOut} handleClose={handleClose} titleElement={titleTransaction}>
      {isLoading && <RequestLoadingComponent />}

      {isError && !isLoading && (
        <ErrorRequestPage errorMessage={error} titleMessage={'Lista de Cuentas'} handleButton={() => refetch()} />
      )}

      {!isError && !isLoading && openSpeiOut && !showResume && !successTransaction && (
        <m.div
          variants={varFade().in}
          style={{
            display: showResume ? 'none' : 'flex',
            flex: 1,
            overflow: 'hidden',
            flexDirection: 'column'
          }}
        >
          {renderContentTransaction}
        </m.div>
      )}

      {!isError && !isLoading && openSpeiOut && showResume && !successTransaction && (
        <m.div variants={varFade().in}>
          <SpeiOutResume
            data={transactionData}
            onBack={handleBackResume}
            setTransactionLoading={setTransactionLoading}
            transactionLoading={transactionLoading}
            onSuccess={handleSuccess}
          />
        </m.div>
      )}

      {!isError && !isLoading && openSpeiOut && !showResume && successTransaction && (
        <m.div variants={varFade().in}>
          <SpeiOutSuccess transactions={successTransaction} onFinish={handleClose} />
        </m.div>
      )}
    </RightPanel>
  )
}

export default SpeiOutDrawer
