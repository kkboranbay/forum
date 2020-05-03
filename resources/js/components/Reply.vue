<template>
    <div :id="'reply-'+id" class="card card-body mt-3" :class="isBest ? 'card-body border-success' : 'card-body'">
        <div class="level">
            <h6 class="flex">
                <a :href="'profiles/'+data.owner.name" v-text="data.owner.name" class="ml-3"></a> said
                <span v-text="ago"></span>
            </h6>

            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>
        </div>

        <div class="card">
            <div class="card-body" v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button class="btn-success small">Update</button>
                    <button class="btn small" @click="editing=false" type="button">Cancel</button>
                </form>
            </div>

            <div class="card-body" v-else v-text="body"></div>
        </div>


        <div class="card-footer level">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn-dark mr-2" @click="editing = true">Edit</button>
                <button class="btn-danger mr-2" @click="destroy">Delete</button>
            </div>

            <button class="btn-default mr-2 ml-a" @click="markBestReply" v-show="! isBest">Best reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: {
            Favorite
        },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.is_best,
                reply: this.data
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...'
            },
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id)
            })
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.data.id, {
                        'body': this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger')
                    })

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id)

                // $(this.$el).fadeOut(400, () => {
                //     flash('Your reply has been deleted');
                // });
            },

            favorite() {
                axios.post('/replies/' + this.data.id + '/favorites');

                flash('Favorited');
            },

            markBestReply() {
                axios.post('/replies/'+ this.data.id +'/best')

                window.events.$emit('best-reply-selected', this.data.id)
            }
        }

    }
</script>
