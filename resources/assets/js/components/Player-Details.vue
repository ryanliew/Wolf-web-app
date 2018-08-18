<template>
    <div class="player-card-container" :class="classes" >
        <div class="player-card d-flex">
            <div class="player-image" :style="'background-image: url(' + avatar + ');'">
                <div class="overlay"></div>
                <img :src="'/img/actions/' + die + '.png'" :class="'marking ' + die" v-if="die !== 'N/A'"/>
            </div>
            <div class="player-details flex-1 d-flex flex-col">

                <div class="header flex-1" :style="'background-image: url(/img/roles/' + this.role.slug + '.jpg);'">
                    <div class="overlay"></div>
                    <div class="name d-flex">
                        <div class="circle">{{ player.seat }}</div>
                        <div class="flex-1">{{ player.user.name }} - {{ player.role.translated_name }}</div>
                    </div>
                    <div class="footer d-flex flex-wrap actions">
                        <button class="btn btn-danger" v-for="action in actions" v-if="player.is_alive && !is_concluded && action.type == 'alive' " @click="kill(action.slug, action.id)"><img :src="'/img/actions/' + action.icon"></button>
                        <button class="btn btn-success" v-for="action in actions" v-if="!player.is_alive && !is_concluded && action.type == 'dead' " @click="revive(action.slug, action.id)"><img :src="'/img/actions/' + action.icon"></button>
                        <button class="btn btn-primary" v-for="action in actions" v-if="player.is_alive && !is_concluded && action.type == 'mark' " @click="mark(action.slug, action.id)"><img :src="'/img/actions/' + action.icon"></button>
                    </div>
                    <div class="markings">
                        <img v-for="history in histories" :src="'/img/actions/' + history + '.png'" :class="'marking ' + history" v-if="history !== 'N/A'"/>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		props: ['player', 'rolesSelection', 'gameId', 'is_concluded', 'selectedRole', 'highlighted', 'actions', 'night'],
		data() {
			return {
				initialRole: false,
                alive: this.player.is_alive,
                status: "Alive",
                selecting_role: false,
                avatar: this.player.user.avatar_path,
                role_override: false,
                isWitchKill: false,
                isWolfKill: false,
                isHunterKill: false,
                isAssassinKill: false,
                isVoted: false
			};
		},

        methods: {
            kill(slug, id) {
                axios.post("/ajax/game/" + this.gameId + "/player/" + this.player.id + "/status", {status: slug, action: id, night: this.night})
                    .then(response => this.killSuccess(response))
                    .catch(error => this.kill(slug, id));
                
            },

            killSuccess(response) {
                this.status = "Dead";
                this.alive = false;
                
                this.$emit('killed', {seat: this.player.seat, status: response.data.status});
            },

            revive(slug, id) {
                axios.post("/ajax/game/" + this.gameId + "/player/" + this.player.id + "/status", {status: slug, action: id, night: this.night})
                    .then(response => this.reviveSuccess(response))
                    .catch(error => this.revive(slug, id));
            },

            reviveSuccess(response) {
                this.status = "Alive";
                this.alive = true;

                this.$emit('revived', {seat: this.player.seat, status: response.data.status});
            },

            mark(slug, id) {
                axios.post("/ajax/game/" + this.gameId + "/player/" + this.player.id + "/status", {status: slug, action: id, night: this.night})
                    .then(response => this.markSuccess(response))
                    .catch(error => this.mark(slug));  
            },

            markSuccess(response) {
                this.status = "";

                this.$emit('marked', {seat: this.player.seat, status: response.data.status});
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
                return [
                        this.player.is_alive ? "alive" : "dead",
                        this.player.is_marked ? "mark_" + this.die : ""
                        ];
            },

            role() {
                return this.selectedRole && !this.role_override ? this.selectedRole : this.initialRole;
            },

            histories() {
                if(this.player.status)
                    return this.player.status.split(",");
                return "";
            },

            die() {
                if(this.player.status)
                    return _.last(this.histories);
            }
        }

	}
</script>