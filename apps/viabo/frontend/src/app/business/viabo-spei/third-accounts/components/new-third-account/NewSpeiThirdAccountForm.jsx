import PropTypes from 'prop-types'

import { EmailOutlined, Lock, Phone } from '@mui/icons-material'
import { LoadingButton } from '@mui/lab'
import { Box, InputAdornment, Stack, Typography } from '@mui/material'
import { useFormik } from 'formik'
import * as Yup from 'yup'

import { SpeiNewThirdAccountAdapter } from '../../adapters'
import { useCreateNewSpeiThirdAccount } from '../../hooks'

import { FormProvider, RFSelect, RFTextField } from '@/shared/components/form'

const NewSpeiThirdAccountForm = ({ account, catalogBanks, onSuccess }) => {
  const { mutate, isLoading } = useCreateNewSpeiThirdAccount()

  const ValidationSchema = Yup.object().shape({
    clabe: Yup.string()
      .trim()
      .max(18, 'Máximo 18 caracteres')
      .matches(/^\S{18}$/, 'La clabe debe contener 18 caracteres y no puede contener espacios en blanco')
      .required('Es necesario la clabe'),
    name: Yup.string().trim().max(100, 'Máximo 100 caracteres').required('Es necesario el beneficiario'),
    rfc: Yup.string(),
    alias: Yup.string().trim().max(100, 'Máximo 100 caracteres'),
    bank: Yup.object().nullable().required('Es necesario el banco'),
    email: Yup.string().trim().email('Ingrese un correo valido'),
    phone: Yup.string().trim(),
    googleCode: Yup.string()
      .trim()
      .min(6, 'Es necesario el código de 6 dígitos')
      .required('Es necesario el código de 6 dígitos')
  })

  const formik = useFormik({
    initialValues: {
      clabe: account?.clabe || '',
      name: account?.beneficiary || '',
      alias: account?.alias || '',
      rfc: account?.rfc || '',
      bank: catalogBanks?.find(bank => bank?.id === account?.bank?.id) || null,
      email: account?.email || '',
      phone: account?.phone || '',
      googleCode: ''
    },
    enableReinitialize: true,
    validationSchema: ValidationSchema,
    onSubmit: (values, { setSubmitting, setFieldValue }) => {
      const account = SpeiNewThirdAccountAdapter(values)
      mutate(account, {
        onSuccess: () => {
          setSubmitting(false)
          onSuccess()
        },
        onError: () => {
          setSubmitting(false)
        }
      })
    }
  })

  const { isSubmitting, setFieldValue, values } = formik

  const loading = isSubmitting || isLoading
  return (
    <FormProvider formik={formik}>
      <Stack spacing={2}>
        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            Cuenta CLABE
            <Box component={'span'} color={'error.main'} ml={0.5}>
              *
            </Box>
          </Typography>

          <RFTextField
            inputProps={{ maxLength: '18' }}
            required
            name={'clabe'}
            size={'small'}
            disabled={loading}
            placeholder={'Clabe...'}
          />
        </Stack>

        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            Beneficiario
            <Box component={'span'} color={'error.main'} ml={0.5}>
              *
            </Box>
          </Typography>

          <RFTextField
            required
            name={'name'}
            size={'small'}
            placeholder={'Nombre del titular de la cuenta...'}
            disabled={loading}
          />
        </Stack>

        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            RFC
          </Typography>

          <RFTextField name={'rfc'} size={'small'} placeholder={'RFC del beneficiario...'} disabled={loading} />
        </Stack>

        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            Alias
          </Typography>

          <RFTextField name={'alias'} size={'small'} placeholder={'Alias de la cuenta...'} disabled={loading} />
        </Stack>

        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            Banco
            <Box component={'span'} color={'error.main'} ml={0.5}>
              *
            </Box>
          </Typography>
          <RFSelect
            name={'bank'}
            textFieldParams={{ placeholder: 'Seleccionar ...', required: true, size: 'small' }}
            options={catalogBanks || []}
            disabled={loading}
          />
        </Stack>

        <Stack flexDirection={{ md: 'row' }} gap={2}>
          <Stack spacing={1} flex={1}>
            <Typography type={'email'} paragraph variant="overline" sx={{ color: 'text.disabled' }}>
              Correo
            </Typography>

            <RFTextField
              name={'email'}
              size={'small'}
              placeholder={'beneficiario@domino.com...'}
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <EmailOutlined />
                  </InputAdornment>
                )
              }}
              disabled={loading}
            />
          </Stack>

          <Stack spacing={1}>
            <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
              Teléfono
            </Typography>
            <RFTextField
              name={'phone'}
              type={'tel'}
              size={'small'}
              placeholder={'55 5555 5555'}
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Phone />
                  </InputAdornment>
                )
              }}
              disabled={loading}
            />
          </Stack>
        </Stack>

        <Stack spacing={1}>
          <Typography paragraph variant="overline" sx={{ color: 'text.disabled' }}>
            Token de Google{' '}
            <Box component={'span'} color={'error.main'}>
              *
            </Box>
          </Typography>
          <RFTextField
            name={'googleCode'}
            type={'number'}
            size={'small'}
            placeholder={'000000'}
            inputProps={{ maxLength: '6', inputMode: 'numeric', min: '1' }}
            InputProps={{
              startAdornment: (
                <InputAdornment position="start">
                  <Lock />
                </InputAdornment>
              )
            }}
            disabled={loading}
          />
        </Stack>

        <Stack sx={{ pt: 1 }}>
          <LoadingButton size={'large'} loading={loading} variant="contained" color="primary" fullWidth type="submit">
            Crear
          </LoadingButton>
        </Stack>
      </Stack>
    </FormProvider>
  )
}

NewSpeiThirdAccountForm.propTypes = {
  account: PropTypes.shape({
    alias: PropTypes.string,
    bank: PropTypes.shape({
      id: PropTypes.any
    }),
    beneficiary: PropTypes.string,
    clabe: PropTypes.string,
    email: PropTypes.string,
    phone: PropTypes.string,
    rfc: PropTypes.string
  }),
  catalogBanks: PropTypes.array,
  onSuccess: PropTypes.func
}

export default NewSpeiThirdAccountForm
