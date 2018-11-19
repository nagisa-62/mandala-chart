<template>
    <div class="col-sm-4">
        <table class="table table-bordered">
                <tbody>
                    <template v-for="y in tableRow">
                        <tr :key="y">
                            <template v-for="x in tableColumn">
                                <td :id ="td_ID(y, x)" :key="x" ref="td">
                                    <textarea v-model="table[cellNumber(y, x)].value" v-show="onFocus[cellNumber(y, x)]" @blur="textBlur(y, x)" ref="textarea"></textarea>
                                    <div class="data-cell" v-show="!onFocus[cellNumber(y, x)]" @click="cellClick(y, x)">{{ table[cellNumber(y, x)].value }}</div>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
        </table>
    </div>
</template>

<style scoped>
textarea {
    border: none;
    outline: 0;
    resize: none;
    background: none;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
}
.data-cell { 
    box-sizing: border-box; 
    width: 100%;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    white-space: pre-wrap;
}
#td_4_0, #td_0_4 {
    background-color:rgba(255, 159, 243, 1.0);
}
#td_4_1, #td_1_4 {
    background-color:rgba(255, 159, 67, 1.0);
}
#td_4_2, #td_2_4 {
    background-color:rgba(72, 219, 251, 1.0);
}
#td_4_3, #td_3_4 {
    background-color:rgba(29, 209, 161, 1.0);
}
#td_4_5, #td_5_4 {
    background-color:rgba(95, 39, 205, 0.7);
}
#td_4_6, #td_6_4 {
    background-color:rgba(84, 160, 255, 1.0);
}
#td_4_7, #td_7_4 {
    background-color:rgba(254, 202, 87, 1.0);
}
#td_4_8, #td_8_4 {
    background-color:rgba(238, 82, 83, 1.0);
}
</style>

<script>
export default {
    props: ['table','index'],
    data() {
        return {
            tableRow: 3,
            tableColumn: 3,
            onFocus: Array(9).fill(false),
        }
    },
    mounted() {
        //console.log(this.$refs.td);
    },
    methods: {
        cellClick(y, x) {
            let cellNumber = this.cellNumber(y,x);
            this.onFocus.splice(cellNumber, 1, true);
            this.$nextTick(() => this.$refs.textarea[cellNumber].focus());
        },
        textBlur(y, x) {
            let cellNumber = this.cellNumber(y,x);
            this.onFocus.splice(cellNumber, 1, false);
        },
        td_ID(y, x) {
            let cellNumber = this.cellNumber(y,x);
            return "td_" + this.index + "_" +cellNumber;
        },
        cellNumber(y, x) {
            let cellNumber = (x-1) + ((y-1) * this.tableRow);
            return cellNumber;
        }
    }
}
</script>

