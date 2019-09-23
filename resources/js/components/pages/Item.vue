<template>
  <div>
    <ul>
        <li v-for="item in items" v-bind:key="item.id">
            <router-link :to="'/item/' + item.id">{{ item.title }}</router-link>
        </li>
    </ul>
  </div>
</template>

<script>
    export default {
        created() {
            this.getitems()
        },
        data() {
            return {
                items: []
            }
        },
        methods: {
            getitems() {
                axios.get('/api/item')
                .then(res =>  {
                    this.items = res.data.items
                })
            }
        }
    }
</script>