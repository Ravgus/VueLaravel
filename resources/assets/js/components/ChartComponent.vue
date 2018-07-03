<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <line-chart :chart-data="data" :height="100" :options="{responsive:true, maintainAspectRation: true}"></line-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './LineChart.js'

    export default {
        components: {
            LineChart
        },
        data: function() {
            return {
                data: []
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.update();
        },
        methods: {
            update: function () {

                axios.get('/start/data-chart').then((response) => {
                    console.log(response);
                    this.data = response.data;
                });
            }
        }
    }
</script>
