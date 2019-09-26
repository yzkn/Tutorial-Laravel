<template>
  <div class="text-center">
    <p v-show="isError">Authentication failed</p>
    <form @submit.prevent="login" class="form-signin">
      <label for="inputEmail" class="sr-only">Email address</label>
      <input
        type="email"
        v-model="email"
        class="form-control"
        placeholder="Email address"
        required
        autofocus
      />
      <label for="inputPassword" class="sr-only">Password</label>
      <input
        type="password"
        v-model="password"
        class="form-control"
        placeholder="Password"
        required
      />
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isError: false,
      email: "",
      password: ""
    };
  },

  methods: {
    login() {
      const redirect = this.$route.query.redirect;
      axios
        .post("/api/auth/login", {
          email: this.email,
          password: this.password
        })
        .then(res => {
          const token = res.data.access_token;
          axios.defaults.headers.common["Authorization"] = "Bearer " + token;
          this.$store.commit("auth/logedin");

          // console.log(this.$store.getters['auth/isLogin'])

          this.$router.push({ path: redirect ? redirect : "/" });
        })
        .catch(error => {
          this.isError = true;
        });
    }
  }
};
</script>

<style scoped>
html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>