<template>
  <div class="md:flex md:flex-col">
    <div class="md:h-screen md:flex md:flex-col">
      <Header title="Panahon" />
      <div class="md:flex md:flex-grow md:overflow-hidden">
        <Sidebar />
        <div class="relative md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto">
          <ToastList class="absolute top-4 right-4 z-50" />
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
