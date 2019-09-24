<template>
    <div>
        <div class="card" v-if="subitem">
            <div v-if="updated" class="alert alert-primary" role="alert">
                Updated
            </div>
            <div class="card-body">
                <div v-if="!editFlg">
                    <h1 class="card-title">{{subitem.title}}</h1>
                    <div class="card-text">{{subitem.content}}</div>
                </div>
                <form v-else>
                    <div class="form-group">
                        <input type="text" name="title" id="SubItemTitle" class="form-control" v-model="subitem.title">
                    </div>
                    <div class="form-group">
                        <textarea name="content" id="SubItemContent" class="form-control" v-model="subitem.content"></textarea>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <time>{{subitem.date}}</time>
                <button class="btn btn-light text-right" v-if="!editFlg" @click="(editFlg = true)">Edit</button>
                <button class="btn btn-light text-right" v-else @click="onUpdate">Update</button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    data: function( ) {
        return {
            subitem: null,
            editFlg: false,
            updated: false,
        }
    },
    mounted: function() {
        this.getSubItem();
    },
    methods: {
        getSubItem: function() {
            axios.get('/api/subitem/' + this.$route.params.id)
            .then( ( res ) => {
                this.subitem = res.data;
            });
        },
        onUpdate: function() {
            axios.patch('/api/subitem/' + this.subitem.id, {
                title: this.subitem.title,
                content: this.subitem.content
            })
            .then( (res) => {
                this.editFlg = false;
                this.updated = true;
            });
        }
    }
}
</script>