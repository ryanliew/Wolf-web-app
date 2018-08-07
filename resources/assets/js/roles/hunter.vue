<template>
	<div class="form-inline mb-10">
		<div class="form-group">
			<label for="source">猎杀</span></label>
			<input type="number" class="form-control" id="source" v-model="target">
		</div>
		<button class="btn btn-success" @click="confirm">确定</button>
	</div>
</template>

<script>
	export default {
		props: ['game', 'source'],
		data() {
			return {
				target: '',
				power: '6'
			};
		},

		methods: {
			confirm() {
				axios.post('/ajax/powers/execute', {
					game_id: this.game,
                    source: this.source,
                    target: this.target,
                    power: this.power
                }).then(response => this.onSuccess(response));
			},

			onSuccess(response) {
				this.$emit('killed', this.target - 1);
				this.$emit('back');
			}
		},
	}
</script>