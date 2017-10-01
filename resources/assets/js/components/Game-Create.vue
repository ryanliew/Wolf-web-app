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

		<label>玩家:</label>
		<v-select 
			:debounce="500"
			:on-search="getPlayers"
			:options="potential_players"
			v-model="players"
			placeholder="请选择玩家..."
			label="name"
			multiple>		
		</v-select>

		<label>总人数: </label> <span v-text="playerNumber"></span>
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
	
	export default {
		props: [''],
		
		components: {vSelect},
		
		data() {
			return {
				judge: false,
				players: false,
				potential_players: [],
				potential_judge: [],
				create_player: false,
				new_name: "",
				roles: [],
				selected_roles: [],
			};
		},

		created() {
			axios.get('/ajax/users')
				.then(resp => {
					this.potential_judge = resp.data;
					this.players = false;
			});

			axios.get('/ajax/roles')
				.then(resp => {
					this.roles = resp.data;
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
						this.players = false;
						loading(false)
					});
			},

			refreshPlayers(judge){
				this.judge = judge;
				this.players = false;
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
				var players_id = [];
				this.players.forEach(function(element){
					players_id[players_id.length] = element.id;
				});

				axios.post('/games/create', {

					judge: this.judge.id,
					players: players_id,
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