<template>
  <a href="" @click.prevent="remove">Remove User</a>
</template>

<script>
export default {
    props: ['hash', 'order'],
    methods: {
        remove() {
            axios.delete('/tickets/' + this.hash + '/users')
                .then(response => {
                    window.location = '/orders/' + this.order;
                });
        }
    }
}
</script>
