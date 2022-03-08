interface Role {
  id?: number
  name: string
  description?: string
}

interface RoleFormError {
  [index: string]: string[]
}

export { Role, RoleFormError }
