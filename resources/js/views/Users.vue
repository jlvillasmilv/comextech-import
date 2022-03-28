<template>
  <div class="flex flex-wrap">
    <UsersCompany /> 
  </div>
</template>

<script>

import UsersCompany from '../components/UsersCompany';
export default {
  data() {
    return {
      title: 'Informacion Legal'
    };
  },
  components: {
    UsersCompany,

  }
};
</script>
