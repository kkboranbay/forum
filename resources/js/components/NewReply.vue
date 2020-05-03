<template>
    <div class="mt-3">
        <div v-if="signedIn">
            <div class="form-group">
                <vue-tribute :options="options">
                    <textarea name="body"
                              rows="5"
                              id="body"
                              class="form-control"
                              required
                              v-model="body"
                              placeholder="Having something to say"></textarea>
                </vue-tribute>
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
    import VueTribute from 'vue-tribute'

    export default {

        components: {
            VueTribute
        },

        data() {
            return {
                body: '',
                options: {
                    trigger: "@",
                    values: function (text, cb) {
                        axios.get('/api/users?name='+text)
                            .then((data) => {
                                if (data.status === 200) {
                                    cb(data.data)
                                } else if (data.status === 403) {
                                    cb([]);
                                }
                            })
                    },
                    lookup: 'name',
                    fillAttr: 'name',
                }
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
            },
        },

    }
</script>

<style>
    html,
    body {
        height: 100vh;
        width: 100vw;
    }
    .tribute-container ul {
        margin: 0;
        margin-top: 5px;
        padding: 0;
        list-style: none;
        background: #fff;
        border-radius: 4px;
        border: 1px solid rgba(#000, 0.13);
        background-clip: padding-box;
        overflow: hidden;
    }
    .tribute-container li {
        color: #3f5efb;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
    }
    .tribute-container li.highlight,
    .tribute-container li:hover {
        background: #3f5efb;
        color: #fff;
    }
</style>