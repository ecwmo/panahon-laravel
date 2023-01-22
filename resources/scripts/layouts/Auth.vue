<template>
  <div id="app" class="p-6 bg-blue-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <h1 class="text-center font-bold text-gray-200 text-4xl">
        <InertiaLink :href="route('home')">Panahon</InertiaLink>
      </h1>
      <div class="mt-8 px-6 py-8 bg-white rounded-lg shadow-xl overflow-hidden">
        <slot />
      </div>
    </div>
  </div>
</template>
