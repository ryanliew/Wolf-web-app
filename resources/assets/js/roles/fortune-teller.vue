<template>
	<div class="form-inline mb-10">
		<div class="form-group">
			<label for="source">查验</label>
			<input type="number" class="form-control" id="source" v-model="target">
		</div>
		<div v-text="role"></div>
		<button class="btn btn-success" @click="confirm">确定</button>
	</div>
</template>

<script>
	export default {
		props: ['game', 'source'],
		data() {
			return {
				target: '',
				power: '1',
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
				this.role = response.data == 'good' ? '好人' : '狼人';
			}
		},
	}
</script>