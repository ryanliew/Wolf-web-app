<template>
	<div class="role-select">
		<div class="seat-display text-center" v-if="!start">
			<h2>玩家座位</h2>
			<div class="players-seat">
				<div class="flex flex-center" v-for="(player, index) in orderedPlayers" :key="player.id">
					<span class="mr-15"v-text="player.seat"></span>
					<div :style="'background-image: url(' + player.user.avatar_path + ');'" class="img-responsive img-circle profile img-small"></div>
					<span v-text="player.user.name"></span>
				</div>
			</div>

			<button class="btn btn-primary" @click="start = true">开始身份抽取</button>
		</div>
		<div v-if="start" class="slider-container" v-scroll:throttle="{fn: onScroll, throttle: 500 }">
			<div class="slider text-center" v-if="blocked">
				<p class="mb-10">请把手机交给</p>
				<h2 v-text="currentPlayer.user.name"></h2>
				<div class="img-circle profile player-detail mb-30" :style="'background-image: url(' + currentPlayer.user.avatar_path + ');'"></div>
				<div class="confirm-btn text-center">
					<button class="btn btn-warning" v-if="!loadingComplete" @click="show" v-html="showText"></button>
				</div>
				<p v-if="loadingComplete" class="scroll-up text-center"><i class="fa fa-angle-double-up fa-2x"></i><br>请向上滑</p>
				<div class="slider-show" v-if="loadingComplete"></div>
			</div>
			<div class="role text-center" :class="roleActive">
				<p class="mb-10">你的身份是</p>
				<h2 v-text="currentRole.translated_name"></h2>
				<div class="img-circle profile player-detail mb-30" :style="'background-image: url(' + currentRole.avatar_path + ');'"></div>
				<div class="confirm-btn text-center">
					<button class="btn btn-warning" v-if="loadingComplete" @click="pass" v-html="showText"></button>
				</div>
				
			</div>
		</div> 
	</div>
</template>

<script>
	export default {
		props: ['id'],
		data() {
			return {
				start: false,
				currentPlayer: false,
				currentRole: false,
				players: [],
				loading: true,
				game: false,
				judge: false,
				seat: 0,
				blocked: true,
				showText: "读取身份",
				orderedPlayers: [],
				loadingComplete: false,
				isRoleActive: false
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
				this.orderedPlayers = _.orderBy(this.players, ['seat']);
				axios.get('/ajax/game/'+ this.id + '/judge' )
					.then(this.setJudge);
				this.setPlayer();
			},

			setGame(response) {
				this.game = response.data;
				axios.get('/ajax/game/' + this.id + '/players')
							.then(this.refresh);
			},

			setJudge(response) {
				this.judge = response.data;
			},

			setPlayer() {
				this.currentPlayer = this.orderedPlayers[this.seat];
			},

			pass() {
				if(this.seat + 1 == this.players.length)
				{
					this.currentPlayer = {user:this.judge};
					this.showText = "开始游戏";
					this.blocked = true;
					this.loadingComplete = false;
				}
				else
				{
					this.showText = "读取身份";
					this.seat++;
					this.setPlayer();
					this.blocked = true;
					window.scrollTo(0,0);
					this.loadingComplete = false;
				}
			},

			show() {
				if(this.currentPlayer.user.pivot && this.currentPlayer.user.pivot.role_id == 1)
				{
					window.location.replace('/game/' + this.id);
				}
				else if(this.loadingComplete)
				{
					this.pass();
				}
				else
				{
					this.showText = '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>';
	                axios.get('/ajax/game/' + this.id + '/player/role', {
	                    params: {
	                        user_id: this.currentPlayer.user.id
	                    }
	                }).then((resp) => { this.currentRole = resp.data; this.loadingComplete = true; this.showText = "确认身份"; });
	            }
            },

            onScroll(e, position)
            {
            	if(position.scrollTop > 500)
            		e.target.scrollTop = e.target.scrollHeight;
            	this.isRoleActive = position.scrollTop > 500;
            }


		},

		computed: {
			roleActive() {
				return this.isRoleActive ? 'active' : '';
			}
		}
	}
</script>