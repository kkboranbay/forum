<template>
    <div>
        <ul class="pagination" v-if="shouldPaginate">
            <li class="page-item"><a class="page-link" href="#" v-show="prevUrl" @click.prevent="page--">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#" v-show="nextUrl" @click.prevent="page++">Next</a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page
                this.prevUrl = this.dataSet.prev_page_url
                this.nextUrl = this.dataSet.next_page_url
            },

            page() {
                this.broadcast().updateUrl()
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page)
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page)
            }
        }
    }
</script>