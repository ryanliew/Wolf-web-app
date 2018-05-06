<template>
	<li>
		<div class="flex flex-center">
			<label class="flex flex-center level" :for="'select' + user.id">
				<div class="img-circle profile img-small" :style="'background-image: url(' + user.avatar_path + ');'"></div>
				<span class="level" v-text="user.name"></span>
			</label>
			<input type="checkbox" :id="'select' + user.id" :checked="actuallySelected" @click="toggled">
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
				this.$emit('selectionChanged', [this.selected, this.user.user_id]);
			}
		},

		computed: {
			actuallySelected() {
				return (!this.userSelected && this.initialSelection) || this.selected;
			},

			user() {
				return this.player.user ? this.player.user : this.player;
			}
		}	
	}
</script>