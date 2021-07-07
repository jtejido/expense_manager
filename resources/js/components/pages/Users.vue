<template>
	<div class="container">
        <div class="text-right" style="margin-bottom: 20px">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="addUserModalOpen">Add User</button>
        </div>
        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users">
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.role.type}}</td>
            <td class="text-center" >
                <a href="javascript:void(0)" class="btn btn-info" @click="selectUser(user)" v-if="user.role.type !== 'Admin'"><span class="ti-pencil"></span></a>
                <a href="javascript:void(0)" class="btn btn-danger" @click="deleteUser(user)" v-if="user.role.type !== 'Admin'"><span class="ti-close"></span></a>
            </td>
          </tr>
          
        </tbody>

      </table>


     <!-- Modal -->
        <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
              </div>
              <div class="modal-body">
                <form>
                <div class="ajax-response">
                    <div class="ajax-message"></div>
                </div>
                <input type="hidden" name="" v-model="user_id">
                <div class="form-group ">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Name" v-model="name">
                </div>
                <div class="form-group ">
                  <label for="email">Email Address</label>
                  <input type="text" class="form-control" id="email" placeholder="Email Address" v-model="email"> 
                </div>
                <div class="form-group ">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" v-model="password"> 
                </div>
                <div class="form-group">
			      <label for="inputState">Roles</label>
			      <select id="inputState" class="form-control" v-model="role_id">
			        <option selected>Choose...</option>
			        <option v-for="role in roles" :value="role.id">{{role.type}}</option>
			      </select>
			    </div>
                    
                </form>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="saveUser">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>



<script>
    export default {

    	 data(){
          return{
          	users:[],
            roles:[],
            title: 'Users',
            user_id: 0,
            name:'',
            email:'',
            role_id:'',
            password:''

          }
        },
     

        mounted() {
            axios.get('/get-role').then(response => {
                this.roles = response.data;
               
            });

            axios.get('/get-user').then(response => {
                this.users = response.data;
               
            });
        },

        methods:{
        	saveUser(response){
        		response.preventDefault();

        		let data1 = {
                    id: this.user_id,
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role_id: this.role_id,
                }

                axios.post('/save-user',data1).then(response =>{
                  if(response.data.status){
                      
                      let html = '<div class="alert alert-danger mb-4">';
                        html += '<ul class="list-unstyled mb-0">';
                        response.data.message.forEach((value, key) => {
                            html += '<li>'+ value +'</li>';
                        });
                        html += '</ul>\
                            </div>';

                        $('.ajax-response').show();
                        $('.ajax-message').html(html);

                        setTimeout(function(){
                            $('.ajax-response').fadeOut();
                        },5000);

                    }else{
                      if(response.data.temp){
                        this.users.forEach((value,key) => {
                            if(response.data.user.id == value.id){
                                Vue.set(this.users,key,response.data.user);
                                return;
                            }
                        });

                        setTimeout(function(){
                                $('.modal').modal('hide');
                            },1000);
                        
                        }else{
                            Vue.set(this.users,this.users.length,response.data.user);
                            setTimeout(function(){
                                $('.modal').modal('hide');
                            },1000);
                        }


                        setTimeout(function(){
                            $('.modal').modal('hide');
                        },1000);
                    }




                	
                });
        	},

        	selectUser(data){
                $('.modal').modal('show');
                this.user_id = data.id;
                this.name = data.name;
                this.email = data.email;
                this.role_id = data.role_id;

            },
            addUserModalOpen(){
                this.user_id = '';
                 this.name = '';
                this.email = '';
                this.role_id = '';
            },

            deleteUser(user){
                bootbox.confirm("Are you sure you want to delete?", function(result){ 
                     if(result){
                        axios.post('/delete-user',user).then(response=> {
                            
                                this.users.forEach((value,key) => {
                                    if(user.id == value.id){
                                        this.users.splice(key,1);
                                    }
                                });
                           
                         });
                     }
                }.bind(this));
                
            }
        }

    }
</script>

