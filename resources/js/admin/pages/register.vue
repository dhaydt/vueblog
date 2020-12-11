<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Register Admin</h1>
                </div>
                <div class="space">
                    <Input type="text" v-model="data.FullName" placeholder="Full name"  />
                </div>
                <div class="space">
                    <Input type="email" v-model="data.email" placeholder="Email"  />
                </div>
                <div class="space">
                    <Input type="text" v-model="data.password" placeholder="password"  />
                </div>
                <div class="space">
                    <Select v-model="data.role_id"  placeholder="Select admin type">
                        <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                        <!-- <Option value="Editor" >Editor</Option> -->
                    </Select>
                </div>
                <div class="login_footer">
                    <Button type="primary" @click="addAdmin" :disabled="isAdding"
                        :loading="isAdding"
                    >{{isAdding ? 'Adding...' : 'Register'}}</Button>
                </div>
                Already have account? <router-link to="login">Login here</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                data: {
                    Fullname : '',
                    email : '',
                    password : '',
                    role_id : null,
                },
                isAdding: false,
                isLoggedIn : false,
                roles : [],
            }
        },
        methods : {
            async register(){
                if(this.data.FullName.trim()=='') return this.e(' name is required')
                if(this.data.email.trim()=='') return this.e('Email is required')
                if(this.data.password.trim()=='') return this.e('password is required')
                if(!this.data.role_id) return this.e(' type  is required')
                //this.isLogging = true

                const res = await this.callApi('post', 'app/create_user', this.data)
                if(res.status===200){
                    this.users.unshift(res.data)
                    this.s('Admin user has been added successfully!')
                    window.location = ('/login')
                } else {
                    if(res.status==422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                    }else{
                        this.swr()
                    }
                }
                //this.isLogging = false
            }
        },

        async created(){
            this.token = window.Laravel.csrfToken
            const [res, resRole] = await Promise.all([
                // this.callApi('get', 'app/get_users'),
                this.callApi('get', 'app/get_roles')
            ])
            // if(res.status==200){
            //     this.users = res.data
            // } else {
            //     this.swr()
            // }
            if(resRole.status==200){
                this.roles = resRole.data
            } else {
                this.swr()
                }
        },

    }
</script>

<style lang="scss" scoped>
    ._1adminOverveiw_table_recent{
        margin: 0 auto;
        margin-top: 220px;
    }
    .login_footer{
        text-align: center;
    }
    .login_header{
        text-align: center;
        margin-bottom: 25px;
    }
</style>
