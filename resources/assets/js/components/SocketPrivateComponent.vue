<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row form-group">
                    <div class="col-sm-4">
                        <select multiple="" class="form-control" v-model="userSelect">
                            <option v-for="user in users" :value="'new-action.' + user.id">{{user.email}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <textarea name="" readonly="" cols="30" rows="10" class="form-control">{{dataMessage.join('\n')}}</textarea>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Наберите текст сообщения" v-model="message">
                    <div class="input-group-append">
                        <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Отправить</button>
                    </div>
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
                userSelect: [],
            }
        },
        props: [
            'users',
            'user'
        ],
        created() {
            console.log('Created');
            var socket = io.connect('http://vuelaravel:3000');

            socket.on('new-action.' + this.user.id + ':App\\Events\\PrivateMessage', function (data) {
                console.log(data.message);
                this.dataMessage.push(data.message.user + ": " + data.message.message);
            }.bind(this));

            socket.on('new-action.:App\\Events\\PrivateMessage', function (data) {
                console.log(data.message);
                this.dataMessage.push(data.message.user + ": " + data.message.message);
            }.bind(this));

        },
        methods: {
            sendMessage: function () {

                if(!this.userSelect.length)
                    this.userSelect.push('new-action.');

                axios({
                    method: 'get',
                    url: '/start/send-private-message',
                    params: {channels: this.userSelect, message: this.message, user: this.user.email}
                }).then((response) => {
                    console.log(response);
                    this.dataMessage.push(this.user.email + ':' + this.message);
                    app.message = "";
                });
            }
        }
    }
</script>
