<template>
	<div class="text-center">
		<div class="col-xs-12">
			<div class="profile-img-container">
            	<div class="img-circle profile img-big" :style="'background-image: url(' + avatar + ');'"></div>
            </div>
        </div>
        <input class="blind-file-input" id="camera_photo" type="file" accept="image/*" @change="onAvatarChange"/>
        <label class="btn btn-primary margin-1" for="camera_photo"><i class="fa fa-camera"></i> 更新头像</label>
		<div class="form-group">
			<label for="name">名字</label>
			<input type="text" class="form-control" id="name" v-model="name">
		</div>
		<button class="btn btn-success" @click="confirmProfile">确认</button>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: false,
				selecting_photo: false,
				avatar: false,
				name: false
			};
		},

		created() {
			this.getUser();
		},

		methods: {
			getUser() {
				axios.get('/ajax/user/profile')
					.then(this.refresh);
			},

			refresh(respond){
				this.user = respond.data;
				this.avatar = this.user.avatar_path;
				this.name = this.user.name;
			},

			confirmProfile(){
				axios.post('/ajax/user/profile', {
					name: this.name
				}).then(() => location.reload());
			},

			onAvatarChange(e) {
                if(!e.target.files.length) return;

                let file = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
                    this.avatar = e.target.result;

                    this.persist(file);
                };
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/ajax/users/${this.user.id}/avatar`, data);
            }
		}	
	}
</script>