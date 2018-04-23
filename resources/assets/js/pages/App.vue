<template>
	<div>
		<header class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center text-primary" style="margin: 30px 0">网络课程助教申请系统</h1>
				</div>
			</div>
		</header>
		<main role="main" class="container">
			<router-view></router-view>
		</main>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('App mounted.')
		}
	}
</script>