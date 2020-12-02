<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"><Icon type="md-contacts" /> Administrator <Button v-if="isWritePermitted" @click="addModal=true"><Icon type="md-add" /> User</Button></p>

                        <div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>id</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Tipe</th>
								<th>diBuat</th>
								<th>diubah</th>
								<th>Aksi</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, i) in users" :key="i" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.FullName}}</td>
								<td class="">{{user.email}}</td>
								<td class="">{{user.role_id}}</td>
								<td>{{user.created_at}}</td>
								<td>{{user.updated_at}}</td>
								<td>
									<Tooltip content="Edit" placement="left-start">
										<Button @click="showEditModal(user, i)" v-if="isUpdatePermitted" type="info" size="small"><Icon type="ios-create" /></Button>
									</Tooltip>
									<Tooltip content="Hapus" placement="right-start">
										<Button @click="showDeletingModal(user, i)"
                                        :loading="user.isDeleting"
                                        v-if="isDeletePermitted"
                                        type="error" size="small" >
                                        <Icon type="ios-trash-outline"></Icon></Button>
									</Tooltip>
								</td>
							</tr>
						</table>
					</div>
                </div>

                <!-- tag adding modal -->
				<Modal
					v-model="addModal"
					title="Tambah Admin"
					:mask-closable="false"
					:closable="false"

					>
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
                    <div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add admin'}}</Button>
					</div>

				</Modal>

                <!-- Edit Modal -->
                <Modal
                    v-model="editModal"
                    title="Edit User"
                    :mask-closable="false"
                    :closable="false"
                    >
                    <div class="space">
                        <Input v-model="editData.FullName" placeholder="Ganti nama" />
                    </div>

                    <div class="space">
                        <Input v-model="editData.email" placeholder="Ganti email" />
                    </div>

                    <div class="space">
                        <Input type="text" v-model="editData.password" placeholder="password"  />
                    </div>

                    <div class="space">
                        <Select v-model="editData.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button @click="editModal = false" type="default">Close</Button>
                        <Button @click="editAdmin" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Editing..': 'Edit'}}</Button>
                    </div>
                </Modal>

                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import deleteModal from "../components/deleteModal";
    export default {
        data(){
            return {
                data : {
                    FullName: '',
                    email: '',
                    password: '',
                    role_id: null
                },
                addModal: false,
                editModal: false,
                isAdding: false,
                users : [],
                editData : {
                    FullName: '',
                    email: '',
                    password: '',
                    role_id: null
                },
                index : -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                websiteSetting: [],
                roles : [],
            }
        },

        methods: {
            async addAdmin(){
            if(this.data.FullName.trim()=='') return this.e(' name is required')
            if(this.data.email.trim()=='') return this.e('Email is required')
			if(this.data.password.trim()=='') return this.e('password is required')
            if(!this.data.role_id) return this.e(' type  is required')

			const res = await this.callApi('post', 'app/create_user', this.data)
			if(res.status===201){
				this.users.unshift(res.data)
				this.s('Admin user has been added successfully!')
				this.addModal = false
				this.data.FullName = ''
				this.data.email = ''
				this.data.password = ''
				this.data.role_id = null
			}else{
				if(res.status==422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
				}else{
					this.swr()
				}

			}
        },

        //edit data tag
			async editAdmin() {
				if(this.editData.FullName.trim()=='') return this.e('Nama diisi dulu!')
				if(this.editData.email.trim()=='') return this.e('Email belum di isi')
				if(this.editData.password=='') return this.e('password belum di isi')
				if(!this.editData.role_id) return this.e('Tipe user belum di isi')
				const res = await this.callApi('post', 'app/edit_user', this.editData)
				if(res.status===200){
					this.users[this.index] = this.editData
					this.s('Admin berhasil diedit')
					this.editModal = false

				} else {
					if(res.status==442){
						for(let i in res.data.errors){
							this.e(res.data.errors[i][0])
						}
					} else {
						this.swr()
					}
				}
            },

            showEditModal(user, index){
				let obj = {
					id: user.id,
                    FullName: user.FullName,
                    email: user.email,
                    password: user.password,
                    role_id: user.role_id
				}
				this.editData = obj
				this.editModal = true
				this.index = index

            },
            showDeletingModal(user, i){
				const deleteModalObj = {
					showDeleteModal : true,
					deleteUrl : 'app/delete_user',
					data : user,
					deletingIndex : i,
                    isDeleted : false,
                    msg : 'Yakin ingin menghapus User ini?',
                    successMsg : 'User terhapus'
				}
				this.$store.commit('setDeletingModalObj', deleteModalObj);
				console.log('delete modal active')
				// this.deleteItem = category
				// this.deletingIndex = i
				// this.showDeleteModal = true
			},
    },

        async created(){
            this.token = window.Laravel.csrfToken
            const [res, resRole] = await Promise.all([
                this.callApi('get', 'app/get_users'),
                this.callApi('get', 'app/get_roles')
            ])
            if(res.status==200){
                this.users = res.data
            } else {
                this.swr()
            }
            if(resRole.status==200){
                this.roles = resRole.data
            } else {
                this.swr()
                }
        },

        components : {
		deleteModal
	},
	computed : {
		...mapGetters(["getDeleteModalObj"])
	},
	watch : {
		getDeleteModalObj(obj) {
			if (obj.isDeleted) {
				this.users.splice(obj.deletingIndex, 1);
			}
		}
	}
    }
</script>
