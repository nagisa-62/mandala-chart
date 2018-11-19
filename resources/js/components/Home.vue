<template>
    <div>
        <app-sub-header></app-sub-header>
        <div class="row">
            <template v-for="(table, index) in tableArray">
                <table-component :table="table" :key="index" :index="index"></table-component>
            </template>
        </div>
    </div>
</template>

<style scoped>

</style>

<script>
import TableComponent from './TableComponent.vue'
import SubHeader from './SubHeader.vue'
import dataStore from '../dataStore.js'
export default {
    data() {
        return {
            tableArray: dataStore.TableArray
        }
    },       
    components: {
        TableComponent: TableComponent,
        appSubHeader: SubHeader
    }
}
</script>

