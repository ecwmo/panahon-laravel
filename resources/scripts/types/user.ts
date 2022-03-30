interface User {
  id?: number
  name: string
  email?: string
  password?: string
  roles: number[]
}

interface UserFormError {
  [index: string]: string[]
}

export { User, UserFormError }
