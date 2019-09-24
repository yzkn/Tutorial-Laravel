<template>
    <div class="container">
        <div v-if="saved" class="alert alert-primary" role="alert">
        Saved
        </div>
        <form>
            <div class="form-group">
                <label for="ItemTitle">タイトル</label>
                <input type="text" class="form-control" id="ItemTitle" v-model="title">
            </div>
            <div class="form-group">
                <label for="ItemContent">コンテンツ</label>
                <textarea class="form-control" id="ItemContent" rows="3" v-model="content"></textarea>
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
            title: '',
            content: '',
        }
    },
    methods: {
        create : function() {
            axios.post('/api/item', {
                title: this.title,
                content: this.content,
            })
            .then((res) => {
                this.title = '';
                this.content = '';
                this.saved = true;
            });
        }
    }
}
</script>