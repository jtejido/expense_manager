<template>
	<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="#">{{title}}</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-panel"></i>
						<p>Stats</p>
                    </a>
                </li> -->
                <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-user"></i>
                            <p class="notification"></p>
							<p>{{user.name}}</p>
							<b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                        
                        <li><router-link tag="a" to="/change-password"><i class="ti-id-badge"></i> Change Password</router-link></li>
                        <li><a href="#" @click="logout()"><i class="ti-power-off"></i> Log-out</a></li>
                        <!-- <li @click="logout()"><router-link tag="a" to="/" ><i class="ti-power-off"></i> Log-out</router-link></li> -->
                        
                        
                      </ul>
                </li>
				<!-- <li>
                    <a href="#">
						<i class="ti-settings"></i>
						<p>Settings</p>
                    </a>
                </li> -->
            </ul>

        </div>
    </div>
</nav>
</template>

<script>
    export default {
        props: ['user','title'],
        
        mounted() {
            console.log('Component mounted.')
        },

        methods:{
            logout(){

                axios.get('/logout').then(response => {
                    this.$emit('user',null);
                });
            },
        }


    }
</script>