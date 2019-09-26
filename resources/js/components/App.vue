<template>
    <div id="app">
        <navbar :brand=brand></navbar>
        <Jumbotron></Jumbotron>
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