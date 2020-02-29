<script>
    import Favorite from './Favorite';

    export default {
        props: ['attributes'],

        components: {
            Favorite
        },

        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    'body': this.body
                });

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                $(this.$el).fadeOut(400, () => {
                    flash('Your reply has been deleted');
                });
            },

            favorite() {
                axios.post('/replies/' + this.attributes.id + '/favorites');

                flash('Favorited');
            }
        }

    }
</script>s