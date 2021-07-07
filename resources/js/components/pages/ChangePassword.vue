<template>
	<div class="container">
        <form>
	        <div class="form-group ">
	          <label for="password">Current Password</label>
	          <input type="password" class="form-control" id="password" placeholder="Current Password" v-model="current_password"> 
	        </div>
	        <div class="form-group ">
	          <label for="password">New Password</label>
	          <input type="password" class="form-control" id="password" placeholder="New Password" v-model="new_password"> 
	        </div>
	        <div class="form-group ">
	          <label for="password">Confirm Password</label>
	          <input type="password" class="form-control" id="password" placeholder="Confirm Password" v-model="confirm_password"> 
	        </div>
        </form>

        <div class="text-right">
        	<button type="button" class="btn btn-primary" @click="changePassword">Save changes</button>
        </div>
                
    </div>
</template>



<script>
    export default {

    	data(){
          return{
            user: null,
          
            title: 'Change Password',
            current_password: '',
            new_password: '',
            confirm_password: '',
          }
        },
 
    
        mounted() {
            
        },

        methods: {

        	changePassword(){
                let data = {
                    current_password: this.current_password,
                    new_password: this.new_password,
                    confirm_password: this.confirm_password
                };

                axios.post('/user/change-password',data).then(response => {
                    if(response.status == 200){
                    	bootbox.alert("Successfully Change Password");
                        
                    }else{
                    	bootbox.alert("Error Changing Passowrd");
                       
                    }
                });
            }
        }

        
 }

   
</script>

