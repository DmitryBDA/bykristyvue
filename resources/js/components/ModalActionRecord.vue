<template>
    <div>
        <div class="modal fade" id="modal-action-with-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Выбор действия</h4>
                        <button type="button" class="close" data-dismiss="modal" ref="close_modal_action_records"
                                aria-label="Close">
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
                                        <select v-model="selectedService" class="form-control _input_form_for_record"
                                                required="">
                                            <option v-for="item in services" :value="item.id"
                                                    :selected="serviceId==item.id">{{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text" :class="isNameValid === true ? 'is-invalid': ''"
                                               class="form-control input-lg add_name _input_form_for_record" name="name"
                                               @keyup="getDataAutocomplete()"
                                               autocomplete="off" v-model="name">
                                        <div v-if="isActiveSearch" class="panel-footer"
                                             style="position: absolute;z-index: 1;">
                                            <ul class="list-group">
                                                <a href="#" @click.prevent="pasteName(name, phone)" class="list-group-item"
                                                   v-for="(name, phone) in search_data">{{ name }}</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-9">
                                        <input type="text" name="phone"
                                               class="form-control _paste_phone_auto _input_form_for_record"
                                               :class="isPhoneValid === true ? 'is-invalid': ''"
                                               v-mask="'##########'"
                                               v-model="phone">

                                        <a v-if="!this.v$.phone.$invalid" :href="'whatsapp://send?phone=+7' + phone"
                                           class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-whatsapp"
                                                                              aria-hidden="true"></i></span>
                                        </a>
                                        <a v-if="!this.v$.phone.$invalid" :href="'tel:+7' + phone"
                                           class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-volume-control-phone"
                                                                              aria-hidden="true"></i></span>
                                        </a>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button v-if="status == 1" @click.prevent="recordUser(recordId)"
                                        class="btn btn-info _add_user_on_record">Записать
                                </button>
                                <button v-if="status == 2" @click.preven="confirmRecord(recordId)" class="btn btn-info">Подтвердить</button>
                                <button v-if="name" @click.prevent="cancelRecord(recordId)" class="btn btn-info">Отменить</button>
                                <button v-if="isEdit" class="btn btn-success float-center">Сохранить</button>
                                <button class="btn btn-danger float-right" @click.prevent="deleteRecord(recordId)">Удалить</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button style="display: none" data-toggle="modal" data-target="#modal-action-with-records"
                ref="open_modal_action_records"></button>
    </div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import {required, minLength, maxLength} from '@vuelidate/validators'
import {mask} from 'vue-the-mask'

export default {
    directives: {mask},
    setup() {
        return {v$: useVuelidate()}
    },
    props: ['recordId', 'dataRecord'],
    watch: {
        dataRecord: function (newVal, oldVal) {
            this.date = newVal.date
            this.time = newVal.time
            this.name = newVal.name
            this.phone = newVal.phone
            this.services = newVal.services
            this.serviceId = newVal.serviceId
            this.selectedService = newVal.serviceId ? newVal.serviceId : 1
            this.status = newVal.status

            this.isNameValid = false
            this.isPhoneValid = false

            const elem = this.$refs.open_modal_action_records;
            elem.click();
        }
    },
    data() {
        return {
            date: '', time: '', name: null,
            phone: '', services: '', selectedService: '',
            serviceId: '', status: '', isEdit: false,
            isDataIsset: this.$props.dataRecord.length,
            isNameValid: false,
            isPhoneValid: false,
            search_data: [],
            isActiveSearch: false
        }
    },
    mounted() {

    },
    methods: {
        recordUser(recordId) {
            let error = true
            if (this.v$.name.$invalid) {
                this.isNameValid = true
                error = false
            } else {
                this.isNameValid = false
            }
            if (this.v$.phone.$invalid) {
                this.isPhoneValid = true
                error = false
            } else {
                this.isPhoneValid = false
            }

            if (error) {
                axios.post('/admin/calendar/action-with-events', {
                        recordId: recordId,
                        serviceId: this.selectedService,
                        name: this.name,
                        time: this.time,
                        phone: this.phone
                    }
                )
                    .then((response) => {
                        this.$parent.restartCalendar()
                        const elem = this.$refs.close_modal_action_records
                        this.isNameValid = false
                        elem.click();
                    })
            }
        },
        getDataAutocomplete() {
            this.search_data = []

            if (this.name != '') {
                axios.post('/admin/calendar/search-autocomplete', {str: this.name})
                    .then((response) => {
                        this.search_data = response.data
                        this.isActiveSearch = true
                    })
            }

        },
        pasteName(name, phone) {
            this.name = name
            this.phone = phone
            this.isActiveSearch = false
        },
        confirmRecord(recordId){
            axios.post('/admin/calendar/confirm-record', {
                    recordId: recordId,
                }
            )
                .then((response) => {
                    this.$parent.restartCalendar()
                    const elem = this.$refs.close_modal_action_records
                    elem.click();
                })
        },
        cancelRecord(recordId){
            axios.post('/admin/calendar/cancel-record', {
                    recordId: recordId,
                }
            )
                .then((response) => {
                    this.$parent.restartCalendar()
                    const elem = this.$refs.close_modal_action_records
                    elem.click();
                })
        },
        deleteRecord(recordId){
            axios.post('/admin/calendar/delete-record', {
                    recordId: recordId,
                }
            )
                .then((response) => {
                    this.$parent.restartCalendar()
                    const elem = this.$refs.close_modal_action_records
                    elem.click();
                })
        },

    },
    validations: {
        name: {
            simpleValidator(value) {
                if(value){
                    return value.match(/([A-Za-zа-яА-ЯеЁ]+)/g).length == 2
                } else {
                    return false
                }

            }
        },
        phone: {required, minLength: minLength(10), maxLength: maxLength(10)}
    }
}

</script>
