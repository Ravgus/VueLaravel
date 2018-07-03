<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="" id="" readonly="" cols="30" rows="10" class="form-control">{{dataMessage.join('\n')}}</textarea>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Наберите текст сообщения" v-model="message">
                </div>
                <div class="input-group-append">
                    <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function() {
            return {
                dataMessage: [],
                message: "",

            }
        },
        mounted() {
            console.log('Component mounted.');
            var socket = io('http://vuelaravel:3000');

            socket.on('new-action:App\\Events\\NewMessage', function (data) {
                this.dataMessage.push(data.message);
            }.bind(this));

        },
        methods: {
            sendMessage: function () {

                axios({
                    method: 'get',
                    url: '/start/send-message',
                    params: {message: this.message}
                }).then((response) => {
                    console.log(response);
                    this.message = "";
                });
            }
        }
    }
</script>
