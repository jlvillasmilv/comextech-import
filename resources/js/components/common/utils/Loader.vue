<template>
  <div>
    <loading :active="isLoading" color="#142c44" :height="100" :width="100" />
  </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import { mapState } from 'vuex';

export default {
  data() {
    return {};
  },
  components: { Loading },
  computed: {
    ...mapState(['isLoading'])
  }
};
</script>
