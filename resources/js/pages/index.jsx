import { router } from '@inertiajs/react'
import React, { Fragment } from 'react'
import { Field, withTypes } from 'react-final-form'

const Page = () => {
  return (
    <Fragment>
      <div className="p-4">
        <InboxForm/>
      </div>
    </Fragment>
  )
}

Page.propTypes = {
  //
}

export default Page

const InboxForm = () => {
  const { Form } = withTypes()

  const onSubmit = ({
    prefix,
    domain
  }) => {
    if (!prefix || !domain) {
      return
    }

    router.visit(`/inbox/${prefix}@${domain}`)
  }

  return (
    <div className="mx-auto max-w-sm">
      <Form onSubmit={onSubmit}>
        {({ handleSubmit }) => (
          <form onSubmit={handleSubmit}>
            <div>
              <label className="block text-sm font-medium">
                Prefix
              </label>

              <div className="mt-2">
                <Field
                  name="prefix"
                  component="input"
                  type="text"
                  className="border-zinc-300 rounded w-full transition-all focus:ring-0 focus:border-zinc-500"
                  placeholder="john.doe"
                  required
                />
              </div>
            </div>

            <div className="mt-4">
              <label className="block text-sm font-medium">
                Domain
              </label>

              <div className="mt-2">
                <Field
                  name="domain"
                  component="select"
                  className="border-zinc-300 rounded w-full transition-all focus:ring-0 focus:border-zinc-500"
                  defaultValue="huffymail.com"
                >
                  <option value="huffymail.com">huffymail.com</option>
                </Field>
              </div>
            </div>

            <div className="flex justify-end mt-4">
              <div>
                <button
                  type="submit"
                  className="bg-zinc-900 rounded text-white text-sm font-medium px-4 h-10 transition-all active:bg-white active:ring-1 active:ring-zinc-900 active:text-zinc-900"
                >
                  Go to Inbox
                </button>
              </div>
            </div>
          </form>
        )}
      </Form>
    </div>
  )
}
