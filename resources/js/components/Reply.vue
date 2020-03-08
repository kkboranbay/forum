<template>
    <div :id="'reply-'+id" class="card-body mt-3">
        <div class="level">
            <h6 class="flex">
                <a :href="'profiles/'+data.owner.name" v-text="data.owner.name"></a> said
                <span v-text="ago"></span>
            </h6>

            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>
        </div>

        <div class="card">
            <div class="card-body" v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn-success small" @click="update">Update</button>
                <button class="btn small" @click="editing=false">Cancel</button>
            </div>

            <div class="card-body" v-else v-text="body"></div>
        </div>


        <div class="card-footer level" v-if="canUpdate">
            <button class="btn-dark mr-2" @click="editing = true">Edit</button>
            <button class="btn-danger mr-2" @click="destroy">Delete</button>
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
                body: this.data.body
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...'
            },
            signedIn() {
                return window.App.signedIn
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id)
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    'body': this.body
                });

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
            }
        }

    }
</script>
