import PropTypes from 'prop-types'
import React from 'react'

const Page = ({ version }) => {
  return (
    <p>Welcome to Laravel {version}</p>
  )
}

Page.propTypes = {
  version: PropTypes.string
}

export default Page
