<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Create blog</p>

                    <div class="_input_field">
                        <Input type="text" v-model="data.title" placeholder="Judul" />
                    </div>

					<div class="_overflow _table_div blog_editor">
                        <div id="editorjs"
                        holder-id="codex-editor"
                        save-button-id="save-button"
                        :init-data="initData"
                        :config="config"
                        @save()="onSave"
                        >
                    </div>
					</div>

                    <div class="_input_field">
                        <Input type="textarea" v-model="data.post_excerpt" :rows="4" placeholder="Post Excerpt" />
                    </div>
                    <div class="_input_field">
                        <Input type="textarea" v-model="data.metaDescription" :rows="4" placeholder="Meta Description" />
                    </div>

                    <div class="_input_field">
                        <Select filterable multiple placeholder="Pilih Kategori" v-model="data.tag_id">
                            <Option v-for="(c, i) in category" :value="c.id" :key="i">{{c.categoryName}}</Option>
                        </Select>
                    </div>

                    <div class="_input_field">
                        <Select filterable multiple placeholder="Pilih Tag" v-model="data.tag_id">
                            <Option v-for="(t, i) in tag" :value="t.id" :key="i">{{t.tagName}}</Option>
                        </Select>
                    </div>

                    <div class="_input_field">
                        <Button @click="save()" :loading="isCreating" :disabled="isCreating">{{ isCreating ? 'Mohon Tunggu..' : 'Membuat Blog'}}</Button>
                    </div>

				</div>
			</div>
		</div>
    </div>
</template>
<script>
// import EditorJS from "@editorjs/editorjs";
// import Header from '@editorjs/header';
// import List from '@editorjs/list';
// import Embed from '@editorjs/embed';
// import LinkTool from '@editorjs/link';
// import RawTool from '@editorjs/raw';
// import ImageTool from '@editorjs/image';
// import Checklist from '@editorjs/checklist';
// import Table from '@editorjs/table';

// var editor = new EditorJS({
//     holderId: 'editorjs',

//     tools: {
//         header: {
//             class: Header,
//             inlineToolbar: ['link']
//         },
//         list: {
//             class: List,
//             inlineToolbar: [
//                 'link',
//                 'bold'
//             ]
//         },
//         embed: {
//             class: Embed,
//             inlineToolbar: false,
//             config: {
//                 services: {
//                     youtube: true,
//                     coub: true
//                 }
//             }
//         },
//         raw: RawTool,
//         checklist: {
//             class: Checklist,
//             inlineToolbar: true,
//         },
//         image: {
//             class: ImageTool,
//             config: {
//                 endpoints: {
//                 byFile: 'http://localhost:8000/createblog', // Your backend file uploader endpoint
//                 byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
//                 }
//             }
//         },
//     },
// });
// export default {
//     data() {
//         return {
//             config: {

//             },
//             initData: null,
//             data: {
//                 title: '',
//                 post: '',
//                 post_excerpt: '',
//                 metaDescription: '',
//                 category_id: [],
//                 tag_id: [],
//                 jsonData: null,
//             },
//             articleHTML: '',
//             category: [],
//             tag: [],
//             isCreating: false,
//         }
//     },
//     methods: {
//         async onSave(outputData) {

//             var data = editor.save().then((outputData))
//             await this.outputHtml('output',data.blocks)
//             console.log('onSave', this.data)
//             this.data.post = this.articleHTML
//             this.data.jsonData = JSON.stringify(data)
//             console.log('article', this.articleHTML)
//             console.log('data output', this.data)
//             this.isCreating = true
//             const res = await this.callApi('post', 'app/create-blog', this.data)
//             if (res===201){
//                 this.s('Blog created')
//                 //redirect
//             }else {
//                 this.swr()
//             }
//             this.isCreating = false
//         },

//         async save(outputData){
//             // var data = outputData
//             await editor.save().then((data) => {
//                 console.log('Article data: ', data.blocks)
//                 // this.outputHtml('output',data.blocks)
//                 }).catch((error) => {
//                 console.log('Saving failed: ', error)
//                 });
//             // this.onSave(data)
//             console.log('datablock', editor.save())
//         },



//         outputHtml(articleObj){
//             // function customBlockParser(articleObj){
//             //     return `<span> ${articleObj.data.text} </span>`;
//             //     }

//             //     // Pass it during the initialization step.
//             //     const edjsParser = edjsHTML({custom: customBlockParser});

//             //     /** Note: The key of the parserOptions object
//             //     must match with the type of the block.
//             //     */

//             //     // Parse the block
//             //     console.log(edjsParser.parse({articleObj}));

//             // articleObj.map(obj => {
//             //     switch (obj.type) {
//             //         case 'paragraph' :
//             //             this.articleHTML += this.makeParagraph(obj);
//             //             break;
//             //         case 'image' :
//             //             this.articleHTML += this.makeImage(obj);
//             //             break;
//             //         case 'header' :
//             //             this.articleHTML += this.makeHeader(obj);
//             //             break;
//             //         case 'raw' :
//             //             this.articleHTML += `<div class="ce-block">
//             //             <div class="ce_block_content">
//             //             <div class="ce_code">
//             //                 <code>${obj.data.html}</code>
//             //             </div></div>
//             //             </div>\n`;
//             //             break;
//             //         case 'code' :
//             //             this.articleHTML += this.makeCode(obj);
//             //             break;
//             //         case 'list' :
//             //             this.articleHTML += this.makeList(obj);
//             //             break;
//             //         case 'quote' :
//             //             this.articleHTML += this.makeQuote(obj);
//             //             break;
//             //         case 'warning' :
//             //             this.articleHTML += this.makeWarning(obj);
//             //             break;
//             //         case 'checklist' :
//             //             this.articleHTML += this.makeChecklist(obj);
//             //             break;
//             //         case 'embed' :
//             //             this.articleHTML += this.makeEmbed(obj);
//             //             break;

//             //         case'delimeter' :
//             //             this.articleHTML += this.makeDelimeter(obj);
//             //             break;
//             //         default:
//             //             return '';

//             //     }
//             // });

//         },
//     },
//     async created(){
//             const [cat, tag] = await Promise.all([
//                 this.callApi('get', 'app/get_category'),
//                 this.callApi('get', 'app/get_tags'),
//             ])
//             if(cat.status==200){
//                 this.category = cat.data
//                 this.tag = tag.data
//             }else{
//                 this.swr()
//             }
//         }
// };
// </script>
// <style>
// .blog_editor {
//     width: 717px;
//     margin-left: 160px;
//     padding: 4px 7px;
//     font-size: 14px;
//     border: 1px solid #dcdee2;
//     border-radius: 4px;
//     color: #515a8e;
//     background-color: #fff;
//     background-image: none;
//     z-index: -1;
// }

// .blog_editor:hover {
//     border: 1px solid #57a3f3;
// }

// ._input_field {
//     margin: 20px 0px 20px 160px;
//     width: 717px;
// }
// </style>
