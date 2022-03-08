interface Station {
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

interface StationFormError {
  [index: string]: string[]
}

export { Station, StationFormError }
