<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Admin Pages <Button @click="addModal=true"><Icon type="md-add" /> Add admin</Button></p>

                        <div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>id</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Tipe User</th>
								<th>diBuat</th>
								<th>Aksi</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, i) in users" :key="i" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.FullName}}</td>
								<td class="">{{user.email}}</td>
								<td class="">{{user.userType}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Tooltip content="Edit" placement="left-start">
										<Button @click="showEditModal(user, i)" type="info" size="small"><Icon type="ios-create" /></Button>
									</Tooltip>
									<Tooltip content="Hapus" placement="right-start">
										<Button @click="showDeletingModal(user, i)"
                                        :loading="user.isDeleting"
                                        type="error" size="small" >
                                        <Icon type="ios-trash-outline"></Icon></Button>
									</Tooltip>
								</td>
							</tr>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                data : {
                    FullName: '',
                    email: '',
                    password: '',
                    role_id: null
                },
                users : [],
            }
        },

        async created(){
        // this.token = window.Laravel.csrfToken
		const res = await this.callApi('get', 'app/get_user')
		if(res.status==200){
			this.users = res.data
		} else {
			this.swr()
            }
        },
    }
</script>
