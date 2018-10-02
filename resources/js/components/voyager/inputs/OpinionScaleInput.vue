<template>
    <div class="form-group">
        <div class="btn-group opinion-scale" data-toggle="buttons">
            <span class="btn btn-default opinion" :class="{active: selected === index}" v-for="index in question.maxValue" :key="index">
                <input :id="question.id" type="radio" :value="index" v-model="selected"> {{ index }}
            </span>
        </div>
        <p class="pull-right">{{ question.negativeLabel }}</p>
        <p class="pull-left">{{ question.positiveLabel }}</p>
    </div>
</template>

<script>

    export default {
        props: ['question'],
        data() {
            return  {
                selected: ''
            }
        },
        watch: {
            selected(value) {
                this.$emit('input', value);
            }
        }
    }
</script>

<style>
    .opinion-scale {
        display: flex;
    }

    .opinion {
        flex: 1;
    }

    /* .opinion input[type=radio] {
        display: none;
    } */
</style>
