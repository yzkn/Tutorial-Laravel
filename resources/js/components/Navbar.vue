<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><router-link to="/">Home</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item"><router-link to="/login">Log in</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item"><router-link to="/item">Items</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item"><router-link to="/subitem">Sub items</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item" @click="logout"><router-link>Log out</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item"><router-link to="/item/create">Create Item</router-link></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item"><router-link to="/subitem/create">Create SubItem</router-link></li>&nbsp;&nbsp;&nbsp;
        </ul>
    </nav>
</template>

<script>
    export default {
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