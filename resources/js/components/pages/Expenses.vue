<template>
	<div class="container">
        <div class="text-right" style="margin-bottom: 20px">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="addUserModalOpen">Add Expense</button>
        </div>
        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Expense Category</th>
            <th>Amount</th>
            <th>Entry Date</th>
            <th>Action</th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="expense in expenses">
            <td>{{expense.expense_cat.name}}</td>
            <td>{{expense.amount_expense}}</td>
            <td>{{expense.entry_date}}</td>
            <td class="text-center">
                <a href="javascript:void(0)" class="btn btn-info" @click="selectExpense(expense)"><span class="ti-pencil"></span></a>
                <a href="javascript:void(0)" class="btn btn-danger" @click="deleteExpense(expense)"><span class="ti-close"></span></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
              </div>
              <div class="modal-body">
                <form>
                <div class="ajax-response">
                    <div class="ajax-message"></div>
                </div>
                <input type="hidden" name="" v-model="expense_id">
                <div class="form-group">
                  <label for="inputState">Expense Category</label>
                  <select id="inputState" class="form-control" v-model="expense_cat_id">
                    <option selected>Choose...</option>
                    <option v-for="expense_cat in expense_cats" :value="expense_cat.id">{{expense_cat.name}}</option>
                  </select>
                </div>
                <div class="form-group ">
                  <label for="email">Amount</label>
                  <input type="number" class="form-control" id="amount" placeholder="Amount" v-model="amount"> 
                </div>
                <div class="form-group ">
                  <label for="Entry Date">Entry Date</label>
                  <input type="date" class="form-control" id="date" placeholder="Date Entry" v-model="date"> 
                </div>
                
                    
                </form>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="saveExpense">Save changes</button>
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
          	expenses:[],
            expense_cats:[],
            expense_id:0,
            expense_cat_id:'',
            amount:'',
            date:'',
            
          }
        },
     

        mounted() {
            axios.get('/get-expenses').then(response => {
                this.expenses = response.data;
               
            });

            axios.get('/get-expense-category').then(response => {
                this.expense_cats = response.data;
               console.log(response.data);
            });

        },

        methods:{
        	saveExpense(response){
        		response.preventDefault();

        		let data1 = {
                    expense_id: this.expense_id,
                    expense_cat_id: this.expense_cat_id,
                    date: this.date,
                    amount: this.amount
                    
                }

                axios.post('/save-expense',data1).then(response =>{

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
                        this.expenses.forEach((value,key) => {
                            if(response.data.expense.id == value.id){
                                Vue.set(this.expenses,key,response.data.expense);
                                return;
                            }
                        });

                      }else{
                          Vue.set(this.expenses,this.expenses.length,response.data.expense);
                          
                      }
                      setTimeout(function(){
                          $('.modal').modal('hide');
                      },1000);
      
                    }

                });
        	},

        	selectExpense(data){
                $('.modal').modal('show');
                this.expense_id = data.id
                this.expense_cat_id = data.expense_cat_id;
                this.amount = data.amount_expense;

                this.date = data.entry_date;
                

            },
          addUserModalOpen(){
                this.expense_id = '';
                this.expense_cat_id = '';
                this.amount = '';

                this.date = '';
            },

            deleteExpense(expense){
                bootbox.confirm("Are you sure you want to delete?", function(result){ 
                     if(result){
                        axios.post('/delete-expense',expense).then(response=> {
                            
                                this.expenses.forEach((value,key) => {
                                    if(expense.id == value.id){
                                        this.expenses.splice(key,1);
                                    }
                                });
                           
                         });
                     }
                }.bind(this));
                
            }
        }

    }
</script>

