<template>
	<div>
		<main role="main" class="container">
			<h1 class="text-center">网络课程助教申请系统</h1>
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