<template>
    <div>
        <div class="modal fade" id="modal-action-with-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Выбор действия</h4>
                        <button type="button" class="close" data-dismiss="modal" ref="close_modal_action_records" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="">
                        <form class="form-horizontal _form_action_record" :data-record-id="recordId">
                            <div class="card-body">
                                <p>Выбранный день: {{ date }}</p>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Время</label>
                                    <div class="col-sm-9">
                                        <input type="time" class="form-control _input_form_for_record" v-model="time">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Услуга</label>
                                    <div class="col-sm-9">
                                        <select v-model="selectedService" class="form-control _input_form_for_record" required="">
                                            <option v-for="item in services" :value="item.id" :selected="serviceId==item.id">{{item.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control add_name _input_form_for_record" name="name" autocomplete="off" v-model="name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-9">
                                        <input type="text" name="phone" class="form-control _paste_phone_auto _input_form_for_record" v-model="phone">

                                        <a  v-if="phone" :href="'whatsapp://send?phone=+7' + phone" class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                        </a>
                                        <a v-if="phone" :href="'tel:+7' + phone"  class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
                                        </a>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button v-if="status == 1" @click.prevent="recordUser(recordId)" class="btn btn-info _add_user_on_record">Записать</button>
                                <button v-if="status == 2"  class="btn btn-info _confirm_record">Подтвердить</button>
                                <button v-if="name" class="btn btn-info _close_record">Отменить</button>
                                <button v-if="isEdit" class="btn btn-success float-center">Сохранить</button>
                                <button class="btn btn-danger float-right _delete_record">Удалить</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button style="display: none" data-toggle="modal" data-target="#modal-action-with-records" ref="open_modal_action_records"></button>
    </div>
</template>

<script>
export default {
    props:['recordId'],
    watch: {
        recordId: function(newVal, oldVal) {
            axios.post('/admin/calendar/get-data-record', {recordId:newVal})
                .then((response)=>{

                    this.date = response.data.date
                    this.time = response.data.time
                    this.name = response.data.name
                    this.phone = response.data.phone
                    this.services = response.data.services
                    this.serviceId = response.data.serviceId
                    this.selectedService = response.data.serviceId ? response.data.serviceId : 1
                    this.status = response.data.status
                    this.idRecord = newVal
                    const elem = this.$refs.open_modal_action_records;
                    elem.click();
            })
        }
    },
    data() {
        return {
            date: '',
            time:'',
            name: '',
            phone: '',
            services: '',
            selectedService: '',
            serviceId: '',
            status: '',
            isEdit: false,
            idRecord:'',
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        recordUser(recordId){
            axios.post('/admin/calendar/action-with-events', {
                recordId:recordId,
                serviceId:this.selectedService,
                name:this.name,
                time:this.time,
                phone:this.phone}
            )
            .then((response)=>{
                this.$parent.restartCalendar()
                const elem = this.$refs.close_modal_action_records
                elem.click();
            })
        }
    }
}

</script>
