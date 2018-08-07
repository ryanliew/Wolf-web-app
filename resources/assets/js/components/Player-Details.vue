<template>
    <div class="player-card-container">
        <div class="player-card d-flex">
            <div class="player-image" :style="'background-image: url(' + avatar + ');'">

            </div>
            <div class="player-details flex-1">

                <div class="header" :style="'background-image: url(/img/roles/' + this.role.slug + '.jpg);'">
                    <div class="overlay"></div>
                    <div class="name d-flex">
                        <div class="circle">{{ player.seat }}</div>
                        <div class="flex-1">{{ player.user.name }} - {{ player.role.translated_name }}</div>
                    </div>
                    <div class="footer">
                        <button class="btn btn-danger" v-if="this.player.is_alive && !is_concluded" @click="kill">出局</button>
                        <button class="btn btn-success" v-if="!this.player.is_alive && !is_concluded" @click="revive">复活</button>
                    </div>
                </div>
                
                <div class="player-kill-badge">
                    <div v-if="player.is_killed_by_poison" class="img-circle" style="background-image: url(/img/roles/witch.jpg);"></div>
                    <div v-if="player.is_killed_by_hunter" class="img-circle" style="background-image: url(/img/roles/hunter.jpg);"></div>
                    <div v-if="player.is_killed_by_assassin" class="img-circle" style="background-image: url(/img/roles/assassin.jpg);"></div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		props: ['player', 'rolesSelection', 'gameId', 'is_concluded', 'selectedRole'],
		data() {
			return {
				initialRole: false,
                alive: this.player.is_alive,
                status: "Alive",
                selecting_role: false,
                avatar: this.player.user.avatar_path,
                role_override: false
			};
		},

        methods: {
            kill() {
                this.status = "Dead";
                this.alive = false;
                
                this.$emit('killed', this.player.seat);

            },

            revive() {
                this.status = "Alive";
                this.alive = true;

                this.$emit('revived', this.player.seat);
            },

            select(role) {
                this.initialRole = role;
                axios.post('/ajax/game/' + this.gameId + '/role', {
                    user_id: this.player.user_id,
                    role_id: this.role.id
                });
                this.selecting_role = false;
                this.role_override = true;
            },

            getRole() {
                axios.get('/ajax/game/' + this.gameId + '/player/role', {
                    params: {
                        user_id: this.player.user_id
                    }
                }).then((resp) => this.initialRole = resp.data)
                .catch((resp) => this.getRole());
            },
        },

        created() {
            this.getRole();
        },

        computed: {
            classes() {
                return [this.player.is_alive ? "alive" : "dead"];
            },

            role() {
                return this.selectedRole && !this.role_override ? this.selectedRole : this.initialRole;
            }
        }

	}
</script>