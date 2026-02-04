
let vmLogin = new Vue({
    el: 'vmLogin',

    data: {},

    methods: {

        verificarErroLogin()
        {
            const url = window.location.search;
            const params = new URLSearchParams(url);
            console.log(params);
            if(params.get('status') === 'erro'){
                let modal = new bootstrap.Modal(document.getElementById('LoginModal'), {
                    keyboard: false
                });

                modal.show();
            }
        }

    },

    mounted(){
        window.addEventListener('DOMContentLoaded', () => {
            this.verificarErroLogin();
        });
    }
});
