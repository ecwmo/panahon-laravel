// eslint-disable-next-line @typescript-eslint/no-explicit-any
type IntusFields = Record<string | symbol, any>

interface IntusValidationRule {
  passes: () => boolean
  message: (msg: string) => string
}

interface IntusValidationRules {
  [key: string]: IntusValidationRule[]
}

declare module 'intus' {
  const e: {
    validate: (
      fields: IntusFields,
      rules: IntusValidationRules
    ) => {
      passes: () => boolean
      errors: () => { [key: string]: string }
    }
  }
  export default e
}

declare module 'intus/rules' {
  declare function isRequired(): IntusValidationRule
  declare function isUrl(): IntusValidationRule
  declare function isEmail(): IntusValidationRule
  declare function isRegex(r: regex): IntusValidationRule
}
