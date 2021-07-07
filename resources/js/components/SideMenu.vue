   <template>
       <div class="sidebar" data-background-color="white" data-active-color="danger">

        <div class="sidebar-wrapper">
            <div class="logo text-center">
                <a href="http://www.creative-tim.com/" class="simple-text">
                    Expense Manager
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <router-link tag="a" to="/">
                        <i class="ti-dashboard"></i>
                        <p @click="ChangeTitle($event)">Dashboard</p>
                    </router-link>
                </li>
                <li class="" v-if="user.role.type === 'Admin'" >
                    <a href="user.html">
                        <i class="ti-user"></i>
                        <p>User Management</p>
                    </a>

                    <li class="" style="margin-left: 20px" v-if="user.role.type === 'Admin'">
                        <router-link tag="a" to="/roles" >
                            <i class="ti-id-badge"></i>
                            <p @click="ChangeTitle($event)">Roles</p>
                        </router-link>
                    </li>
                    <li class="" style="margin-left: 20px" v-if="user.role.type === 'Admin'">
                        <router-link tag="a" to="/users" >
                            <i class="ti-user"></i>
                            <p @click="ChangeTitle($event)">Users</p>
                        </router-link>
                    </li>
                </li>
                <li>
                     <router-link tag="a" to="" >
                        <i class="ti-view-list-alt"></i>
                        <p>Expense Management</p>
                    </router-link>

                    <li class="" style="margin-left: 20px" v-if="user.role.type === 'Admin'">
                        <router-link tag="a" to="/expense-category" >
                            <i class="ti-receipt"></i>
                            <p @click="ChangeTitle($event)">Expense Category</p>
                        </router-link>
                    </li>
                    <li class="" style="margin-left: 20px">
                        <router-link tag="a" to="/expenses" >
                            <i class="ti-money"></i>
                            <p @click="ChangeTitle($event)">Expenses</p>
                        </router-link>
                    </li>
                </li>
                
            </ul>
        </div>
    </div>
   </template>
   

<script>
    export default {
        props:['user'],

        data(){
            return {
                
            }
        },
        mounted() {
            console.log('Component mounted.')

        },

        methods:{
            ChangeTitle(event){
               
                this.$emit('title', event.toElement.innerText);
            }
        }
    }
</script>