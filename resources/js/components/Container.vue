<template>
  <div :class="['flex md:px-4 py-3 mb-8 rounded-lg dark:bg-gray-800 ', bg ? 'bg-white' : '']">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    bg: {
      required: false,
      default: true
    }
  }
};
</script>
