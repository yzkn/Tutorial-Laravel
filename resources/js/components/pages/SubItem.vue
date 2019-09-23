<template>
  <div>
    <ul>
        <li v-for="subitem in subitems" v-bind:key="subitem.id">
            <router-link :to="'/subitem/' + subitem.id">{{ subitem.title }}</router-link>
        </li>
    </ul>
  </div>
</template>

<script>
    export default {
        created() {
            this.getsubitems()
        },
        data() {
            return {
                subitems: []
            }
        },
        methods: {
            getsubitems() {
                axios.get('/api/subitem')
                .then(res =>  {
                    this.subitems = res.data.subitems
                })
            }
        }
    }
</script>