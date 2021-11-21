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

                    <form class="_form_add-records" :data-date="dateClick">
                        <div class="card-body">
                            <div class="form-group _time_records">
                                <label>Время</label>
                            </div>
                            <template v-for="(item, idx) in inputTime">
                                <div class="input-group mb-3 _time_record">

                                    <input  type="time" name="myself_time" class="form-control" value="00:00">
                                    <input  type="time" name="time" class="form-control" value="00:00">
                                    <input  type="text" name="myself_title" class="form-control">
                                    <div @click="deleteInputTime(idx)" class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="card-footer">
                            <button @click="add(false)" type="button" class="btn btn-primary ml-0">Добавить</button>
                            <button @click="add(true)" type="button" class="btn btn-primary ml-0 ">Личное</button>
                            <button type="submit" class="btn btn-primary mr-0 ">Сохранить</button>
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
        add: function (type) {
            this.inputTime.push({
                typeRecord:type,
                value:'00:00',
                status: type ? 4 : 1,
                title: ''
            })
        },
        deleteInputTime(idx) {

        },
        inputChange(idx, event){

        },
        saveRecords(event){

        },
        testFunc(){
            alert('yes')
        }
    }

}

</script>
