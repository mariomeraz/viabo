import { useState } from 'react'

import PropTypes from 'prop-types'

import { Collapse, List } from '@mui/material'
import { useLocation } from 'react-router-dom'

import { NavItemRoot, NavItemSub } from './NavItem'

import { getActive } from '../index'

NavListRoot.propTypes = {
  isCollapse: PropTypes.bool,
  list: PropTypes.object
}

export function NavListRoot({ list, isCollapse }) {
  const { pathname } = useLocation()

  const active = getActive(list.path, pathname)

  const [open, setOpen] = useState(active)

  const hasChildren = list.children

  if (hasChildren) {
    return (
      <>
        <NavItemRoot item={list} isCollapse={isCollapse} active={active} open={open} onOpen={() => setOpen(!open)} />

        {!isCollapse && (
          <Collapse in={open} timeout="auto" unmountOnExit>
            <List component="div" disablePadding>
              {(list.children || []).map(item => (
                <NavListSub key={item.name} list={item} />
              ))}
            </List>
          </Collapse>
        )}
      </>
    )
  }

  return <NavItemRoot item={list} active={active} isCollapse={isCollapse} />
}

NavListSub.propTypes = {
  list: PropTypes.object
}

function NavListSub({ list }) {
  const { pathname } = useLocation()

  const active = getActive(list.path, pathname)

  const [open, setOpen] = useState(active)

  const hasChildren = list.children

  if (hasChildren) {
    return (
      <>
        <NavItemSub item={list} onOpen={() => setOpen(!open)} open={open} active={active} />

        <Collapse in={open} timeout="auto" unmountOnExit>
          <List component="div" disablePadding sx={{ pl: 3 }}>
            {(list.children || []).map(item => (
              <NavItemSub key={item.name} item={item} active={getActive(item.path, pathname)} />
            ))}
          </List>
        </Collapse>
      </>
    )
  }

  return <NavItemSub item={list} active={active} />
}
