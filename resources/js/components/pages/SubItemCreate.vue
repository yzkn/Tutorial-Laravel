<template>
    <div class="container">
        <div v-if="saved" class="alert alert-primary" role="alert">
        Saved
        </div>
        <form>
            <div class="form-group">
                <label for="SubItemSubTitle">サブタイトル</label>
                <input type="text" class="form-control" id="SubItemSubTitle" v-model="subtitle">
            </div>
            <div class="form-group">
                <label for="SubItemSubContent">サブコンテンツ</label>
                <textarea class="form-control" id="SubItemSubContent" rows="3" v-model="subcontent"></textarea>
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
            subtitle: '',
            subcontent: '',
        }
    },
    methods: {
        create : function() {
            axios.post('/api/subitem', {
                subtitle: this.subtitle,
                subcontent: this.subcontent,
            })
            .then((res) => {
                this.subtitle = '';
                this.subcontent = '';
                this.saved = true;
            });
        }
    }
}
</script>