<template>
    <div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Categories <Button @click="addModal = true" type="default" size="small">
                        <Icon type="md-add" /> Add Category</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" >
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button @click="showEditModal(tag, i)" type="info" size="small">Edit</Button>
									<Button @click="showDeletingModal(tag, i)" :loading="tag.isDeleting" type="error" size="small" >Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
							<!-- ADD Category -->
							<Modal
								v-model="addModal"
								title="Add New Category"
								:mask-closable=false
								>

								<Input v-model="data.tagName" placeholder="Category Name" />
                                <div class="space"></div>
                                <Upload
                                    multiple
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
                                        <p>Click or drag files here to upload</p>
                                    </div>
                                </Upload>
                                <div class="demo-upload-list" v-if="data.iconImage">
                                    <img :src="`/uploads/${data.iconImage}`" >
									<div class="demo-upload-list-cover">
										<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
									</div>
                                </div>
								<div slot="footer">
									<Button @click="addModal = false" type="default">Close</Button>
									<Button @click="addTag" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Add'}}</Button>
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
							<Modal v-model="showDeleteModal" width="360" :closable="true" :mask-closable="false">
								<p slot="header" style="color:#f60;text-align:center">
									<Icon type="ios-information-circle"></Icon>
									<span>Delete Konfirmasi</span>
								</p>
								<div style="text-align:center">
									<p>Anda yakin ingin menghapus tag ini?</p>
								</div>
								<div slot="footer">
									<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
								</div>
							</Modal>

			</div>
	</div>
    </div>
</template>

<script>
	export default {
		data() {
			return{
				data 			: {
									iconImage: '',
                                    categoryName: '',
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
                deleteModal		: false,
                token           : ''

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
				const deleteItem = tag
				this.deletingIndex = i
				this.showDeleteModal = true
			},
            handleSuccess (res, file) {
                this.data.iconImage = res
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
            async deleteImage() {
                let image = this.data.iconImage
                this.data.iconImage = '',
                this.$refs.uploads.clearFiles()
                const res = await this.callApi('post', 'app/delete_image', {imageName: image})
                if(res.status!=200){
                    this.data.iconImage = image
                    this.swr()
                }
            }
        },

	async created(){
        this.token = window.Laravel.csrfToken
		const res = await this.callApi('get', 'app/get_tags')
		if(res.status==200){
			this.tags = res.data
		} else {
			this.swr()
		}
	},
	}
</script>
