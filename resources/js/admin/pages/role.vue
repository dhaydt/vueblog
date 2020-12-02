<template>
    <div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"><Icon type="md-unlock" /> Roles Management
						<Button @click="addModal = true" v-if="isWritePermitted" type="default" size="small"><Icon type="md-add" /> Role</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tipe Role</th>
								<th>diBuat</th>
								<th>Aksi</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i" v-if="roles.length" >
								<td>{{role.id}}</td>
								<td class="_table_name">{{role.roleName}}</td>
								<td>{{role.created_at}}</td>
								<td>
									<Tooltip content="Edit" placement="left-start">
										<Button @click="showEditModal(role, i)" v-if="isUpdatePermitted" type="info" size="small"><Icon type="ios-create" /></Button>
									</Tooltip>
									<Tooltip content="Hapus" placement="right-start">
                                        <Button type="text" v-if="isDeletePermitted" size="small" @click="showDeletingModal(role, i)"  :loading="role.isDeleting" ghost><Icon ghost type="ios-trash" /></Button>
                                    </Tooltip>
								</td>
							</tr>
						</table>
					</div>
				</div>
							<!-- ADD MODAL -->
							<Modal
								v-model="addModal"
								title="Tambah Role Baru"
								:mask-closable=false
								>
								<Input v-model="data.roleName" placeholder="Tipe Role" style="width: 300px" @keyup.enter.native="addRole()" />
                                <div class="space">
                                    <Select v-model="data.isAdmin"  placeholder="Tipe Admin">
                                        <Option value="1">Admin</Option>
                                        <Option value="0">User</Option>
                                        <!-- <Option value="Editor" >Editor</Option> -->
                                    </Select>
                                </div>
								<div slot="footer">
									<Button @click="addModal = false" type="default">Close</Button>
									<Button @click="addRole" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Tambah'}}</Button>
								</div>
							</Modal>

							<!-- Edit Modal -->
							<Modal
								v-model="editModal"
								title="Edit Role"
								:mask-closable="false"
								:closable="false"
								>
								<Input v-model="editData.id" clearable placeholder="Edit tipe Role" style="width: 300px" @keyup.enter.native="editRole()" />
								<Input v-model="editData.roleName" clearable placeholder="Edit tipe Role" style="width: 300px" @keyup.enter.native="editRole()" />

								<div slot="footer">
									<Button @click="editModal = false" type="default">Close</Button>
									<Button @click="editRole" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Editing..': 'Edit'}}</Button>
								</div>
							</Modal>

							<!-- Delete Modal -->
							<!-- <Modal v-model="showDeleteModal" width="360" :closable="true" :mask-closable="false">
								<p slot="header" style="color:#f60;text-align:center">
									<Icon type="ios-information-circle"></Icon>
									<span>Konfirmasi Hapus</span>
								</p>
								<div style="text-align:center">
									<p>Anda yakin ingin menghapus tag ini?</p>
								</div>
								<div slot="footer">
									<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Hapus</Button>
								</div>
							</Modal> -->
							<deleteModal></deleteModal>

			</div>
	</div>
    </div>
</template>

<script>
import deleteModal from "../components/deleteModal.vue";
import {mapGetters} from 'vuex'
	export default {
		data() {
			return{
				data 			: {
                                    roleName: '',
                                    isAdmin: ''
								},
				addModal 		: false,
				editModal 		: false,
				isAdding 		: false,
				roles 			: [],
				editData 		: {
                                    id: '',
                                    roleName: '',
                                    isAdmin: ''
								},
				index 			: -1,
				showDeleteModal	: false,
				isDeleting 		: false,
				deleteItem 		: {},
				deletingIndex	: -1,
				websiteSetting : [],

			}
		},


		methods : {
			//menambah data tag
			async addRole() {
				if(this.data.roleName.trim()=='') return this.e('Tipe Role belum di isi')
				if(this.data.isAdmin.trim()=='') return this.e('Tipe Admin belum di isi')
				const res = await this.callApi('post', 'app/create_role', this.data)
				if(res.status===201){
					this.roles.unshift(res.data)
					this.s('Role berhasil ditambah')
					this.addModal = false
                    this.data.roleName = ''
                    this.data.isAdmin = ''
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
			//edit data tag
			async editRole() {
                if(this.editData.roleName.trim()=='') return this.e('Tipe role belum di isi')
                if(this.editData.id=='') return this.e('Tipe Admin belum di isi')
				const res = await this.callApi('post', 'app/edit_role', this.editData)
				if(res.status===200){
					this.roles[this.index].roleName = this.editData.roleName
					this.roles[this.index].id = this.editData.id
					this.s('Tag berhasil diedit')
					this.editModal = false

				} else {
					if(res.status==442){
						if(res.data.errors.roleName){
							this.e(res.data.errors.roleName[0])
						}
					} else {
						this.swr()
					}
				}
			},


			showEditModal(role, index){
				let obj = {
					id: role.id,
					roleName: role.roleName
				}
				this.editData = obj
				this.editModal = true
				this.index = index

			},

			async deleteRole() {

				this.isDeleting = true
				const res = await this.callApi('post', 'app/delete_role', this.deleteItem)
				if(res.status===200){
					this.roles.splice(this.deletingIndex,1)
					this.s('Role berhasil dihapus!')

				}else{
					this.swr()
				}
				this.isDeleting = false
				this.showDeleteModal = false
			},

			showDeletingModal(role, i){
				const deleteModalObj = {
					showDeleteModal : true,
					deleteUrl : 'app/delete_role',
					data : role,
					deletingIndex : i,
                    isDeleted : false,
                    msg : 'Yakin ingin menghapus Role ini?',
                    successMsg : 'Role terhapus'
				}
                this.$store.commit('setDeletingModalObj', deleteModalObj)
			    console.log('delete method called')
			}
		},

	async created(){
        const res = await this.callApi('get', 'app/get_roles')
		if(res.status==200){
			this.roles = res.data
		} else {
			this.swr()
		}
	},
	components : {
		deleteModal
	},
	computed : {
		...mapGetters(['getDeleteModalObj'])
	},
	watch : {
		getDeleteModalObj(obj) {
			if(obj.isDeleted){
				this.tags.splice(obj.deletingIndex, 1)
			}
		}
	}
};
</script>
