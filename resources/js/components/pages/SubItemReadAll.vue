<template>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Subitems</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="search-box">
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="search"
                                    class="form-control"
                                    placeholder="Search by Name"
                                />
                                <span class="input-group-addon">
                                    <i class="material-icons">&#xE8B6;</i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Sub title</th>
                        <th>Sub content</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="( subitem, key, index ) in subitems"
                        :key="key"
                        :to="{ name: 'subitem-read', params: { id: subitem.id } }"
                    >
                        <td>{{subitem.id}}</td>
                        <td>{{subitem.subtitle}}</td>
                        <td>{{subitem.subcontent}}</td>
                        <td>
                            <router-link
                                class="edit"
                                title="Edit"
                                :to="{ name: 'subitem-read', params: { id: subitem.id } }"
                            >
                                <i class="material-icons">&#xE254;</i>
                            </router-link>

                            <a
                                href="#"
                                class="delete"
                                title="Delete"
                                @click.stop.prevent="onDelete(subitem.id, key)"
                            >
                                <i class="material-icons">&#xE872;</i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
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