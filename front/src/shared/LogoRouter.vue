<template>
  <div class="logo">
    <router-link :to="{ name: 'Home'}">
      <img
        src="@/assets/logo-branco.png"
        alt="home"
        height="auto"
        :width="width"
      >
    </router-link>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { RouterLink } from 'vue-router';

export default defineComponent({
  components: { RouterLink },

  props: {
    height: {
      type: Number,
      required: false,
    },
    width: {
      type: Number,
      required: false,
      default: 50
    }
  }
});
</script>
<style lang="css">
  .logo{
    display:flex;
    justify-content: center
  }
</style>
