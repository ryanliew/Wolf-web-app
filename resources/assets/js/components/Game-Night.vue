<template>
	<div class="text-center night-info" :class="nightClass">
		<h2 v-if="night">第{{ night }}晚</h2>
		<h3 v-if="deads.length > 0">死亡玩家： {{ deads.join(",") }}</h3>
		<h3 v-else>平安夜</h3>
		<button class="btn btn-primary" @click="$emit('next')">下一晚</button>
	</div>
</template>

<script>
	export default {
		props: ['night', 'scrollY', 'deads'],
		
		data() {
			return {
				nightClass: [],
				originalTop: 0
			};
		},

		mounted() {
			this.originalTop = this.$el.getBoundingClientRect().top;
		},

		methods: {
			nextNight() {
				this.$emit("next");
			}
		},

		watch: {
			scrollY(newVal) {
				const rect = this.$el.getBoundingClientRect();
		        const newTop = this.scrollY + 20 - this.originalTop;

		        if (newTop > 0 && !this.nightClass.includes("fixed")) {
		          this.nightClass.push('fixed');
		        } else if(newTop <= 0 ){
		          this.nightClass.splice(0);
		        }
			}
		}
	}
</script>