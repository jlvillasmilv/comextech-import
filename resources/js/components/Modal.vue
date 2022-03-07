<template>
  <div
    class="overflow-x-auto fixed inset-0 z-30 flex bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <div
      class="w-full px-6 py-4 overflow-y-auto bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:h-auto sm:m-4 sm:max-w-xl md:h-auto"
      role="dialog"
      id="modal"
    >
      <!-- <header class="flex justify-between">
                 <p class="mb-1 text-lg text-gray-400 dark:text-gray-300">
                    {{ title }}
                </p>
            </header> -->
      <!-- Modal body -->
      <div class="">
        <slot name="body"> </slot>
      </div>
      <footer
        class="flex items-center sm:justify-end justify-around px-6 py-1 -mx-6 -mb-2 sm:space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row dark:bg-gray-800"
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
