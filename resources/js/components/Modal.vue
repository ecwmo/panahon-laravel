<template>
    <div
        class="
            h-screen
            w-full
            fixed
            left-0
            top-0
            flex
            justify-center
            items-center
            bg-black bg-opacity-50
        "
        aria-labelledby="deleteModalLabel"
    >
        <div class="relative flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl">
            <div class="absolute top-1 right-1 p-2 cursor-pointer" @click.prevent="$emit('close')">
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="
                            w-16
                            h-16
                            rounded-2xl
                            p-3
                            border border-blue-100
                            text-blue-400
                            bg-blue-50
                        "
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <div class="flex flex-col ml-3">
                        <div class="font-medium leading-none">{{ message }}</div>
                    </div>
                </div>
                <form @submit.prevent="$emit('btnClick')" method="post">
                    <button
                        class="
                            flex-no-shrink
                            bg-red-500
                            px-5
                            ml-4
                            py-2
                            text-sm
                            shadow-sm
                            hover:shadow-lg
                            font-medium
                            tracking-wider
                            border-2 border-red-500
                            text-white
                            rounded-full
                        "
                        type="submit"
                    >
                        {{ btnName }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: { message: { default: 'Delete?' }, btnName: { default: 'Delete' } },
};
</script>
