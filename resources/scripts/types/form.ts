export interface FormError {
  [index: string]: string[]
}

export interface UserForm {
  id?: number
  name: string
  email?: string
  password?: string
  roles: number[]
}

export interface RoleForm {
  id?: number
  name: string
  description?: string
}

export interface StationForm {
  id?: number
  name: string
  lat?: number | string
  lon?: number | string
  elevation?: number | string
  mobile_number?: string
  date_installed?: Date | string
  address?: string
  province?: string
  region?: string
  station_type?: string
  status?: string
}
