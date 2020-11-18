<template>
    <div class="content">
        <div class="container-fluid">
            <h1>I will show all other components react to changes</h1>
            <h2>isi store yang tersedia adalah : {{counter}}</h2>
            <div class="space"></div>

            <div>
                <A></A>
            </div>
            <div class="space"></div>

            <div>
                <B></B>
            </div>
            <div class="space"></div>

            <div>
                <C></C>
            </div>
            <div class="space"></div>

            <div>
                <Button type="info" @click="increased">Count</Button>
            </div>
        </div>
    </div>
</template>
<script>
import A from './comA'
import B from './comB'
import C from './comC'
import {mapGetters} from 'vuex'

export default {
    data() {
        return {

        }
    },
    computed : {
        ...mapGetters({
            counter : 'getCounter'
        })
    },

    components : {
        A,
        B,
        C,
    },

    methods : {
        increased() {
            this.$store.commit('changeTheCounter', 300);
        }
    },
}
</script>