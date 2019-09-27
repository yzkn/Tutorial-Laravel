<template>
    <div class="container">
        <div v-if="saved" class="alert alert-primary" role="alert">Saved</div>
        <form>
            <div class="form-group">
                <label for="SubItemSubTitle">サブタイトル</label>
                <input type="text" class="form-control" id="SubItemSubTitle" v-model="subtitle" />
            </div>
            <div class="form-group">
                <label for="SubItemSubContent">サブコンテンツ</label>
                <textarea class="form-control" id="SubItemSubContent" rows="3" v-model="subcontent"></textarea>
            </div>
            <div class="form-group">
                <label for="SubItemItemId">親アイテム</label>
                <select v-model="item_id">
                    <option v-for="( item, key, index ) in items" :key="key" :value="item.id">{{item.title}}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" @click.prevent="create">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                saved: false,
                subtitle: "",
                subcontent: "",
                item_id: "",

                items: null
            };
        },

        mounted: function() {
            this.getItems();
        },

        methods: {
            create: function() {
                axios
                    .post("/api/subitem", {
                        subtitle: this.subtitle,
                        subcontent: this.subcontent,
                        item_id: this.item_id
                    })
                    .then(res => {
                        this.subtitle = "";
                        this.subcontent = "";
                        this.item_id = "";
                        this.saved = true;
                    });
            },
            getItems: function() {
                axios.get("/api/item").then(res => {
                    this.items = res.data.items;
                });
            }
        }
    };
</script>