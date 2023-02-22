import { router } from '@inertiajs/react'
import moment from 'moment'
import PropTypes from 'prop-types'
import React, { Fragment } from 'react'

const Page = ({
  messages,
  to
}) => {
  const onBack = () => {
    router.visit('/')
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
              {to}
            </div>
          </div>
        </div>
      </div>

      <div>
        <Messages messages={messages} to={to}/>
      </div>
    </Fragment>
  )
}

Page.propTypes = {
  messages: PropTypes.array,
  to: PropTypes.string
}

export default Page

const Messages = ({
  messages,
  to
}) => {
  const onClick = (id) => {
    router.visit(`/inbox/${to}/messages/${id}`)
  }

  return (
    <div className="mx-auto max-w-7xl">
      {messages.map(message => (
        <div
          key={message.message_id}
          className="flex justify-between items-center border-b border-b-zinc-100 px-2 py-4 hover:cursor-pointer hover:bg-zinc-50"
          onClick={() => {
            onClick(message.message_id)
          }}
        >
          <div className="flex-1">
            <div className="font-normal">
              {message.subject}
            </div>

            <div className="text-xs sm:text-sm">
              {message.from}
              <span className="font-medium mx-2">·</span>
              {moment(message.created_at).fromNow()}
            </div>
          </div>

          <div className="text-zinc-500 ml-8">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              strokeWidth="1.5"
              stroke="currentColor"
              className="w-4 h-4"
            >
              <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
          </div>
        </div>
      ))}
    </div>
  )
}

Messages.propTypes = {
  messages: PropTypes.array,
  to: PropTypes.string
}
