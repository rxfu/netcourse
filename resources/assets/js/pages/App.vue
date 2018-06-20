<template>
	<div>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a href="#" class="navbar-brand">网络课程管理系统</a>			
		    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarReponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		    	<span class="navbar-toggler-icon"></span>
		    </button>

		    <div class="navbar navbar-collapse" id="navbarResponsive">
		    	<ul class="navbar-nav mr-auto">
		    		<li class="nav-item">
		    			<a href="#" class="nav-link">登录</a>
		    		</li>
		    		<li class="nav-item">
		    			<a href="#" class="nav-link">申请</a>
		    		</li>
		    	</ul>
		    </div>
		</nav>
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