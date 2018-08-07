<template>
	<div>
		<div class="text-center">
			<h4>上帝: <span v-text="this.judge.name"></span></h4>
			<p><b>指示顺序:</b></p>
			
			<ul class="list-inline instructions">
				<li v-for="(role, index) in orderedRoles" :key="role.id" v-if="role.id !== 5">
					<img :src="role.avatar_path" @click="showLines(index)">
				</li>
			</ul>

			<div class="flex flex-center justify-center text-center">
				<div class="text-left">
					<b>发言玩家: <span v-text="random + '号'"></span></b><br>
					<b>发言顺序: <span v-text="sequence"></span></b>
				</div>
				<button class="btn btn-default ml-10" @click="randomSelect">随机重选</button>
			</div>

		</div>
		<div>
			<div class="d-flex flex-wrap">
				<player-details v-for="(player, index) in players" :key="player.id" :player="player" :rolesSelection="game.roles" :gameId="id" :selectedRole="selectedRole[player.id]" :is_concluded="game.is_concluded" @killed="kill(index)" @revived="revive(index)"></player-details>
			</div>
		</div>
		<div class="row text-center" v-if="!game.is_concluded">
			<button class="btn btn-success" @click="win('good')">好人获胜</button>
			<button class="btn btn-danger"@click="win('bad')">狼人获胜</button>
		</div>

		<div v-if="show_lines" class="script-dialog">
			<div class="script-content text-center">
				<img :src="this.orderedRoles[this.current_line].avatar_path"/>
				<ul>
					<li v-for="(line, index) in orderedLines" :key="line.id">
						<span v-text="line.description"></span>
					</li>
				</ul>
				
				<button class="btn btn-danger btn-small" @click="isSelecting=true">设定玩家身份</button>

				<players-select @selectionChanged="toggled" @closed="isSelecting=false" v-if="isSelecting" :players="players" :initialPlayers="initialSelectedRole"></players-select>

				<hr>
				<component :is="this.orderedRoles[this.current_line].slug" 
							:game="game.id" 
							:justKilled="just_killed" 
							:source="initialSelectedRole[0].seat"
							:witchSaved="witch_saved"
							:witchPoisoned="witch_poisoned"
							:has_save="has_save"
							:has_poison="has_poison"
							:last_guard="last_guard"
							@killed="kill" 
							@witchRevive="witchRevive"
							@witchPoisoned="witchPoisoned"
							@guarded="guarded" 
							@next="nextLine"
							@back="show_lines = false">	
				</component>
				<button class="btn btn-success" @click="nextLine">下一个</button>
				<button class="btn btn-primary" @click="show_lines = false">返回</button>
			</div>	
		</div>
	</div>
</template>

<script>
	import PlayerDetails from './Player-Details.vue';
	import PlayersSelect from './Players-Select.vue';

	export default {
		components: { PlayerDetails, PlayersSelect },

		props: ['id'],

		data() {
			return {
				players: false,
				judge: false,
				game: false,
				random: "-",
				sequence: "-",
				lines: false,
				show_lines: false,
				current_line: 0,
				isSelecting: false,
				selectedRole: [],
				initialSelectedRole: [],
				usedPowers: [],
				just_killed: 0,
				witch_saved: false,
				witch_poisoned: '',
				has_save: true,
				has_poison: true,
				last_guard: 0
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

			setGame(response) {
				this.game = response.data;
				axios.get('/ajax/game/' + this.id + '/players')
							.then(this.refresh);
			},

			refresh(response) {
				this.players = response.data;
				axios.get('/ajax/game/'+ this.id + '/judge' )
					.then(this.setJudge)
			},

			setJudge(response) {
				this.judge = response.data;
				axios.get('/ajax/game/' + this.id + '/powers')
					.then(this.setPowers);
			},

			setPowers(response) {
				this.usedPowers = response.data;
				this.processPowers();
			},

			processPowers() {
				this.has_save = _.filter(this.usedPowers, function(p){ return p.slug == 'revive'; }).length == 0;
				this.has_poison = _.filter(this.usedPowers, function(p){ return p.slug == 'poison'; }).length == 0;
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
					return n.is_alive;
				});
				var key = _.random(0, alivePlayers.length - 1);
				this.random = key + 1;

				var sequence = ["左", "右"];
				this.sequence = sequence[_.random(0, sequence.length - 1)];
			},

			kill(index) {
				this.players[index].is_alive = 0;
				this.just_killed = this.players[index].seat;

				axios.post('/ajax/game/' + this.id + '/status', {
                    user_id: this.players[index].user_id,
                    alive: false
                });
			},

			revive(index) {
				this.players[index].is_alive = 1;
				axios.post('/ajax/game/' + this.id + '/status', {
                    user_id: this.players[index].user_id,
                    alive: true
                });
			},

			witchRevive(index) {
				this.witch_saved = true;
				this.has_save = false;
				this.revive(index);
			},

			witchPoisoned(index) {
				this.witch_poisoned = index;
				this.has_poison = false;
				this.kill(index);
			},

			guarded(index) {
				this.last_guard = index;
				this.revive(index);
			},

			showLines(index) {
				this.show_lines = true;
				this.current_line = index;
				this.lines = this.orderedRoles[this.current_line].lines;
				this.initialSelectedRole = _.filter(this.players, function(o){ return o.role_id == this.currentRole.id; }.bind(this));
			},

			hideLines() {
				this.show_lines = false
			},

			nextLine() {
				this.current_line++;
				if(this.current_line == this.orderedRoles.length)
				{
					this.show_lines = false;
				}
				else
				{
					this.lines = this.orderedRoles[this.current_line].lines;
				}

				this.initialSelectedRole = _.filter(this.players, function(o){ return o.role_id == this.currentRole.id; }.bind(this));
			},

			toggled(data) {
				this.selectedRole[data[1]] = false;
				if(data[0])
				{
					this.selectedRole[data[1]] = this.currentRole;
				}

				_.find(this.players, ['id', data[1]]).role_id = data[0] ? this.currentRole.id : 10;

				axios.post('/ajax/game/' + this.game.id + '/role', {
                    user_id: data[1],
                    role_id: this.currentRole.id
                });
			}


		},

		computed: {
			orderedRoles() {
				return _.orderBy(this.game.roles, 'sequence');
			},

			orderedLines() {
				return _.orderBy(this.lines, 'sequence');
			},

			currentRole() {
				return this.orderedRoles[this.current_line];
			}
		}	


	}
</script>