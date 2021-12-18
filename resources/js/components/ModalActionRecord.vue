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
                        <form class="form-horizontal _form_for_record" data-record-id="179">
                            <div class="card-body">
                                <p>Выбранный день: 20.12.2021 (пнд)</p>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Время</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control _input_form_for_record" name="time" value="12:00">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Услуга</label>
                                    <div class="col-sm-10">
                                        <select name="service" class="form-control _input_form_for_record" required="">
                                            <option value="" selected="">Не выбрано</option>
                                            <option value="1">Маникюр + укрепление</option>
                                            <option value="2">Гигиечиский маникюр</option>
                                            <option value="3">Наращивание</option>
                                            <option value="4">Снятие материала</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Имя</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control add_name _input_form_for_record" name="name" autocomplete="off" value=""><ul class="typeahead dropdown-menu" role="listbox" style="top: 38px; left: 7.5px; display: none;"><li class="active"><a class="dropdown-item" href="#" role="option"><strong>Бело</strong>усов Дмитрий</a></li></ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-10">
                                        <input type="text" name="phone" class="form-control _paste_phone_auto _input_form_for_record" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" inputmode="text" value="">
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
    </div>
</template>

<script>


</script>
