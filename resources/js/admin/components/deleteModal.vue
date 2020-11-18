<template>
    <div>
        <!-- Delete Modal -->
        <Modal v-model="showDeleteModal">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Konfirmasi Hapus</span>
            </p>
            <div style="text-align:center">
                <p>Anda yakin ingin menghapus tag ini?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">Hapus</Button>
            </div>
        </Modal>
    </div>
</template>
<script>
import {mapGetters} from'vuex'
export default {
    
    computed : {
        ...mapGetters()
    }

}
</script>