interface AuthProps {
  user: {
    email: string
  }
  isAdmin: boolean
  isSuperAdmin: boolean
}

export default () => {
  const { props } = usePage()

  const isLoggedIn = computed(() => (props.value?.auth as AuthProps)?.user?.email.length > 0)
  const isAdmin = computed(() => (props.value?.auth as AuthProps)?.isAdmin)
  const isSuperAdmin = computed(() => (props.value?.auth as AuthProps)?.isSuperAdmin)

  return { isLoggedIn, isAdmin, isSuperAdmin }
}
