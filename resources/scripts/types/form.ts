// eslint-disable-next-line @typescript-eslint/no-explicit-any
export type FormFields = Record<string | symbol, any>

export type UserFields = FormFields & {
  id?: number
  username: string
  full_name: string
  email: string
  password?: string
  password_confirm?: string
  roleIds?: number[]
}

export type RoleFields = FormFields & {
  id?: number
  name: string
  description?: string
}

export type StationFields = FormFields & {
  id?: number
  name: string
  lat?: number | string
  lon?: number | string
  elevation?: number | string
  mobile_number?: string
  station_url: string
  date_installed?: Date | string
  address?: string
  province?: string
  region?: string
  station_type?: string
  station_type2?: string
  status?: string
}

export interface SelectOption {
  name: string
  value?: string | number
}
