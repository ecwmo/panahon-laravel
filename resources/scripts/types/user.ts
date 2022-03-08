interface User {
  id?: number
  name: string
  email?: string
  password?: string
  roles: string[]
}

interface UserFormError {
  [index: string]: string[]
}

export { User, UserFormError }
