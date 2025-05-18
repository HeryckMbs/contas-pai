<template>
  <div class="logo">
    <router-link :to="{ name: 'Home'}">
      <img
        src="@/assets/logo-branco.png"
        alt="home"
        :height="height"
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
      default: 140
    },
    width: {
      type: Number,
      required: false,
      default: 140
    }
  }
});
</script>
