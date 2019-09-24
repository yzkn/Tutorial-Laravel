<template>
    <div>
        <p v-show="isError">Authentication failed</p>
        <form @submit.prevent="login">
            Email: <input type="email" v-model="email">
            Password: <input type="password" v-model="password">
            <button type="submit" class="btn btn-primary">Log in</button>
        </form>
    </div>
</template>

<script>
export default {
    data () {
        return {
            isError: false,
            email: '',
            password: '',
        }
    },
    methods: {
        login() {
            const redirect = this.$route.query.redirect;
            axios.post('/api/auth/login', {
                email: this.email,
                password: this.password
            }).then(res => {
                const token = res.data.access_token;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                state.isLogin = true;
                this.$router.push({path: redirect ? redirect : '/'});
            }).catch(error => {
                this.isError = true;
            });
        }
    }
}
</script>