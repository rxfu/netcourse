<template>
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default">
				<div class="card-header text-center bg-primary text-white">
					<h3 class="md-3 font-weight-normal">请助教输入相关信息</h3>
				</div>
				<div class="card-body">
					<form v-on:submit.prevent="addAssistant">
						<div class="form-group row">
							<label for="card_id" class="col-md-2 col-form-label text-right">工号</label>
							<div class="col-md-10">
								<input type="text" id="card_id" name="card_id" class="form-control" placeholder="工号" required autofocus v-model="assistant.card_id">
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-md-2 col-form-label text-right">姓名</label>
							<div class="col-md-10">
								<input type="text" id="name" name="name" class="form-control" placeholder="姓名" required v-model="assistant.name">
							</div>
						</div>
						<div class="form-group row">
							<label for="department_id" class="col-md-2 col-form-label text-right">学院</label>
							<div class="col-md-10">
								<select name="department_id" class="form-control" required v-model="assistant.department_id">
									<option disabled value="">请选择</option>
									<option v-for="department in departments" v-bind:value="department.id">
										{{ department.name }}
									</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="major" class="col-md-2 col-form-label text-right">专业</label>
							<div class="col-md-10">
								<input type="text" id="major" name="major" class="form-control" placeholder="专业" v-model="assistant.major">
							</div>
						</div>
						<div class="form-group row">
							<label for="phone" class="col-md-2 col-form-label text-right">联系电话</label>
							<div class="col-md-10">
								<input type="text" id="phone" name="phone" class="form-control" placeholder="联系电话" required v-model="assistant.phone">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-10 offset-md-2">
								<button type="submit" class="btn btn-primary">申请</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('Assistant mounted.');
		},

		data() {
			return {
				assistant: {
					department_id: ''
				},
				departments: []
			}
		},

		created: function() {
			this.fetchItems();
		},

		methods: {
			fetchItems() {
				let uri = 'api/departments';
				axios.get(uri).then((response) => {
					this.departments = response.data;
				}).catch((response) => {
					console.log(response.message);
					alert('Error: ' + response.message);
				});
			},

			addAssistant() {
				let uri = 'api/apply';
				axios.post(uri, this.assistant).then((response) => {
					console.log(response);

					if (response.data.status == true) {
						this.$router.push({
							name: 'course',
							params: {
								asid: this.assistant.card_id
							}
						});						
					} else {
						this.$router.push('fail');
					}
				}).catch((response) => {
					console.log(response.message);
					alert('Error: ' + response.message);
				})
			}
		}
	}
</script>