<template>
	<div>
		<div class="text-center">
			<h4>上帝: <span v-text="this.judge.name"></span></h4>
			<p><b>指示顺序:</b></p>
			
			<ul class="list-inline instructions">
				<li v-for="(role, index) in orderedRoles" :key="role.id" v-if="role.id !== 5">
					<img :src="role.avatar_path">
				</li>
			</ul>

			<div class="flex flex-center text-center">
				<b>发言玩家: <span v-text="random"></span></b>
				<button class="btn btn-default ml-5" @click="randomSelect">重选</button>
			</div>

		</div>
		<div>
			<ul class="list-inline player-list">
		    	<player-details v-for="(player, index) in players" :key="player.id" :player="player" :rolesSelection="game.roles" :gameId="id" :is_concluded="game.is_concluded" @killed="kill(index)" @revived="revive(index)"></player-details>
			</ul>
		</div>
		<div class="row text-center" v-if="!game.is_concluded">
			<button class="btn btn-success" @click="win('good')">好人获胜</button>
			<button class="btn btn-danger"@click="win('bad')">狼人获胜</button>
		</div>
	</div>
</template>

<script>
	import PlayerDetails from './Player-Details.vue';

	export default {
		components: { PlayerDetails },

		props: ['id'],

		data() {
			return {
				players: false,
				judge: false,
				game: false,
				random: 0
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch() {
				axios.get('/ajax/game/' + this.id)
					.then(this.setGame);
				
				
			},

			refresh(response) {
				this.players = response.data;
				axios.get('/ajax/game/'+ this.id + '/judge' )
					.then(this.setJudge)
			},

			setGame(response) {
				this.game = response.data;
				axios.get('/ajax/game/' + this.id + '/players')
							.then(this.refresh);
			},

			setJudge(response) {
				this.judge = response.data;
			},

			setRoles(response) {
				this.roles = response.data;
			},

			win(type) {
				axios.post('/ajax/game/' + this.id + '/end', {
					type: type
				}).then(this.redirect);
			},

			redirect(response) {
				if( response.data == 204 )
					flash("请确认所有玩家的身份");
				else
					window.location.href = "/games/create";
			},

			randomSelect() {
				let deadPlayers = this.players.slice();
				var alivePlayers = _.remove(deadPlayers, function(n) {
					return n.pivot.is_alive;
				});
				var key = _.random(0, alivePlayers.length - 1);
				this.random = alivePlayers[key].name;
			},

			kill(index) {
				this.players[index].pivot.is_alive = 0;
			},

			revive(index) {
				this.players[index].pivot.is_alive = 1;
			}
		},

		computed: {
			orderedRoles() {
				return _.orderBy(this.game.roles, 'sequence');
			},
		}	


	}
</script>