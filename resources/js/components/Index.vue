<template>
	<div v-if="user">
		<div class="wrapper">
	        <side-menu @title="UpdateTitle" :user='user' @user='updateUser'></side-menu>
	        <div class="main-panel">
	            <header-menu :user='user' @user='updateUser' :title="title"></header-menu>
	            <div class="content">
	                <router-view></router-view>
	            </div>
	        </div>
	        
	    </div>
    </div>
    <div v-else>
    	<login @user='updateUser'></login>
    </div>
</template>

<script>
    export default {
    	data(){
          return{
            user: null,
            title:'Dasboard',
          }
        },
        mounted() {
            axios.get('/get-current-user').then(response => {
                this.user = response.data;
            });
        },
        methods:{
        	updateUser(response){
        		this.user = response;
        	},

        	UpdateTitle(response) {
        		this.title = response;
        	}
        }
        
    }
</script>