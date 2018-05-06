<template>
	<div class="form-inline mb-10">
		<div class="form-group" v-if="!this.poison && this.has_save">
			<label for="source">解药( 救{{ justKilled }}号玩家 )</label>
			<input type="number" class="form-control" id="source" v-model="save">
		</div>
		<div class="form-group" v-if="!this.save && this.has_poison">
			<label for="target">毒药</label>
			<input type="number" class="form-control" id="target" v-model="poison">
		</div>
		<button class="btn btn-success" @click="confirm">确定</button>
	</div>
</template>

<script>
	export default {
		props: ['game', 'justKilled', 'source', 'has_save', 'has_poison'],
		data() {
			return {
				save: this.justKilled,
				poison: ''
			};
		},

		methods: {
			confirm() {
				axios.post('/ajax/powers/execute', {
					game_id: this.game,
                    source: this.source,
                    target: this.save ? this.save : this.poison,
                    power: this.save ? 2 : 5
                }).then(response => this.onSuccess(response));
			},

			onSuccess(response) {
				let target = this.save ? this.save - 1 : this.poison - 1;
				this.$emit(this.save ? 'witchRevive' : 'witchPoisoned', target);
				this.$emit('next');
			}
		}	
	}
</script>