<template>

</template>
<script>
// import { AUTH_REQUEST } from "@/js/store/types/auth";
export default {
  name: "Login",
  data() {
    return {
      errorLogin: false,
      user: {}
    };
  },
  methods: {
    // login() {
    //   this.errorLogin = false
    //      this.$store.dispatch(`auth/${AUTH_REQUEST}`, this.user)
    //     .then(() => {
    //       this.$router.push('/');
    //     }).catch(() => {
    //       this.errorLogin = true
    //     });
    //     // this.loading = false
    // }
  }
};
</script>