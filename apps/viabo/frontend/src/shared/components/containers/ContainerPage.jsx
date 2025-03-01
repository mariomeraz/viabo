import PropTypes from 'prop-types'

import { Container } from '@mui/material'
import { m } from 'framer-motion'

import { MotionContainer, varFade } from '@/shared/components/animate'

export function ContainerPage({ children, ...others }) {
  return (
    <Container component={MotionContainer} className="animate__animated animate__fadeIn" maxWidth={false} {...others}>
      <m.div variants={varFade().in}>{children}</m.div>
    </Container>
  )
}

ContainerPage.propTypes = {
  children: PropTypes.node.isRequired
}
