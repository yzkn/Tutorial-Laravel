<template>
    <div id="app">
        <navbar :brand=brand></navbar>
        <p></p>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        props: {
            brand: String,
        }
    }
</script>