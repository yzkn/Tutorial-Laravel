<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><router-link to="/">Home</router-link></li>
            <li class="nav-item"><router-link to="/login">Log in</router-link></li>
            <li class="nav-item"><router-link to="/item">Items</router-link></li>
            <li class="nav-item"><router-link to="/subitem">Sub items</router-link></li>
            <li class="nav-item" @click="logout">Log out</li>
            <li class="nav-item"><router-link to="/item/create">Create Item</router-link></li>
            <li class="nav-item"><router-link to="/subitem/create">Create SubItem</router-link></li>
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