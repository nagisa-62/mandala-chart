<template>
    <div>
        <span :class="requestResult">{{ alertMessage }}</span>
        <div class="form-group row float-right">
            <template v-if="userStore.state.authenticated">
                <label class="chart-name-label" for="chartname">Chart Name</label>
                <input type="text" class="form-control-sm chartform" v-model="dataStore.currentChart.name">
                <button class="btn btn-danger" :disabled="disabledDangerBtn" @click="saveChart" v-if="!dataStore.currentChart.id">Save Chart</button>
                <button class="btn btn-primary" :disabled="!dataStore.currentChart.name" @click="updateChart" v-if="dataStore.currentChart.id">Update Chart</button>
            </template>
            <button class="btn btn-success clear-all" @click="clearAllCells">Clear This Table</button>
        </div>
    </div>
</template>

<style scoped>
span {
    font-size: 15px;
}
.chart-name-label { 
    font-size: 15px;
}
.chartform {
    margin: 0px 20px;
}
.clear-all {
    margin: 0px 15px;
}
</style>

<script>
import userStore from '../userStore.js'
import dataStore from '../dataStore.js'
export default {
    data(){
        return {
            dataStore: dataStore,
            userStore: userStore
        }
    },
    computed: {
        alertMessage: () => {
            if(dataStore.alertMessage) {
                setTimeout(() => {dataStore.alertMessage = null} , 3000);
            }
            return dataStore.alertMessage;
        },
        requestResult: () => {
            if (!dataStore.requestResult) {
                return "text-danger";
            }
            return "text-primary";
        },
        disabledDangerBtn: () => {
            if(!dataStore.currentChart.name || dataStore.storedChart.length >= 3) {
                return true;
            }
            return false;
        }
    },
    methods: {
        clearAllCells() {
            this.dataStore.currentDataInit();
        },
        saveChart() {
            this.dataStore.saveChart(res => {
            }, error => {

            });
        },
        updateChart() {
            this.dataStore.updateChart(res => {

            }, error => {

            });
        }
    }
}
</script>
