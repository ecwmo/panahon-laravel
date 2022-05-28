<template>
  <div class="md:flex md:flex-col">
    <div class="md:h-screen md:flex md:flex-col">
      <Header title="Panahon" />
      <div class="md:flex md:flex-grow md:overflow-hidden">
        <Sidebar />
        <div class="md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto">
          <RouterView />
        </div>
      </div>
    </div>
  </div>
</template>
