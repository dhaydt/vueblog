<template>
    <div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"><Icon type="md-pricetags" /> Tags
						<Button @click="addModal = true" v-if="isWritePermitted" type="default" size="small"><Icon type="md-add" /> Tag</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Nama Tag</th>
								<th>dibuat</th>
								<th>Aksi</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length" >
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Tooltip content="Edit" placement="left-start">
										<Button v-if="isUpdatePermitted" @click="showEditModal(tag, i)" type="info" size="small"><Icon type="ios-create" /></Button>
									</Tooltip>
									<Tooltip content="Hapus" placement="right-start">
										<Button v-if="isDeletePermitted" @click="showDeletingModal(tag, i)" :loading="tag.isDeleting" type="error" size="small" ><Icon type="ios-trash-outline"></Icon></Button>
									</Tooltip>
								</td>
							</tr>
						</table>
					</div>
				</div>
							<!-- ADD MODAL -->
							<Modal
								v-model="addModal"
								title="Tambah Tag Baru"
								:mask-closable=false
								>
								<Input v-model="data.tagName" placeholder="Nama Tag" style="width: 300px" />

								<div slot="footer">
									<Button @click="addModal = false" type="default">Close</Button>
									<Button @click="addTag" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Tambah'}}</Button>
								</div>
							</Modal>

							<!-- Edit Modal -->
							<Modal
								v-model="editModal"
								title="Edit Tag"
								:mask-closable="false"
								:closable="false"
								>
								<Input v-model="editData.tagName" placeholder="Edit Tag Name" style="width: 300px" />

								<div slot="footer">
									<Button @click="editModal = false" type="default">Close</Button>
									<Button @click="editTag" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Editing..': 'Edit'}}</Button>
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
                                    tagName: '',
								},
				addModal 		: false,
				editModal 		: false,
				isAdding 		: false,
				tags 			: [],
				editData 		: {
									tagName: ''
								},
				index 			: -1,
				showDeleteModal	: false,
				isDeleting 		: false,
				deleteItem 		: {},
				deletingIndex	: -1,
                websiteSetting : [],
                //isReadPermitted : false

			}
		},


		methods : {
			//menambah data tag
			async addTag() {
				if(this.data.tagName.trim()=='') return this.e('Tag name belum di isi')
				const res = await this.callApi('post', 'app/create_tag', this.data)
				if(res.status===201){
					this.tags.unshift(res.data)
					this.s('Tag berhasil ditambah')
					this.addModal = false
					this.data.tagName = ''
				} else {
					if(res.status==442){
						if(res.data.errors.tagName){
							this.e(res.data.errors.tagName[0])
						}
					} else {
						this.swr()
					}
				}
			},
			//edit data tag
			async editTag() {
				if(this.editData.tagName.trim()=='') return this.e('Tag name belum di isi')
				const res = await this.callApi('post', 'app/edit_tag', this.editData)
				if(res.status===200){
					this.tags[this.index].tagName = this.editData.tagName
					this.s('Tag berhasil diedit')
					this.editModal = false

				} else {
					if(res.status==442){
						if(res.data.errors.tagName){
							this.e(res.data.errors.tagName[0])
						}
					} else {
						this.swr()
					}
				}
			},


			showEditModal(tag, index){
				let obj = {
					id: tag.id,
					tagName: tag.tagName
				}
				this.editData = obj
				this.editModal = true
				this.index = index

			},

			async deleteTag() {
				this.isDeleting = true
				const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
				if(res.status===200){
					this.tags.splice(this.deletingIndex,1)
					this.s('Tag berhasil dihapus!')

				}else{
					this.swr()
				}
				this.isDeleting = false
				this.showDeleteModal = false
			},

			showDeletingModal(tag, i){
				const deleteModalObj = {
					showDeleteModal : true,
					deleteUrl : 'app/delete_tag',
					data : tag,
					deletingIndex : i,
                    isDeleted : false,
                    msg : 'Yakin ingin menghapus Tag ini?',
                    successMsg : 'Tag terhapus'
				}
				this.$store.commit('setDeletingModalObj', deleteModalObj)
				console.log('delete modal active')

				// this.deleteItem = tag
				// this.deletingIndex = i
				// this.showDeleteModal = true
			}
		},

	async created(){
        console.log(this.isWritePermitted)
        const res = await this.callApi('get', 'app/get_tags')
		if(res.status==200){
			this.tags = res.data
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
