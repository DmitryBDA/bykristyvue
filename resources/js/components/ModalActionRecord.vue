<template>
    <div>
        <div class="modal fade" id="modal-action-with-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Выбор действия</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="_form_action_record">
                        <form class="form-horizontal _form_for_record" :data-record-id="recordId">
                            <div class="card-body">
                                <p>Выбранный день: {{ date }}</p>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Время</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control _input_form_for_record" name="time" :value="time">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Услуга</label>
                                    <div class="col-sm-10">
                                        <select name="service" class="form-control _input_form_for_record" required="">
                                            <option v-if="serviceId==false" selected >Не выбрано</option>
                                            <option v-for="item in services" :value="item.id" :selected="serviceId==item.id">{{item.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Имя</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control add_name _input_form_for_record" name="name" autocomplete="off" :value="name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-10">
                                        <input type="text" name="phone" class="form-control _paste_phone_auto _input_form_for_record" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" inputmode="text" :value="phone">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info _add_user_on_record">Записать</button>                 <button style="display: inline;" data-record-id="179" type="submit" class="btn btn-success float-center _save_change_record">Сохранить</button>
                                <button data-record-id="179" type="button" class="btn btn-danger float-right _delete_record">Удалить</button>
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
                    console.log(response.data)
                    this.date = response.data.date
                    this.time = response.data.time
                    this.name = response.data.name
                    this.phone = response.data.phone
                    this.services = response.data.services
                    this.serviceId = response.data.serviceId
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
            serviceId: '',
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}

</script>
