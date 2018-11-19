export default {
    currentChart: {id: null, name: null},
    storedChart: [],
    alertMessage: null,
    requestResult: false,

    // 9x9 Table Array
    TableArray: [...Array(9)].map(() => {
        return [...Array(9)].map(() => {
            const data = {value: ''}; 
            return data;
        })
    }),
    //centerNo means center cell on Table and centerTable on TableArray
    centerNo: 4,

    currentDataInit() {
        this.currentChart.id = null;
        this.currentChart.name = null;
        //Table Array initialize to value: "" on each of cell
        this.TableArray.forEach(table => {
            table.forEach((cell, index) =>{
                const data = {value: ''}; 
                table.splice(index, 1, data)
            })
        });
        //Map centerTable cells to each of center cell in Table Array
        this.TableArray.forEach((table, index) => {
            if (index != this.centerNo) {
                table.splice(this.centerNo, 1, this.TableArray[this.centerNo][index]);
                
            }
        });
    },

    storedChartInit() {
        this.storedChart = [];
    },

    initChart(successCb = null, errorCb = null) {
        window.axios.get('/api/init').then(res => {

            res.data.chartInfos.forEach((chartInfo,index) => {
                this.storedChart.push(chartInfo);
                if (index == 0) {
                    this.currentChart.id = chartInfo.id;
                    this.currentChart.name = chartInfo.chart_name;
                }
            });

            res.data.chartData.forEach((table, tableIndex) => {
                table.forEach((cell, cellIndex) => {
                    this.TableArray[tableIndex][cellIndex].value = cell.value;
                })
            });

            successCb();
        }).catch(error => {
            this.requestResult = false;
            this.alertMessage = "Error! can NOT read init Chart!";
            errorCb();
        })
    }, 

    readChart(targetChart, successCb = null, errorCb = null) {
        window.axios.get('/api/read/' + targetChart.id).then(res => {
            this.currentChart.id = targetChart.id;
            this.currentChart.name = targetChart.chart_name;

            res.data.chartData.forEach((table, tableIndex) => {
                table.forEach((cell, cellIndex) => {
                    this.TableArray[tableIndex][cellIndex].value = cell.value;
                })
            });

            successCb();
        }).catch(error => {
            this.requestResult = false;
            this.alertMessage = "Error! can NOT read this Chart!";
            errorCb();
        });
    },

    saveChart(successCb = null, errorCb = null) {
        var newChart = {chartInfo: this.currentChart, chartData: this.TableArray}
        window.axios.post('/api/create', newChart).then(res => {
            this.currentChart.id = res.data.createChart.id;
            this.currentChart.name = res.data.createChart.chart_name;
            this.storedChart.push(res.data.createChart);

            this.requestResult = true;
            this.alertMessage = "Successfully created!";
            successCb();
        }).catch(error => {
            this.requestResult = false;
            this.alertMessage = "Error! can NOT create Chart!";
            errorCb();
        });
    },

    updateChart(successCb = null, errorCb = null) {
        var targetChart = {chartInfo: this.currentChart, chartData: this.TableArray}
        window.axios.patch('/api/update' ,targetChart).then(res => {
            this.requestResult = true;
            this.alertMessage = "Successfully updated!";
            successCb();
        }).catch(res => {
            this.requestResult = false;
            this.alertMessage = "Error! can NOT update!";
            errorCb();
        })
    },

    deleteChart(targetChart, successCb = null, errorCb = null){
        let chartId = targetChart.id
        window.axios.delete('/api/delete/'+chartId,).then(res => {
            if (this.currentChart.id == chartId) {
                this.currentDataInit();
            }
            this.storedChart.forEach((chart, index) => {
                if (chart.id == chartId) {
                    this.storedChart.splice(index, 1);
                }
            });
            this.requestResult = true;
            this.alertMessage = "Successfully deleted!";
            successCb();
        }).catch(error => {
            this.requestResult = false;
            this.alertMessage = "Error! can NOT delete!";
            errorCb();
        });
    }
}