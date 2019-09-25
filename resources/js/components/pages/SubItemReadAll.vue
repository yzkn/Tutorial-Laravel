<template>
    <div class="container">
        <div class="list-group">
            <router-link v-for="( subitem, key, index ) in subitems" :key="key" :to="{ name: 'subitem-read', params: { id: subitem.id } }" class="list-group-subitem">
                {{subitem.subtitle}}
                <button class="btn" @click.stop.prevent="onDelete(subitem.id, key)">Delete</button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            subitems: null
        };
    },
    mounted: function() {
        this.getSubItems();
    },
    methods: {
        getSubItems: function() {
            axios.get("/api/subitem").then(res => {
                this.subitems = res.data.subitems;
            });
        },
        onDelete: function(id, key) {
            axios.delete("/api/subitem/" + id).then(() => {
                this.$delete(this.subitems, key);
            });
        }
    }
};
</script>