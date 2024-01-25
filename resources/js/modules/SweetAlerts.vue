<script>
export default {
    methods: {
        ShowAlert(message) {
            this.$swal(message)
        },
        showNotification(message) {
            this.$swal({
                toast: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: message
            });
        },
        showNotificationError(message) {
            this.$swal({
                toast: true,
                showConfirmButton: false,
                position: "top-start",
                timer: 5000,
                icon: "error",
                title: message
            })
        },
        showError() {
            this.$swal({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
            })
        }
    }
}
</script>