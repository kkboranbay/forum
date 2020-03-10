<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn']
            }
        },

        methods: {
            subscribe() {
                axios[
                    (this.active ? 'delete' : 'post')
                ](`${location.pathname}/subscription`)

                this.active = ! this.active
            }
        }
    }
</script>
