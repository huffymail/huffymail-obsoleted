import PropTypes from 'prop-types'
import React from 'react'

const Page = ({ version }) => {
  return (
    <div className="p-4">
      <p>Welcome to Laravel {version}</p>
    </div>
  )
}

Page.propTypes = {
  version: PropTypes.string
}

export default Page
