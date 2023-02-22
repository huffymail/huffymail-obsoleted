import { router } from '@inertiajs/react'
import PropTypes from 'prop-types'
import React, { Fragment } from 'react'

const Page = ({ message }) => {
  const onBack = () => {
    router.visit(`/inbox/${message.to}`)
  }

  return (
    <Fragment>
      <div className="border-b border-b-zinc-100 py-6">
        <div className="mx-auto max-w-7xl">
          <div className="px-2">
            <div>
              <button onClick={onBack}>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  strokeWidth="1.5"
                  stroke="currentColor"
                  className="w-6 h-6"
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>
                </svg>
              </button>
            </div>

            <div className="text-xl font-medium mt-2">
              {message.subject}
            </div>
          </div>
        </div>
      </div>

      <div className="mt-4">
        <div className="px-2 mx-auto max-w-7xl">
          <div dangerouslySetInnerHTML={{ __html: message.html }}/>
        </div>
      </div>
    </Fragment>
  )
}

Page.propTypes = {
  message: PropTypes.object
}

export default Page
