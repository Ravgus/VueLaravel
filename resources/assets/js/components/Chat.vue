<template>
    <div class="container">
        <hr>
        <div class="row">
            <textarea readonly="" cols="30" rows="10" class="form-control">{{messages.join('\n')}}</textarea>
            <hr>
            <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              messages: [],
              textMessage: ''
          }
        },
        mounted() {
            console.log('Component mounted.');

            window.Echo.channel('chat').listen('Message', ({message}) => {
                this.messages.push(message);
            });
        },
        methods: {
            sendMessage() {
                axios.post('/messages', { body: this.textMessage });
                this.messages.push(this.textMessage);
                this.textMessage = "";
            }
        }
    }
</script>
