require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    data: {
        rt: '',
        rw: '',
        selectedKecamatan: '',
        selectedKelurahan: '',
        kecamatans: [],
        kelurahans: [],
    },
    methods: {
        submitForm() {
            // Handle form submission, you can make an AJAX request if needed
        },
        loadKecamatans() {
            axios.get('/kecamatans')
                .then(response => {
                    this.kecamatans = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        loadKelurahan() {
            axios.get(`/kelurahans/${this.selectedKecamatan}`)
                .then(response => {
                    this.kelurahans = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateKecamatan() {
            // Handle the logic to update the selected kecamatan
        }
    },
    mounted() {
        this.loadKecamatans();
    }
});
