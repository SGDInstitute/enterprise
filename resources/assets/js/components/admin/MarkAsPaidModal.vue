<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h5>Mark as Paid</h5>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="check_number">Check Number</label>
                            <input type="email" class="form-control" id="check_number" name="check_number" v-model="form.check_number">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" v-model="form.amount">
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="comped" :value="true" v-model="form.comped"> Comp order instead
                            </label>
                        </div>

                        <div class="alert alert-success" v-if="form.successful">
                            Order has been marked as paid.
                        </div>
                    </div>

                    <div class="modal-footer text-right">
                        <button class="btn-link" @click="$emit('close')">
                            Close
                        </button>
                        <button class="btn-default" @click.prevent="markAsPaid" :disabled="form.busy">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['order'],
    data() {
        return {
            form: new SparkForm({
                comped: false,
                check_number: '',
                amount: '',
            })
        }
    },
    methods: {
        markAsPaid() {
            Spark.patch('/admin/orders/' + this.order.id + '/paid', this.form)
                .then(response => {

                });
        }
    }
}
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}
</style>