<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body"
                          rows="5"
                          id="body"
                          class="form-control"
                          required
                          v-model="body"
                          placeholder="Having something to say"></textarea>
            </div>

            <button class="btn btn-primary"
                    type="submit"
                    @click="addReply">Post</button>
        </div>

        <p style="padding-top: 20px;"
           v-else
           class="text-center">Please <a href="/login">sign in</a> to participate in this discussion.</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {
                    'body': this.body
                })
                    .catch(error => {
                        flash(error.response.data, 'danger')
                    })
                    .then(({data}) => {
                        this.body = ''


                        flash('Your reply has been posted.')

                        this.$emit('created', data)
                    })
            }
        }

    }
</script>
