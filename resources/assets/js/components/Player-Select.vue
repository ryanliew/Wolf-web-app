<template>
	<li>
		<div class="flex flex-center">
			<label class="flex flex-center level" :for="'select' + player.id">
				<div class="img-circle profile img-small" :style="'background-image: url(' + player.avatar_path + ');'"></div>
				<span class="level" v-text="player.name"></span>
			</label>
			<input type="checkbox" :id="'select' + player.id" :checked="actuallySelected" @click="toggled">
		</div>
	</li>
</template>

<script>
	export default {
		props: ['player', 'initialSelection'],
		data() {
			return {
				selected: this.initialSelection,
				userSelected: false
			};
		},

		methods: {
			toggled() {
				this.selected = !this.selected;
				this.userSelected = true;
				this.$emit('selectionChanged', [this.selected, this.player.id]);
			}
		},

		computed: {
			actuallySelected() {
				return (!this.userSelected && this.initialSelection) || this.selected;
			}
		}	
	}
</script>