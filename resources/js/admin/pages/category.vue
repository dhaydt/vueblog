<template>
    <div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"><Icon type="ios-grid" />Kategori Blog <Button @click="addModal = true" type="default" size="small">
                        <Icon type="md-add" /> Kategori</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>id</th>
								<th>Logo</th>
								<th>Nama Kategori</th>
								<th>dibuat</th>
								<th>Pilihan</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categoryLists" :key="i" v-if="categoryLists.length">
								<td>{{category.id}}</td>
								<td class="table_image">
									<img :src="category.iconImage">
								</td>
								<td class="_table_name">{{category.categoryName}}</td>
								<td>{{category.created_at}}</td>
								<td>
									<Tooltip content="Edit" placement="left-start">
										<Button @click="showEditModal(category, i)" type="info" size="small"><Icon type="ios-create" /></Button>
									</Tooltip>
									<Tooltip content="Hapus" placement="right-start">
										<Button @click="showDeletingModal(category, i)"
                                        :loading="category.isDeleting"
                                        type="error" size="small" >
                                        <Icon type="ios-trash-outline"></Icon></Button>
									</Tooltip>
								</td>
							</tr>
						</table>
					</div>
				</div>
							<!-- ADD Category -->
							<Modal
								v-model="addModal"
								title="Tambah Kategori Baru"
								:mask-closable=false
								>

								<Input v-model="data.categoryName" placeholder="Nama Kategori" />
                                <div class="space"></div>
                                <Upload
                                    ref="uploads"
                                    type="drag"
                                    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                    :on-success="handleSuccess"
                                    :on-error="handleError"
                                    :max-size="2048"
                                    :on-exceeded-size="handleMaxSize"
                                    action="/app/upload">

                                    <div style="padding: 20px 0">
                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                        <p>Pilih atau seret Gambar Ikon</p>
                                    </div>
                                </Upload>
                                <div class="demo-upload-list" v-if="data.iconImage">
                                    <img :src="`${data.iconImage}`" >
									<div class="demo-upload-list-cover">
										<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
									</div>
                                </div>
								<div slot="footer">
									<Button @click="addModal = false" type="default">Close</Button>
									<Button @click="addCategory" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Tambah'}}</Button>
								</div>
							</Modal>

							<!-- Edit Modal -->
							<Modal
								v-model="editModal"
								title="Edit Kategori"
								:mask-closable="false"
								:closable="false"
								>
								<Input v-model="editData.categoryName" placeholder="Nama Kategori" />
                                <div class="space"></div>
                                <Upload v-show="isIconImageNew"
                                    ref="editDataUploads"
                                    type="drag"
                                    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                    :on-success="handleSuccess"
                                    :on-error="handleError"
                                    :max-size="2048"
                                    :on-exceeded-size="handleMaxSize"
                                    action="/app/upload">

                                    <div style="padding: 20px 0">
                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                        <p>Pilih atau seret Gambar Ikon</p>
                                    </div>
                                </Upload>

                                <div class="demo-upload-list" v-if="editData.iconImage">
                                    <img :src="`${editData.iconImage}`" >
									<div class="demo-upload-list-cover">
										<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
									</div>
                                </div>

								<div slot="footer">
									<Button @click="closeEditModal" type="default">Close</Button>
									<Button @click="editCategory" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Editing..': 'Ubah Kategori'}}</Button>
								</div>
							</Modal>
							<deleteModal></deleteModal>
			</div>
		</div>
    </div>
</template>

<script>
import deleteModal from "../components/deleteModal.vue";
import { mapGetters} from "vuex";
	export default {
		data() {
			return{
				data 			: {
									iconImage: "",
                                    categoryName: "",
								},
				addModal 		: false,
				editModal 		: false,
				isAdding 		: false,
				categoryLists	: [],
				editData 		: {
									iconImage: "",
                                    categoryName: "",
								},
				index 			: -1,
				showDeleteModal	: false,
				isDeleting 		: false,
				deleteItem 		: {},
				deletingIndex	: -1,
                token           : "",
				isIconImageNew	: false,
				isEditingItem	: false,
				websiteSettings	: []

			}
		},


		methods : {
			//menambah data tag
			async addCategory() {
				if(this.data.categoryName.trim()=='') return this.e('Nama Kategori belum di isi')
				if(this.data.iconImage.trim()=='') return this.e('Gambar icon belum di pilih')
                this.data.iconImage = `${this.data.iconImage}`
				const res = await this.callApi('post', 'app/create_category', this.data)
				if(res.status===201){
					this.categoryLists.unshift(res.data)
					this.s('Kategori berhasil ditambah')
					this.addModal = false
					this.data.categoryName = ''
					this.data.iconImage = ''
				} else {
					if(res.status==442){
						if(res.data.errors.categoryName){
							this.e(res.data.errors.categoryName[0])
						}
						if(res.data.errors.iconImage){
							this.e(res.data.errors.iconImage[0])
						}

					} else {
						this.swr()
					}
				}
			},
			//edit data tag
			async editCategory() {
				if(this.editData.categoryName.trim()=='') return this.e('Nama kategori belum diisi!')
				if(this.editData.iconImage.trim()=='') return this.e('Logo belum dipilih!')
				const res = await this.callApi('post', 'app/edit_category', this.editData)
				if(res.status===200){
					this.categoryLists[this.index].categoryName = this.editData.categoryName
					this.s('Kategori berhasil diedit')
					this.editModal = false

				} else {
					if(res.status==442){
						if(res.data.errors.categoryName){
							this.e(res.data.errors.categoryName[0])
						}
						if(res.data.errors.iconImage){
							this.e(res.data.errors.iconImage[0])
						}
					} else {
						this.swr()
					}
				}
			},


			showEditModal(category, index){
				let obj = {
					id: category.id,
					categoryName: category.categoryName
				}
				console.log(category)
				this.editData = category
				this.editModal = true
				this.index = index
				this.isEditingItem = true

			},
			showDeletingModal(category, i){
				const deleteModalObj = {
					showDeleteModal : true,
					deleteUrl : 'app/delete_category',
					data : category,
					deletingIndex : i,
                    isDeleted : false,
                    msg : 'Yakin ingin menghapus Kategori ini?',
                    successMsg : 'Kategori terhapus'
				}
				this.$store.commit('setDeletingModalObj', deleteModalObj);
				console.log('delete modal active')
				// this.deleteItem = category
				// this.deletingIndex = i
				// this.showDeleteModal = true
			},
            handleSuccess (res, file) {
				res = `/uploads/${res}`
				if(this.isEditingItem) {
                    console.log("inside")
					return (this.editData.iconImage = res);
                }
                console.log(res)
                this.data.iconImage = res;

            },
            handleError (res, file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
                });
            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
            async deleteImage(isAdd=true) {
                let image;
                if(!isAdd){
                    //for editing
					this.isIconImageNew = true
					image = this.editData.iconImage
					this.editData.iconImage = '',
					this.$refs.editDataUploads.clearFiles()
				}else {
					image = this.data.iconImage
					this.data.iconImage = '',
					this.$refs.uploads.clearFiles()
				}
                const res = await this.callApi('post', 'app/delete_image', {imageName: image})
                if(res.status!=200){
                    this.data.iconImage = image
                    this.swr()
                }
            },
			closeEditModal() {
				this.isEditingItem = false
				this.editModal = false
			}
        },

	async created(){
        this.token = window.Laravel.csrfToken
		const res = await this.callApi('get', 'app/get_category')
		if(res.status==200){
			this.categoryLists = res.data
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
				this.categoryLists.splice(obj.deletingIndex, 1);
			}
		}
	}
};
</script>
