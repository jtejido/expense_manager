<template>
    <div class="container login">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form @submit="login">
                    <div class="card" data-background="color" data-color="blue">
                        <div class="card-header">
                            <h3 class="card-title">Login</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" placeholder="Enter email" class="form-control input-no-border" name="email" v-model='email'>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" placeholder="Password" class="form-control input-no-border" name="password" v-model='password'>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-fill btn-wd ">Login</button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script>
    export default {
        data(){
            return{
                email: '',
                password: '',
              }

        },
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            login(response){
                response.preventDefault();

                let data = {
                    email: this.email,
                    password: this.password
                }
                
                axios.post('/login-me',data).then(response => {
                    this.$emit('user',response.data);
                    this.$router.push('/')
                });


            }
        }
    }
</script>