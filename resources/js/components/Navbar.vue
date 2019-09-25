<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <button
      type="button"
      class="navbar-toggler"
      data-toggle="collapse"
      data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="ナビゲーションの切替"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">{{ brand }}</a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link class="nav-link active" :to="{ name: 'item-readall' }">Items</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" :to="{ name: 'subitem-readall' }">Sub items</router-link>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link class="nav-link active" :to="{ name: 'item-create' }">Create Item</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" :to="{ name: 'subitem-create' }">Create SubItem</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link active" :to="{ name: 'login' }">Login</router-link>
        </li>
        <li class="nav-item" @click="logout">
          <span class="nav-link active">Logout</span>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
    export default {
      props: {
          brand: String,
      },

      methods: {
          logout() {
              axios.post('/api/auth/logout').then(res => {
                  axios.defaults.headers.common['Authorization'] = '';
                  state.isLogin = false;
                  this.$router.push({path: '/'});
              });
          }
      }
    }
</script>