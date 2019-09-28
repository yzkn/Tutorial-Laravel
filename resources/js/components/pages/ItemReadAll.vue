<template>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Items</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="search-box">
                            <div class="input-group">
                                <input
                                    type="text"
                                    v-model="searchWord"
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
                        <th
                            v-for="(value, key, index) in columns"
                            :key="key"
                            @click="sortBy(key)"
                        >{{ value }}</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="( item, key, index ) in filteredItems"
                        :key="key"
                        :to="{ name: 'item-read', params: { id: item.id } }"
                    >
                        <td v-for="(value2, key2) in columns" :key="key2">{{ item[key2] }}</td>
                        <td>
                            <router-link
                                class="edit"
                                title="Edit"
                                :to="{ name: 'item-read', params: { id: item.id } }"
                            >
                                <i class="material-icons">&#xE254;</i>
                            </router-link>
                            <a
                                href="#"
                                class="delete"
                                title="Delete"
                                @click.stop.prevent="onDelete(item.id, key)"
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
            var columns = {
                id: "ID",
                title: "タイトル",
                content: "コンテンツ"
            };
            var sortOrders = {};
            Object.keys(columns).forEach(function(key) {
                sortOrders[key] = 1;
            });
            return {
                columns: columns,
                items: null,
                searchWord: "",
                sortKey: "",
                sortOrders: sortOrders
            };
        },
        mounted: function() {
            this.getItems();
        },
        methods: {
            getItems: function() {
                axios.get("/api/item").then(res => {
                    this.items = res.data.items;
                });
            },
            onDelete: function(id, key) {
                axios.delete("/api/item/" + id).then(() => {
                    this.$delete(this.items, key);
                });
            },
            sortBy: function(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            }
        },
        computed: {
            filteredItems: function() {
                var data = this.items;

                var sortKey = this.sortKey;
                var order = this.sortOrders[sortKey] || 1;

                if (sortKey) {
                    data = data.slice().sort(function(a, b) {
                        a = a[sortKey];
                        b = b[sortKey];

                        if (typeof a === "string") {
                            a = a.toLowerCase();
                        }
                        if (typeof b === "string") {
                            b = b.toLowerCase();
                        }

                        return (a === b ? 0 : a > b ? 1 : -1) * order;
                    });
                }

                var filterWord = this.searchWord && this.searchWord.toLowerCase();
                if (filterWord) {
                    data = data.filter(function(row) {
                        return Object.keys(row).some(function(key) {
                            return (
                                String(row[key])
                                    .toLowerCase()
                                    .indexOf(filterWord) > -1
                            );
                        });
                    });
                }

                return data;
            }
        }
    };
</script>

<style scoped>
    @import "https://fonts.googleapis.com/css?family=Roboto|Varela+Round";
    @import "https://fonts.googleapis.com/icon?family=Material+Icons";
    @import "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
</style>