<template>
	<div class="form-inline mb-10">
		<div class="form-group">
			<label for="source">主刀</label>
			<input type="number" class="form-control" id="source" v-model="source">
		</div>
		<div class="form-group">
			<label for="target">被刀</label>
			<input type="number" class="form-control" id="target" v-model="target">
		</div>
		<button class="btn btn-success" @click="confirm">确定</button>
	</div>
</template>

<script>
	export default {
		props: ['game'],
		data() {
			return {
				source: '',
				target: '',
				power: '9'
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
				this.$emit('next');
			}
		}	
	}
</script>