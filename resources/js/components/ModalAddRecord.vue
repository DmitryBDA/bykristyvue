<template>
    <div>
        <div class="modal fade" id="modal-add-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить запись</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="saveRecords($event)" :data-date="dateClick" class="_form_add-records" >
                        <div class="card-body">
                            <div v-if="inputTime.length" class="form-group _time_records">
                                <label>Время</label>
                            </div>
                            <p v-if="inputTime.length === 0">Добавьте новую запись</p>
                            <template v-for="(item, idx) in inputTime">
                                <div class="input-group mb-3 _time_record">

                                    <input @input="inputChange(idx, $event)"  type="time" name="time" class="form-control" :value="item.value">
                                    <input v-if="item.typeRecord" @input="inputChange(idx, $event)" type="text" name="title" :value="item.title" class="form-control">
                                    <div @click="inputDelete(idx)" class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="card-footer">
                            <button @click="inputAdd(false)" type="button" class="btn btn-primary ml-0">Добавить</button>
                            <button @click="inputAdd(true)" type="button" class="btn btn-primary ml-0 ">Личное</button>
                            <button :disabled="isDisabled" type="submit" class="btn btn-primary mr-0 ">Сохранить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['dateClick'],
    watch: {
        dateClick: function(newVal, oldVal) {
            this.inputTime = [
                {
                    typeRecord:false,
                    value:'00:00',
                    status: 1,
                    title: ''
                }
            ]
            if(this.isDisabled){
                this.isDisabled = false
            }
        }
    },
    data() {
        return {
            inputTime: [
                {
                    typeRecord:false,
                    value:'00:00',
                    status: 1,
                    title: ''
                }
            ],
            isDisabled:false,
        }
    },
    methods: {
        inputAdd: function (type) {
            this.inputTime.push({
                typeRecord:type,
                value:'00:00',
                status: type ? 4 : 1,
                title: ''
            })
            if(this.isDisabled){
                this.isDisabled = false
            }
        },
        inputDelete(idx) {
            this.inputTime.splice(idx, 1)
            if( this.inputTime.length === 0){
                this.isDisabled = true
            }
        },
        inputChange(idx, event){
            if(event.target.name === 'title'){
                this.inputTime[idx].title = event.target.value
            } else {
                this.inputTime[idx].value = event.target.value
            }
        },
        saveRecords(event){
            axios.post('/admin/calendar/create-records', {timeRecords:this.inputTime, date:event.target.attributes[0].nodeValue}).then((response)=>{
                $('#modal-add-records').click()
                this.$emit('restartCalendar')
            })
        },
        testFunc(){
            alert('yes')
        }
    }

}

</script>
