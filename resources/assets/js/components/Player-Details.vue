<template>
	<div class="col-xs-6 col-sm-3 text-center no-padding" :class="classes">
        <div class="row">
            <div class="col-xs-12">
                <img class="img-responsive profile" :src="this.player.avatar_path" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <span class="name" v-text="this.player.pivot.seat + ' - ' + this.player.name"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline" v-if="!this.role">
                    <li v-for="(role, index) in rolesSelection" :key="role.id" v-if="role.id !== 1" class="no-padding" @click="select(role)">
                        <img :src="'/img/roles/' + role.slug + '.jpg'">
                    </li>
                </ul>
                <div v-else>
                    <img class="profile" :src="'/img/roles/' + this.role.slug + '.jpg'">
                    <button class="btn btn-danger" v-if="alive" @click="kill">Kill</button>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
	export default {
		props: ['player', 'rolesSelection', 'gameId'],
		data() {
			return {
				role: false,
                alive: true,
                status: "Alive"
			};
		},

        methods: {
            kill() {
                this.status = "Dead";
                this.alive = false;
                axios.post('/ajax/game/' + this.gameId + '/status', {
                    user_id: this.player.id,
                    alive: this.alive
                });
            },

            select(role) {
                this.role = role;
                axios.post('/ajax/game/' + this.gameId + '/role', {
                    user_id: this.player.id,
                    role_id: this.role.id
                });
            }
        },

        computed: {
            classes() {
                return [this.alive ? "alive" : "dead"];
            }
        }

	}
</script>