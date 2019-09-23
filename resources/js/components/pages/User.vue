<template>
    <div>
        <p v-show="isError">Failed to get information.</p>
        <table>
            <tr>
                <th>id</th>
                <td>{{ user.id }}</td>
            </tr>
            <tr>
                <th>name</th>
                <td>{{ user.name }}</td>
            </tr>
            <tr>
                <th>email</th>
                <td>{{ user.email }}</td>
            </tr>
            <tr>
                <th>created_at</th>
                <td>{{ user.created_at }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                isError: false,
                user: {}
            }
        },
        created() {
            axios.get('/api/me').then(res => {
                this.user = res.data;
            }).catch(error => {
                this.isError = true;
            });
        }
    }
</script>