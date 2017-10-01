<template>
    <div class="alert alert-flash" 
        :class="'alert-'+level"
        role="alert" 
        v-show="show" 
        v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false,
                level: 'success'
            }
        },

        created() {
            if (this.message) {
                this.flash();                
            }

            window.events.$on('flash', data => {
                this.flash(data);
            });
        },

        methods: {
            flash(data) {
                if(data) {
                    this.body = data.message;
                    this.level = data.level;
                }
                
                this.show = true;
                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show= false;
                }, 3000);
            }
        }
    };
</script>

<style>
    .alert-flash {
        position: fixed;
        width:50vw;
        left: 25vw;
        bottom: 10vh;
        background-color: rgba(60,60,60,0.8);
        color: white;
        text-align: center;
        border-radius: 5px;
        border: 0px solid transparent;
    }
</style>