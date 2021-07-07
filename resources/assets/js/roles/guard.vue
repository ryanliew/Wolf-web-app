<template>
	<div class="form-inline mb-10">
		<div class="form-group">
			<label for="source">守护 <span v-if="last_guard">(不能守护{{ last_guard }}号玩家)</span></label>
			<input type="number" class="form-control" id="source" v-model="target">
		</div>
		<button class="btn btn-success" @click="confirm">确定</button>
	</div>
</template>

<script>
	export default {
		props: ['game', 'source', 'last_guard'],
		data() {
			return {
				target: '',
				power: '18',
				role: ''
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
				this.$emit('guarded', this.target - 1);
				this.$emit('next');
			}
		},
	}
</script>