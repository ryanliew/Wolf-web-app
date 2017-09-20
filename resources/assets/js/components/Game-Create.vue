<template>
	<div>
		<label>Judge:</label>
		<v-select 
			:debounce="500"
			:on-search="getJudge"
			:options="potential_judge"
			v-model="judge"
			placeholder="Select a judge..."
			label="name">		
		</v-select>

		<label>Players:</label>
		<v-select 
			:debounce="500"
			:on-search="getPlayers"
			:options="potential_players"
			v-model="players"
			placeholder="Select players..."
			label="name"
			multiple>		
		</v-select>

		<label>Number of players: </label><span v-text="playerNumber"></span>
		<br>
		<button class="btn btn-primary" @click="createGame">Start game</button>
	</div>
</template>

<script>
	import vSelect from "vue-select";
	export default {
		props: [''],
		
		components: {vSelect},
		
		data() {
			return {
				judge: false,
				players: false,
				potential_players: null,
				potential_judge: null
			};
		},

		created() {
			this.getJudge();
		},	

		methods: {
			getJudge(search, loading){
				loading(true);
				axios.get('/ajax/users', {
						params: {
							q: search 
						}
					}).then(resp => {
						this.potential_judge = resp.data;
						loading(false)
					});
			},

			getPlayers(search, loading){
				loading(true);
				axios.get('/ajax/players', {
						params: {
							not: this.judge.id 
						}
					}).then(resp => {
						this.potential_players = resp.data;
						loading(false)
					});
			},

			createGame(){
				var players_id = [];
				this.players.forEach(function(element){
					players_id[players_id.length] = element.id;
				});

				axios.post('/games/create', {

					judge: this.judge.id,
					players: players_id

				}).then(resp => {
					//console.log(resp);
					window.location.href = "/games/" + resp.data;
				});
			}

		},

		computed: {
			playerNumber() {
				var number = 0;

				if(this.players)
					return this.players.length;

				return number;
			}
		}

	}
</script>