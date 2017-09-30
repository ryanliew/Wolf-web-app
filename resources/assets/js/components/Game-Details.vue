<template>
	<div>
		<div class="text-center">
			<h4>上帝: <span v-text="this.judge.name"></span></h4>
			<p><b>指示顺序:</b></p>
			
			<ul class="list-inline instructions">
				<li><img src="/img/roles/wolf.jpg"></li>
				<li><img src="/img/roles/witch.jpg"></li>
				<li><img src="/img/roles/fortune-teller.jpg"></li>
				<li><img src="/img/roles/guard.jpg"></li>
				<li><img src="/img/roles/hunter.jpg"></li>
				<li><img src="/img/roles/idiot.jpg"></li>
				<li><img src="/img/roles/demon.jpg"></li>
			</ul>	
		</div>
		<div>
			<ul class="list-inline player-list">
		    	<player-details v-for="(player, index) in players" :key="player.id" :player="player" :rolesSelection="roles" :gameId="id" :is_concluded="game.is_concluded"></player-details>
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
				roles: false,
				game: false,
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch() {
				axios.get('/ajax/game/' + this.id)
					.then(this.setGame);
				axios.get('/ajax/game/' + this.id + '/players')
					.then(this.refresh);
				axios.get('/ajax/game/'+ this.id + '/judge' )
					.then(this.setJudge)
				axios.get('/ajax/roles' )
					.then(this.setRoles)
			},

			refresh(response) {
				this.players = response.data;
			},

			setGame(response) {
				this.game = response.data;
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

			redirect() {
				window.location.href = "/games/create";
			}
		}	


	}
</script>