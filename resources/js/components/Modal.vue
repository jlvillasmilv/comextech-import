<template>
    <!-- <div class="overflow-x-hidden h-screen w-full fixed left-1 top-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="w-full px-3 py-2 overflow-hidden bg-white md:max-w-xl rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal"> -->
    <div
        class="overflow-x-hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    >
        <div
            class="w-full h-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-4xl"
            role="dialog"
            id="modal"
        >
            <!-- <header class="flex justify-between">
                 <p class="mb-1 text-lg text-gray-400 dark:text-gray-300">
                    {{ title }}
                </p>
            </header> -->
            <!-- Modal body -->
            <div class="mt-4 mb-1">
                <slot name="body"> </slot>
            </div>
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
            >
                <slot name="footer"> </slot>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            statusModal: this.default
        };
    },
    props: {
        default: Boolean,
        title: String
    }
};
</script>

<style></style>
