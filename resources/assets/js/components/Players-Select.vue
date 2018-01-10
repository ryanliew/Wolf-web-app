<template>
	<div class="popup-selector">
		<div class="text-center">
			<h4>选择玩家</h4>
		</div>
		<div class="list-parent">
			<ul class="list-unstyled">
				<player-select v-for="(player, index) in players" :key="player.id" :player="player" :initialSelection="isSelectedInitially(player.id)" @selectionChanged="selectionChanged"></player-select>
			</ul>
		</div>
		<button class="btn btn-primary btn-full" @click="close">确定</button>
	</div>
</template>

<script>
	import PlayerSelect from "./Player-Select.vue";
	export default {
		props: ['players', 'initialPlayers'],

		components: { PlayerSelect },

		data() {
			return {

			};
		},

		methods: {
			isSelectedInitially(player) {
				return _.find(this.initialPlayers, ['id', player]) ? true : false;
			},

			close() {
                this.$emit('closed');
			},

			selectionChanged(data) {
				this.$emit('selectionChanged', data);
			}
		}	
	}
</script>