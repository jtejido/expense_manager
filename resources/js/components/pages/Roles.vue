<template>
    <div class="container">
        <div class="text-right" style="margin-bottom: 20px">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="addModalOpen">Add Roles</button>
        </div>
        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles">
            <td>{{role.type}}</td>
            <td>{{role.description}}</td>
            <td class="text-center" >
              
                <a href="javascript:void(0)" class="btn btn-info" @click='selectRole(role)' v-if="role.type !== 'Admin'"><span class="ti-pencil"></span></a>
                <a href="javascript:void(0)" class="btn btn-danger" @click="deleteRole(role)" v-if="role.type !== 'Admin'"><span class="ti-close"></span></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Roles</h5>
              </div>
              <form >
              <div class="modal-body">
                <div class="ajax-response">
                    <div class="ajax-message"></div>
                </div>
                
                <input type="hidden" name="" v-model="role_id">
                <div class="form-group ">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Name" v-model="name">
                </div>
                <div class="form-group">
                  <label for="name">Description</label>
                  <textarea class="form-control" placeholder="Description" v-model="description"></textarea>
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" @click='saveRole'>Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>


</template>
  
<script>
    export default {

        data(){
          return{
            
            roles:[],
            role_id:0,
            name:'',
            description:'',
            
            title: 'Roles',
          }
        },
       
        mounted() {
            axios.get('/get-role').then(response => {
                this.roles = response.data;
               
            });
        },

        methods:{
            saveRole(response){
                response.preventDefault();

                let data = {
                    id: this.role_id,
                    name: this.name,
                    description: this.description
                }

                axios.post('/save-role',data).then(response => {
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
                        this.roles.forEach((value,key) => {
                            if(response.data.role.id == value.id){
                                Vue.set(this.roles,key,response.data.role);
                                return;
                            }
                        });

                        }else{
                            Vue.set(this.roles,this.roles.length,response.data.role);


                        }

                        setTimeout(function(){
                            $('.modal').modal('hide');
                        },1000);
                    }


                    // if(response.data.temp){
                    //     this.roles.forEach((value,key) => {
                    //         if(response.data.role.id == value.id){
                    //             Vue.set(this.roles,key,response.data.role);
                    //             return;
                    //         }
                    //     });
                    // }else{
                    //     Vue.set(this.roles,this.roles.length,response.data.role);

                    // }

                });
            },
            selectRole(role){
                $('.modal').modal('show');
                this.role_id = role.id;
                this.name = role.type;
                this.description = role.description;
            },
            addModalOpen(){
                this.role_id = 0;
                this.name = '';
                this.description = '';
            },
            deleteRole(role){
                bootbox.confirm("Are you sure you want to delete?", function(result){ 
                     if(result){
                        axios.post('/delete-role',role).then(response=> {
                            
                                this.roles.forEach((value,key) => {
                                    if(role.id == value.id){
                                        this.roles.splice(key,1);
                                    }
                                });
                           
                         });
                     }
                }.bind(this));
                
            }

        }

    }
</script>

<style type="text/css">
    
    .modal-backdrop.in {
        
        opacity: 0!important;
    }
    .modal-backdrop {
       
        z-index: 0;
        
    }
</style>