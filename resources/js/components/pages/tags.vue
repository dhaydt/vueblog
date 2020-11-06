<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal = true" type="default" size="small"><Icon type="md-add" /> Add tag</Button> </p>

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
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button @click="showEditModal(tag, i)" v-if="" type="info" size="small">Edit</Button>
									<Button type="error" size="small">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
								<!-- ADD MODAL -->
								<Modal
							        v-model="addModal"
							        title="Add New Tag"
							        :mask-closable=false
							        >
							        <Input v-model="data.tagName" placeholder="Tag Name" style="width: 300px" />

							        <div slot="footer">
							        	<Button @click="addModal = false" type="default">Close</Button>
							        	<Button @click="addTag" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Add'}}</Button>
							        </div>
							    </Modal>

							    <!-- Edit Modal -->
							    <Modal
							        v-model="editModal"
							        title="Edit Tag"
							        :mask-closable=false
							        >
							        <Input v-model="editData.tagName" placeholder="Edit Tag Name" style="width: 300px" />

							        <div slot="footer">
							        	<Button @click="editModal = false" type="default">Close</Button>
							        	<Button @click="addTag" type="primary" :disabled='isAdding' :loading="isAdding">{{isAdding ? 'Adding..': 'Add'}}</Button>
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
				data: {
					tagName: ''
				},
				addModal : false,
				isAdding : false,
				editModal : false,
				tags : [],
				editData : {
					tagName: ''
				},
				index : -1,
				showEditModal : false,
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
			}
		},

		async created(){
			const res = await this.callApi('get', 'app/get_tags')
			if(res.status==200){
				this.tags = res.data
			} else {
				this.swr()
			}
		},
		async editTag(){
			if(this.editData.tagName.trim()=='') return this.e('isi Tag Name')
			const res = await this.callApi('post', 'app/edit_tag', this.editData)
			if (res.status===200){
				this.tags[this.index].tagName = this.editData.tagName
				this.s('Tag berhasil di edit')
				this.editModal = false
			} else {
				if(res.status==422){
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
				id : tag.id,
				tagName : tag.tagName
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},
	}
</script>