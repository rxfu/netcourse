<template>
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default">
				<div class="card-header text-center bg-primary text-white">
					<h3 class="md-3 font-weight-normal">{{ assistant.name }}助教可申请课程信息</h3>
				</div>
				<div class="card-body">
						<form v-on:submit.prevent="updateCourse">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">操作</th>
									<th scope="col">ID</th>
									<th scope="col">课程名称</th>
									<th scope="col">班级名称</th>
									<th scope="col">所在校区</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="course in courses">
									<td>
										<input type="checkbox" :value="course" v-model="ids" :disabled="ids.length > 2 && ids.indexOf(course) === -1">
									</td>
									<td><i>{{ course.id }}</i></td>
									<td>{{ course.name }}</td>
									<td>{{ course.class }}</td>
									<td>{{ course.campus }}</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<button type="submit" class="btn btn-block btn-primary">提交</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('Course mounted.');
		},

		data() {
			return {
				assistant: {},
				ids: [],
				courses: []
			}
		},

		created: function() {
			this.fetchItems();
		},

		computed: {
			course_name: function() {
				return this.ids.map(course => course.name + '-' + course.class).join();
			}
		},

		methods: {
			fetchItems: function() {				
				let uri = 'api/' + this.$route.params.asid + '/courses';
				axios.get(uri).then((response) => {
					if (response.data.status == true) {
						this.assistant = response.data.assistant;
						this.courses = response.data.courses;
					} else {
						this.$router.push('fail');
					}
				}).catch((response) => {
					console.log(response.message);
					alert('Error: ' + response.message);
				});
			},

			updateCourse() {
				if (confirm('请问确定要选择教授课程（' + this.course_name + '）吗？')) {
					let uri = 'api/' + this.$route.params.asid + '/update';
					axios.post(uri, this.ids).then((response) => {
						console.log(response);
	
						if (response.data.status == true) {
							this.$router.push('success');						
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
	}
</script>