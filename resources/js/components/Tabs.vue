<template>
  <div class="overflow-visible rounded-lg ring-1 ring-black ring-opacity-5">
    <div class="overflow-x-auto">
      <ul class="flex items-center mt-2 sm:justify-center ">
        <button
          @click="$store.state.statusModal = !$store.state.statusModal"
          class="
            px-2
            py-2
            m-1
            leading-5
            text-white
            transition-colors
            duration-150
            bg-blue-1300
            border border-transparent
            rounded-lg
            active:bg-blue-1300
            hover:bg-blue-1200
            focus:outline-none focus:shadow-outline-blue
          "
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
            />
          </svg>
        </button>

        <button
          rel="prev"
          class="hidden md:block px-1 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue"
          @click="$store.dispatch('callIncomingOrNextMenu', false)"
          :disabled="$store.state.positionTabs == 0"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
        <div v-for="(item, id) in sortServices" :key="id">
          <li
            @click="$store.dispatch('callActiveTabs', item)"
            :class="[
              'cursor-pointer py-2 px-4 border-b-8 text-base',
              item.code == $store.state.tabActive
                ? 'text-b-500 text-blue-1300 border-blue-1000 font-semibold hover:text-blue-1200'
                : 'text-b-500 text-gray-500 font-semibold hover:text-blue-1300'
            ]"
          >
            {{ item.name }}
          </li>
        </div>
        <button
          rel="next"
          class=" hidden md:block px-1 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue"
          @click="$store.dispatch('callIncomingOrNextMenu', true)"
          :disabled="$store.state.positionTabs + 1 == $store.state.selectedServices.length"
        >
          <svg class="w-5 h-5 fill-current" aria-hidden="true" viewBox="0 0 20 20">
            <path
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
              fill-rule="evenodd"
            ></path>
          </svg>
        </button>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      open: false
    };
  },
  methods: {
    toggle() {
      this.open = !this.open;
    }
  },
  computed: {
    sortServices() {
      if (this.$store.state.selectedServices)
        return this.$store.state.selectedServices.sort((a, b) => a.sort - b.sort);
      else return [];
    }
  }
};
</script>
