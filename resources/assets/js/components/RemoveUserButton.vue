<template>
  <a href="" @click.prevent="remove"><slot>Remove User</slot></a>
</template>

<script>
export default {
    props: ['hash', 'redirect'],
    methods: {
        remove() {
            axios.delete('/tickets/' + this.hash + '/users')
                .then(response => {
                    window.location = this.redirect;
                });
        }
    }
}
</script>
