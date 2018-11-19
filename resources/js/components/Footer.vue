<template>
    <div>
        <footer class="footer">
            <p class="text-muted float-right">show your stored chart</p>
            <div :class="cardDeck" v-if="dataStore.storedChart">
                <template v-for=" (chart, index) in dataStore.storedChart">
                    <div class="card" :key="index">
                        <div :class="'card-body text-white ' + bgClass[index]" @click="readChart(chart)">{{ chart.chart_name }}</div>
                    </div>
                    <button class="btn btn-outline-success" :key="chart.id" @click="chooseDeleteTarget(chart)">Delete</button>
                </template>
            </div>
        </footer>
        <app-delete v-if="deleteModalFlag" @cancelDelete="cancelDelete" @deleteChart="deleteChart"></app-delete>
    </div>
</template>

<style scoped>
    .footer {
    position: fixed;
    bottom: 0;
    width: 100%;    
    height: 20px;
    background-color: #f5f5f5;
    transition: all 300ms 0s ease;
    }
    .footer:hover {
        height: 100px;
    }
    .card-deck {
        padding: 20px;
    }
    .card {
        width: 50px;
    }
    .card-body {
        padding: 0px; 
        height: 60px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn {
        height: 35px;
    }
</style>

<script>
import AppDelete from './Delete.vue'
import dataStore from '../dataStore.js'
export default {
    data() {
        return {
            dataStore: dataStore,
            bgClass: ['bg-info','bg-success','bg-danger'],
            deleteModalFlag: false,
            deleteTarget: null
        }
    },
    components: {
        AppDelete: AppDelete
    },
    computed: {
        cardDeck: () => {
            let deckSize = dataStore.storedChart.length * 3;
            return "card-deck col-sm-" + deckSize;
        }
    },
    methods: {
        readChart(targetChart) {
            dataStore.readChart(targetChart, res => {}, error => {});
        },
        chooseDeleteTarget(targetChart) {
            this.deleteTarget = targetChart;
            this.deleteModalFlag = !this.deleteModalFlag;
        },
        cancelDelete() {
            this.deleteModalFlag = !this.deleteModalFlag;
        },
        deleteChart() {
            dataStore.deleteChart(this.deleteTarget, res => {
                this.deleteModalFlag = !this.deleteModalFlag;
            }, error => {
                this.deleteModalFlag = !this.deleteModalFlag;
            });
        }
    }
}
</script>


