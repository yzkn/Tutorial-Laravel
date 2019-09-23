<template>
    <div>
        <ul>
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/login">Log in</router-link></li>
            <li><router-link to="/item">Items</router-link></li>
            <li><router-link to="/subitem">Sub items</router-link></li>
            <li @click="logout">Log out</li>
        </ul>
        <hr>
        <router-view></router-view>
    </div>
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