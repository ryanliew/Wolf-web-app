<template>

    <li :class="classes" class="text-center">
        <div class="row">
            <span v-text="this.player.seat"></span>
            <div class="col-xs-12">
                <div class="img-circle profile player-detail" :style="'background-image: url(' + avatar + ');'"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <span class="name" v-text="player.short_name"></span>
                <div class="player-kill-badge">
                    <div v-if="player.is_killed_by_poison" class="img-circle" style="background-image: url(/img/roles/witch.jpg);"></div>
                    <div v-if="player.is_killed_by_hunter" class="img-circle" style="background-image: url(/img/roles/hunter.jpg);"></div>
                    <div v-if="player.is_killed_by_assassin" class="img-circle" style="background-image: url(/img/roles/assassin.jpg);"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="roles-list" v-if="(this.selecting_role) && !is_concluded">
                    <div v-if="this.selecting_role && !is_concluded">
                        <h4>为 <span v-text="this.player.name"></span> 选择身份</h4>
                        <hr>
                        <h5>好人阵营</h5>
                        <ul class="list-inline good-side">
                            <li v-for="(role, index) in rolesSelection" :key="role.id" v-if="role.id !== 1 && role.type == 'good'" @click="select(role)">
                                <img class="role" :src="'/img/roles/' + role.slug + '.jpg'">
                            </li>
                        </ul>
                        <h5>狼人阵营</h5>
                        <ul class="list-inline bad-side">
                            <li v-for="(role, index) in rolesSelection" :key="role.id" v-if="role.id !== 1 && role.type == 'bad'"  @click="select(role)">
                                <img class="role" :src="'/img/roles/' + role.slug + '.jpg'">
                            </li>
                        </ul>
                        <hr>
                        <button class="btn btn-primary" @click="selecting_role = false">返回</button>
                    </div>
                </div>
                <div v-else>
                    <img class="margin-1 role" :src="'/img/roles/' + this.role.slug + '.jpg'" v-if="this.role" @click="selecting_role = true">
                    <button class="btn btn-danger" v-if="this.player.is_alive && !is_concluded" @click="kill">出局</button>
                    <button class="btn btn-success" v-if="!this.player.is_alive && !is_concluded" @click="revive">复活</button>
                </div>
            </div>
        </div>
    </li>

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