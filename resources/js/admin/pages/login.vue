<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Login to Dashboard</h1>
                </div>
                <div class="space">
                    <Input type="email" v-model="data.email" placeholder="Email" @keyup.enter.native="login()" />
                </div>
                <div class="space">
                    <Input type="text" v-model="data.password" placeholder="password" @keyup.enter.native="login()" />
                </div>
                <div class="login_footer">
                    <Button type="primary" @click="login" :disabled="isLogging"
                        :loading="isLogging"
                    >{{isLogging ? 'Login...' : 'Login'}}</Button>
                </div>
                not registed? <router-link to="register">register here</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                data: {
                    email : '',
                    password : '',
                },
                isLogging: false,
                isLoggedIn : false,
            }
        },
        methods : {
            async login(){
                if(this.data.email.trim()=='') return this.e('Masukan Email!!')
                if(this.data.password.trim()=='') return this.e('Masukan password!!')
                if(this.data.email.length < 2) return this.e('Salah jumlah password')
                this.isLogging = true

                const res = await this.callApi('post', 'app/admin_login', this.data)
                if(res.status===200){
                    this.s(res.data.msg)
                    window.location = ('/')
                } else {
                    if(res.status===401){
                        this.i(res.data.msg)
                    }else if(res.status==402){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr(res.data.msg)
                    }
                }
                this.isLogging = false
            }
        }

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
