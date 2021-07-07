<template>
    <div class="container">
        <div class="text-right" style="margin-bottom: 20px">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="addModalOpen">Add Expense Category</button>
        </div>
        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Expense Name</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="expense_cat in expense_cats">
            <td>{{expense_cat.name}}</td>
            <td>{{expense_cat.description}}</td>
            <td class="text-center">
                <a href="javascript:void(0)" class="btn btn-info" @click='selectCat(expense_cat)'><span class="ti-pencil"></span></a>
                <a href="javascript:void(0)" class="btn btn-danger" @click="deleteCat(expense_cat)"><span class="ti-close"></span></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Expense Category</h5>
              </div>
              <form >
              <div class="modal-body">
                <div class="ajax-response">
                    <div class="ajax-message"></div>
                </div>
                <input type="hidden" name="" v-model="expense_cat_id">
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
                <button type="submit" class="btn btn-primary" @click='saveExpenseCat'>Save changes</button>
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
            
            expense_cats:[],
            expense_cat_id:0,
            name:'',
            description:'',
            
            title: 'Expense Category',
          }
        },
       
        mounted() {
            axios.get('/get-expense-category').then(response => {
                this.expense_cats = response.data;
               
            });
        },

        methods:{
            saveExpenseCat(response){
                response.preventDefault();

                let data = {
                    id: this.expense_cat_id,
                    name: this.name,
                    description: this.description
                }

                axios.post('/save-expense-cat',data).then(response => {

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
                        this.expense_cats.forEach((value,key) => {
                            if(response.data.expense_cat.id == value.id){
                                Vue.set(this.expense_cats,key,response.data.expense_cat);
                                return;
                            }
                            
                            });
                        }else{
                            Vue.set(this.expense_cats,this.expense_cats.length,response.data.expense_cat);
                            
                        }

                        setTimeout(function(){
                            $('.modal').modal('hide');
                        },1000);
                    }

                });
            },
            selectCat(expense_cat){
                $('.modal').modal('show');
                this.expense_cat_id = expense_cat.id;
                this.name = expense_cat.name;
                this.description = expense_cat.description;
            },
            addModalOpen(){
                this.expense_cat_id = '';
                this.name = '';
                this.description = '';
            },
            deleteCat(expense_cat){
                bootbox.confirm("Are you sure you want to delete?", function(result){ 
                     if(result){
                        axios.post('/delete-cat',expense_cat).then(response=> {
                            
                                this.expense_cats.forEach((value,key) => {
                                    if(expense_cat.id == value.id){
                                        this.expense_cats.splice(key,1);
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