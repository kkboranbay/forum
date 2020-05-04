<template>
    <div :id="'reply-'+id" class="card card-body mt-3" :class="isBest ? 'card-body border-success' : 'card-body'">
        <div class="level">
            <h6 class="flex">
                <a :href="'profiles/'+reply.owner.name" v-text="reply.owner.name" class="ml-3"></a> said
                <span v-text="ago"></span>
            </h6>

            <div v-if="signedIn">
                <favorite :reply="reply"></favorite>
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

        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn-dark mr-2" @click="editing = true">Edit</button>
                <button class="btn-danger mr-2" @click="destroy">Delete</button>
            </div>

            <button class="btn-default mr-2 ml-a" @click="markBestReply" v-show="authorize('owns', reply.thread)">Best reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: {
            Favorite
        },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.is_best,
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '...'
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
                    '/replies/' + this.id, {
                        'body': this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger')
                    })

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id)

                // $(this.$el).fadeOut(400, () => {
                //     flash('Your reply has been deleted');
                // });
            },

            favorite() {
                axios.post('/replies/' + this.id + '/favorites');

                flash('Favorited');
            },

            markBestReply() {
                axios.post('/replies/'+ this.id +'/best')

                window.events.$emit('best-reply-selected', this.id)
            }
        }

    }
</script>
