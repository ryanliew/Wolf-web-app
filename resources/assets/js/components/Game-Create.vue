<template>
	<div class="game-create">
		<label>上帝:</label>
		<v-select 
			:debounce="500"
			:on-search="getJudge"
			:options="potential_judge"
			v-model="judge"
			:on-change="refreshPlayers"
			placeholder="请选择上帝..."
			label="name">		
		</v-select>
		<br>
		<label>玩家:</label>
		<button class="btn btn-primary" @click="isSelecting=true">选择玩家</button>
		
		<players-select @selectionChanged="toggled" @closed="isSelecting=false" v-show="isSelecting" :players="potential_players" :initialPlayers="this.previous_players"></players-select>
		<br>

		<label>总人数: </label> <span v-text="this.players.length"></span>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<label>开启身份:</label>
				<fieldset class="text-center margin-1">
					<div class="panel-egypt background-good margin-1">
						<div class="panel-body">
							<h4>好人阵营</h4>
							<ul class="list-inline">
								<li class="role" v-for="(role, index) in roles" :key="role.id" v-if='role.type == "good"'>
									<input type="checkbox" :id="role.id" :value="role.id" v-model="selected_roles">
									<label :for="role.id">
										<img :src="role.avatar_path" class="img-responsive">
									</label>
								</li>
							</ul>
						</div>
					</div>
					<div class="panel-egypt background-bad margin-1">
						<div class="panel-body">
							<h4>狼人阵营</h4>
							<ul class="list-inline">
								<li class="role" v-for="(role, index) in roles" :key="role.id" v-if='role.type == "bad"'>
									<input type="checkbox" :id="role.id" :value="role.id" v-model="selected_roles">
									<label :for="role.id">
										<img :src="role.avatar_path" class="img-responsive">
									</label>
								</li>
							</ul>
						</div>
					</div>
					
				</fieldset>
			</div>
		</div>
		<div class="row text-center">
			<button class="btn btn-primary" @click="createGame">开始游戏</button>
			<button class="btn btn-success" @click="create_player = true">增添玩家</button>
		</div>

		<div class="roles-list" v-if="create_player">
			<input class="form-control" type="text" placeholder="新玩家名字" v-model="new_name">
			<hr>
			<button class="btn btn-success" @click="createPlayer">确定</button>
			<button class="btn btn-danger" @click="create_player = false">返回</button>
		</div>
	</div>
</template>

<script>
	import vSelect from "vue-select";
	import PlayersSelect from "./Players-Select.vue";
	export default {
		props: [''],
		
		components: {vSelect, PlayersSelect},
		
		data() {
			return {
				judge: false,
				players: [],
				potential_players: [],
				potential_judge: [],
				previous_players: [],
				create_player: false,
				new_name: "",
				roles: [],
				selected_roles: [5,6],
				isSelecting: false
			};
		},

		created() {
			axios.get('/ajax/users')
				.then(resp => {
					this.potential_judge = resp.data;
					this.players = [];
			});

			axios.get('/ajax/roles')
				.then(resp => {
					this.roles = resp.data;
				});

			axios.get('/ajax/user/profile')
				.then(resp => {
					this.judge = resp.data;
					axios.get('/ajax/previous-players')
					.then(resp => {
						//Vue.set(this.previous_players, resp.data);
						this.previous_players = resp.data;
						this.players = resp.data.map(a => a.id);
					});
				});

			
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
						this.players = [];
						loading(false)
					});
			},

			refreshPlayers(judge){
				this.judge = judge;
				this.players = [];
				axios.get('/ajax/players', {
					params: {
						not: this.judge.id 
					}
				}).then(resp => {
					this.potential_players = resp.data;
					
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
					loading(false);
				});
			},

			createGame(){
				axios.post('/games/create', {

					judge: this.judge.id,
					players: this.players,
					roles: this.selected_roles

				}).then(resp => {
					//console.log(resp);
					window.location.href = "/game/" + resp.data;
				});
			},

			createPlayer(){
				axios.post('/ajax/players/create', {
					name: this.new_name,
				}).then(resp => {
					this.create_player = false;
					this.new_name = "";
					this.getJudge();
				});
			},

			toggled(data) {
				if(data[0] && !this.players.includes(data[1]))
					this.players.push(data[1]);
				else if(!data[0] && this.players.includes(data[1]))
					_.remove(this.players, function(id){
						return id == data[1];
					});
			}


		}

	}
</script>