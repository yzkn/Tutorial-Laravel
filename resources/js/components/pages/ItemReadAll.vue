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
								<input type="text" id="search" class="form-control" placeholder="Search by Name">
                                <span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 20%;">Content</th>
                        <th>City</th>
                        <th>Pin Code</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="( item, key, index ) in items" :key="key" :to="{ name: 'item-read', params: { id: item.id } }">
                        <td>{{item.id}}</td>
                        <td>{{item.title}}</td>
                        <td>{{item.content}}</td>
                        <td>Portland</td>
                        <td>97219</td>
                        <td>USA</td>
                        <td>
                            <router-link
                            class="edit"
                            title="Edit"
                            :to="{ name: 'item-read', params: { id: item.id } }"
                        ><i class="material-icons">&#xE254;</i></router-link>

                            <a href="#" class="edit" title="Edit"><i class="material-icons">&#xE254;</i></a>

                            <a href="#" class="delete" title="Delete" @click.stop.prevent="onDelete(item.id, key)"><i class="material-icons">&#xE872;</i></a>
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
            items: null
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
        }
    }
};
</script>

<style scoped>
    @import 'https://fonts.googleapis.com/css?family=Roboto|Varela+Round';
    @import 'https://fonts.googleapis.com/icon?family=Material+Icons';
    @import 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
</style>