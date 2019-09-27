<template>
    <div>
        <div class="card" v-if="subitem">
            <div v-if="updated" class="alert alert-primary" role="alert">Updated</div>
            <div class="card-body">
                <div v-if="!editFlg">
                    <h1 class="card-title">{{subitem.subtitle}}</h1>
                    <div class="card-text">{{subitem.subcontent}}</div>
                    <div class="card-text">{{subitem.item_id}}</div>
                </div>
                <form v-else>
                    <div class="form-group">
                        <input
                            type="text"
                            name="title"
                            id="SubItemTitle"
                            class="form-control"
                            v-model="subitem.subtitle"
                        />
                    </div>
                    <div class="form-group">
                        <textarea
                            name="content"
                            id="SubItemContent"
                            class="form-control"
                            v-model="subitem.subcontent"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <select v-model="subitem.item_id">
                            <option
                                v-for="( item, key, index ) in items"
                                :key="key"
                                :value="item.id"
                            >{{item.id}}: {{item.title}}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <time>{{subitem.date}}</time>
                <button
                    class="btn btn-light text-right"
                    v-if="!editFlg"
                    @click="(editFlg = true)"
                >Edit</button>
                <button class="btn btn-light text-right" v-else @click="onUpdate">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                subitem: null,
                editFlg: false,
                updated: false,

                items: null
            };
        },
        mounted: function() {
            this.getItems();
            this.getSubItem();
        },
        methods: {
            getSubItem: function() {
                axios.get("/api/subitem/" + this.$route.params.id).then(res => {
                    this.subitem = res.data;
                });
            },
            onUpdate: function() {
                axios
                    .patch("/api/subitem/" + this.subitem.id, {
                        title: this.subitem.subtitle,
                        content: this.subitem.subcontent,
                        item_id: this.subitem.item_id
                    })
                    .then(res => {
                        this.editFlg = false;
                        this.updated = true;
                    });
            },

            getItems: function() {
                axios.get("/api/item").then(res => {
                    let apiitems = res.data.items;
                    this.items = apiitems.sort((a, b) => {
                        return a.id < b.id ? -1 : a.id > b.id ? 1 : 0;
                    });
                });
            }
        }
    };
</script>