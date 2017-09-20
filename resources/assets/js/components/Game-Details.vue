<template>
	<div>
		<div class="text-center">
			<h4>Judge: <span v-text="this.judge.name"></span></h4>
			<b>Instructions</b>
			<ul class="list-inline instructions">
				<li>Wolf ></li>
				<li>Witch ></li>
				<li>Fortune teller ></li>
				<li>Hunter ></li>
				<li>Idiot ></li>
				<li>Demon ></li>
			</ul>	
		</div>
		<div class="row">
		    <div v-for="(player, index) in players" :key="player.id">
		    	<player-details :player="player" :rolesSelection="roles" :gameId="id"></player-details>
		    </div>
		</div>
		<div class="row text-center">
			<button class="btn btn-success" @click="win('good')">Good wins</button>
			<button class="btn btn-danger"@click="win('bad')">Bad wins</button>
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
			};
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch() {
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