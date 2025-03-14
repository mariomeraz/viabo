import { useMemo } from 'react'

import PropTypes from 'prop-types'

import { Box, Breadcrumbs, Link, Typography } from '@mui/material'
import { Link as RouterLink } from 'react-router-dom'

SimpleBreadcrumbs.propTypes = {
  activeLast: PropTypes.bool,
  links: PropTypes.array.isRequired
}

export function SimpleBreadcrumbs({ links = [], friendlyPages = {}, activeLast = false, ...other }) {
  const currentLink = useMemo(() => links[links.length - 1]?.name, [links])

  const listDefault = links.map(link => <LinkItem key={link.name} link={link} />)

  const listActiveLast = links.map(link => (
    <div key={link.name}>
      {link.name !== currentLink ? (
        <LinkItem link={link} />
      ) : (
        <Typography
          variant="body2"
          sx={{
            maxWidth: 260,
            overflow: 'hidden',
            whiteSpace: 'nowrap',
            color: 'text.disabled',
            textOverflow: 'ellipsis'
          }}
        >
          {currentLink}
        </Typography>
      )}
    </div>
  ))

  return (
    <Breadcrumbs
      separator={<Box component="span" sx={{ width: 4, height: 4, borderRadius: '50%', bgcolor: 'text.disabled' }} />}
      aria-label="breadcrumb"
      {...other}
    >
      {activeLast ? listDefault : listActiveLast}
    </Breadcrumbs>
  )
}

LinkItem.propTypes = {
  link: PropTypes.shape({
    href: PropTypes.string,
    icon: PropTypes.any,
    name: PropTypes.string
  })
}

function LinkItem({ link }) {
  const { href, name, icon } = link
  return (
    <Link
      key={name}
      variant="body2"
      component={RouterLink}
      to={href || '#'}
      sx={{
        lineHeight: 2,
        display: 'flex',
        alignItems: 'center',
        color: 'text.primary',
        '& > div': { display: 'inherit' }
      }}
    >
      {icon && <Box sx={{ mr: 1, '& svg': { width: 20, height: 20 } }}>{icon}</Box>}
      {name}
    </Link>
  )
}
