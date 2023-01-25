import { RoleFields, StationFields, UserFields } from '@/types/form'
import intus from 'intus'

export default (fields: StationFields | UserFields | RoleFields, rules: IntusValidationRules) => {
  const form = useForm(fields)
  return new Proxy(form, {
    get(target, prop) {
      if (prop === 'submit') {
        form.clearErrors()

        const validation = intus.validate(form.data(), rules)

        if (!validation.passes()) {
          const errs = validation.errors()
          if ('mobile_number' in errs && errs['mobile_number'] == 'Mobile number must match regex /63[0-9]{10}/.') {
            errs['mobile_number'] = 'The mobile number format is invalid.'
          }
          form.setError(errs)

          // eslint-disable-next-line @typescript-eslint/no-empty-function
          return () => {}
        }
      }
      return target[prop]
    },
  })
}
