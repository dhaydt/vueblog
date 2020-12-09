<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Create blog</p>

					<div class="_overflow _table_div blog_editor">
                        <div id="editorjs"></div>
					</div>
                    <div class="_input_field">
                        <Input type="text" placeholder="title"></Input>
                    </div>
                    <div class="_input_field">
                        <Button @click="save">save blog</Button>
                    </div>

				</div>
			</div>
		</div>
    </div>
</template>
<script>
import EditorJS from "@editorjs/editorjs";
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Embed from '@editorjs/embed';
import LinkTool from '@editorjs/link';
import RawTool from '@editorjs/raw';
import ImageTool from '@editorjs/image';
import Checklist from '@editorjs/checklist';
import Table from '@editorjs/table';

var editor = new EditorJS({
    holderId: 'editorjs',

    tools: {
        header: {
            class: Header,
            inlineToolbar: ['link']
        },
        list: {
            class: List,
            inlineToolbar: [
                'link',
                'bold'
            ]
        },
        embed: {
            class: Embed,
            inlineToolbar: false,
            config: {
                services: {
                    youtube: true,
                    coub: true
                }
            }
        },
        raw: RawTool,
        checklist: {
            class: Checklist,
            inlineToolbar: true,
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                byFile: 'http://localhost:8000/createblog', // Your backend file uploader endpoint
                byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
                }
            }
        },
    },
});
export default {
    data() {
        return {
            initData: null,
            data: {},
        };
    },
    methods: {
        onSave(response) {
            console.log("response onSave", response);
        },

        async save() {
            editor.save().then((response) => {});

        },
    },
  // async created(){
  // 	const [cat, tag] = await Promise.all([
  // 		this.callApi('get', 'app/get_category'),
  // 		this.callApi('get', 'app/get_tags'),
  // 	])
  // 	if(cat.status==200){
  // 		this.category = cat.data
  // 		this.tag = tag.data
  // 	}else{
  // 		this.swr()
  // 	}
  // }
};
</script>
<style>
.blog_editor {
    width: 717px;
    margin-left: 160px;
    padding: 4px 7px;
    font-size: 14px;
    border: 1px solid #dcdee2;
    border-radius: 4px;
    color: #515a8e;
    background-color: #fff;
    background-image: none;
    z-index: -1;
}

.blog_editor:hover {
    border: 1px solid #57a3f3;
}

._input_field {
    margin: 20px 0px 0 160px;
    width: 717px;
}
</style>
