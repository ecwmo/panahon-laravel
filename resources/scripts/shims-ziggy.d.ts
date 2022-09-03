import { Config, InputParams, Router } from 'ziggy-js'
type LaravelRoutes = {
  [key: string]: string
}
declare global {
  declare interface ZiggyLaravelRoutes extends LaravelRoutes {}
  declare function route(): Router
  declare function route(
    name: keyof ZiggyLaravelRoutes,
    params?: InputParams,
    absolute?: boolean,
    customZiggy?: Config
  ): string
}

declare module '@vue/runtime-core' {
  export interface ComponentCustomProperties {
    route(): Router
    route(name: keyof ZiggyLaravelRoutes, params?: InputParams, absolute?: boolean, customZiggy?: Config): string
  }
}
export { LaravelRoutes }
